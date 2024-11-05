<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'View Maintenance Schedules';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db;

// Fetch all maintenance schedules
$sql = "SELECT ms.id, i.name as item_name, ms.scheduled_date, ms.details
        FROM maintenance_schedules ms
        JOIN items i ON ms.item_id = i.id";

$result = $db->query($sql);

if (!$result) {
    // Handle query error
    $_SESSION['error'] = "Failed to retrieve maintenance schedules: " . $db->error();
    header('Location: index.php');
    exit();
}

$schedules = $result->fetch_all(MYSQLI_ASSOC);

include_once('layouts/header.php');
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-calendar"></span>
                    <span>View Maintenance Schedules</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Scheduled Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($schedules) > 0): ?>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?= htmlspecialchars($schedule['id']) ?></td>
                                    <td><?= htmlspecialchars($schedule['item_name']) ?></td>
                                    <td><?= htmlspecialchars($schedule['scheduled_date']) ?></td>
                                    <td><?= htmlspecialchars($schedule['details']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No maintenance schedules found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
