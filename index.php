<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
      <h4>THE JUDICIARY OF KENYA</h4>
      <img src="logo.jpeg" alt="Judiciary Logo" style="width:100px;height:auto;">
      <h4>NAROK COURTS PROCUREMENT SYSTEM</h4>
      <h2>Login</h2>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="auth.php" class="clearfix">
      <div class="form-group">
        <label for="username" class="control-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Username" required>
      </div>
      <div class="form-group">
        <label for="password" class="control-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
      </div>
    </form>
    <div class="text-center">
      <a href="forgot_password.php" class="btn btn-link">Forgot Password?</a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
