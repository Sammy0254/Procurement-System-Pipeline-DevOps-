<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Record Maintenance';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db;

$message = '';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $schedule_id = $_POST['schedule_id'];
    $actual_date = date('Y-m-d'); // Current date
    $notes = $_POST['notes'];

    // Validate inputs
    if (empty($schedule_id) || empty($notes)) {
        $message = "All fields are required.";
    } else {
        // Insert maintenance record into database
        $sql = "INSERT INTO maintenance_records (schedule_id, actual_date, notes) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('iss', $schedule_id, $actual_date, $notes);
        
        if ($stmt->execute()) {
            $message = "Maintenance recorded successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all maintenance schedules for the form
$sql = "SELECT ms.id, i.name as item_name, ms.scheduled_date, ms.details
        FROM maintenance_schedules ms
        JOIN items i ON ms.item_id = i.id";
$result = $db->query($sql);

if ($result && $result->num_rows > 0) {
    $schedules = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $schedules = []; // Default to an empty array if no results
}

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-edit"></span>
                    <span>Record Maintenance</span>
                </strong>
            </div>
            <div class="panel-body">
                <form action="record_maintenance.php" method="POST">
                    <div class="form-group">
                        <label for="schedule_id">Maintenance Schedule:</label>
                        <select name="schedule_id" id="schedule_id" class="form-control" required>
                            <?php foreach ($schedules as $schedule): ?>
                                <option value="<?= htmlspecialchars($schedule['id']) ?>"><?= htmlspecialchars($schedule['item_name']) ?> - <?= htmlspecialchars($schedule['scheduled_date']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes:</label>
                        <textarea name="notes" id="notes" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Record Maintenance</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
