<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$page_title = 'Stock Report';
require_once('includes/load.php');
page_require_level(1);

global $db;

function get_stock_report() {
    $sql = "SELECT * FROM items";  // Use 'items' table instead of 'products'
    return $GLOBALS['db']->query($sql);
}

function get_stock_summary() {
    $sql = "SELECT 
                COUNT(*) AS total_items,
                SUM(quantity * price) AS total_value,  
                SUM(CASE WHEN quantity < min_stock_level THEN 1 ELSE 0 END) AS items_below_reorder
            FROM items";
    return $GLOBALS['db']->query($sql);
}

$stock_report = get_stock_report();
$stock_summary = get_stock_summary()->fetch_assoc();

include_once('layouts/header.php');
?>

<!-- Print-specific CSS -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    .printableArea, .printableArea * {
        visibility: visible;
    }
    .printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12 printableArea">
        <div class="panel panel-default">
            <div class="panel-heading no-print">
                <strong>
                    <span class="glyphicon glyphicon-th-list"></span>
                    <span>Stock Report</span>
                </strong>
                <a href="javascript:window.print()" class="btn btn-default pull-right">Print Report</a>
            </div>
            <div class="panel-body">
                <h3>Stock Summary</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Total Items in Stock</th>
                            <th>Total Value of Stock</th>
                            <th>Items Below Reorder Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= htmlspecialchars($stock_summary['total_items']) ?></td>
                            <td><?= htmlspecialchars(number_format($stock_summary['total_value'], 2)) ?></td>
                            <td><?= htmlspecialchars($stock_summary['items_below_reorder']) ?></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Detailed Report</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Receipt No</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Cost</th>
                            <th>Supplier</th>
                            <th>Date Added</th>
                            <th>Min Stock Level</th>
                            <th>Supplier Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($stock_report && $stock_report->num_rows > 0): ?>
                            <?php while ($row = $stock_report->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['receipt_number']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['price'], 2)) ?></td>
                                    <td><?= htmlspecialchars(number_format($row['cost'], 2)) ?></td>
                                    <td><?= htmlspecialchars($row['supplier']) ?></td>
                                    <td><?= htmlspecialchars($row['date_added']) ?></td>
                                    <td><?= htmlspecialchars($row['min_stock_level']) ?></td>
                                    <td><?= htmlspecialchars($row['supplier_contact']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
