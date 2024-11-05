<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'View Returns';
require_once('includes/load.php');
require_once('includes/sql.php');
require_once('includes/database.php');
page_require_level(1);

global $db;

// Fetch all return records
$sql = "SELECT r.id, i.name as item_name, r.quantity, r.returned_by, r.return_date
        FROM returns r
        JOIN items i ON r.item_id = i.id";
$result = $db->query($sql);

if (!$result) {
    // Handle query error
    $_SESSION['error'] = "Failed to retrieve return records: " . $db->error();
    header('Location: index.php');
    exit();
}

$returns = $result->fetch_all(MYSQLI_ASSOC);

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
                    <span class="glyphicon glyphicon-th"></span>
                    <span>View Returns</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Returned By</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($returns) > 0): ?>
                            <?php foreach ($returns as $return): ?>
                                <tr>
                                    <td><?= htmlspecialchars($return['id']) ?></td>
                                    <td><?= htmlspecialchars($return['item_name']) ?></td>
                                    <td><?= htmlspecialchars($return['quantity']) ?></td>
                                    <td><?= htmlspecialchars($return['returned_by']) ?></td>
                                    <td><?= htmlspecialchars($return['return_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No returns found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
