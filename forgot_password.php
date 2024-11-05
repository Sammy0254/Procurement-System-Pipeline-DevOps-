<?php
  ob_start();
  require_once('includes/load.php');
  require_once('includes/config.php');

  if($session->isUserLoggedIn(true)) { redirect('home.php', false); }

  $msg = []; // Initialize the message variable as an array

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = $_POST['email'];

      // Validate email
      if (empty($email)) {
          $msg[] = "Email address is required.";
      } else {
          // Check if email exists in the database
          $sql = "SELECT id FROM users WHERE email=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $stmt->store_result();

          if ($stmt->num_rows > 0) {
              // Generate a unique reset token
              $token = bin2hex(random_bytes(50));
              $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token valid for 1 hour

              // Store token and expiry in the database
              $sql = "INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token=?, expiry=?";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("sssss", $email, $token, $expiry, $token, $expiry);
              $stmt->execute();

              // Send reset link to user
              $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
              $message = "Click the following link to reset your password: $reset_link";
              mail($email, "Password Reset Request", $message);

              $msg[] = "A password reset link has been sent to your email.";
          } else {
              $msg[] = "Email address not found.";
          }
      }
  }
?>

<?php include_once('layouts/header.php'); ?>
<div class="forgot-password-page">
    <div class="text-center">
        <h4>THE JUDICIARY OF KENYA</h4>
        <img src="logo.jpeg" alt="Judiciary Logo" style="width:100px;height:auto;">
        <h2>Forgot Password</h2>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="forgot_password.php" class="clearfix">
        <div class="form-group">
            <label for="email" class="control-label">Email Address</label>
            <input type="email" class="form-control" name="email" placeholder="Email Address" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-danger" style="border-radius:0%">Send Reset Link</button>
        </div>
    </form>
    <div class="text-center">
      <a href="index.php" class="btn btn-link">Back to Login</a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
