<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Schedule Maintenance';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db; // Ensure the global $db variable is accessible

$message = '';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $item_id = $_POST['item_id'];
    $scheduled_date = $_POST['scheduled_date'];
    $details = $_POST['details'];

    // Validate inputs
    if (empty($item_id) || empty($scheduled_date) || empty($details)) {
        $message = "All fields are required.";
    } else {
        // Insert maintenance schedule into database
        $sql = "INSERT INTO maintenance_schedules (item_id, scheduled_date, details) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iss', $item_id, $scheduled_date, $details);
        
        if ($stmt->execute()) {
            $message = "Maintenance scheduled successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all items for the form
$sql = "SELECT id, name FROM items";
$result = $db->query($sql);

if (!$result) {
    // Handle query error
    $_SESSION['error'] = "Failed to retrieve items: " . $db->error;
    header('Location: index.php');
    exit();
}

$items = $result->fetch_all(MYSQLI_ASSOC);

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php if (!empty($message)) echo "<p class='alert alert-info'>$message</p>"; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-calendar"></span>
                    <span>Schedule Maintenance</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="schedule_maintenance.php" method="POST">
                    <div class="form-group">
                        <label for="item_id">Item:</label>
                        <select name="item_id" id="item_id" class="form-control" required>
                            <?php foreach ($items as $item): ?>
                                <option value="<?= htmlspecialchars($item['id']) ?>"><?= htmlspecialchars($item['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="scheduled_date">Scheduled Date:</label>
                        <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea name="details" id="details" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Schedule Maintenance</button>
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
