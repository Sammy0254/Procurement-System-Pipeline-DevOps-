<?php
require_once('includes/load.php');

// Fetch the summary data
function get_usage_summary() {
    global $db;

    // Total items issued
    $issued_sql = "SELECT SUM(quantity) AS total_issued FROM issuances";
    $issued_result = $db->query($issued_sql);
    $total_issued = $issued_result->fetch_assoc()['total_issued'] ?? 0;

    // Total items returned
    $returned_sql = "SELECT SUM(quantity) AS total_returned FROM `return`";  // Ensure `return` is correct
    $returned_result = $db->query($returned_sql);
    $total_returned = $returned_result->fetch_assoc()['total_returned'] ?? 0;

    // Total items damaged/lost
    $damaged_sql = "SELECT COUNT(*) AS total_damaged FROM maintenance_schedule";  // Reference the correct table name
    $damaged_result = $db->query($damaged_sql);
    $total_damaged = $damaged_result->fetch_assoc()['total_damaged'] ?? 0;

    return [
        'total_issued' => $total_issued,
        'total_returned' => $total_returned,
        'total_damaged' => $total_damaged,
    ];
}


$usage_summary = get_usage_summary();

// Fetch detailed usage report data
function get_usage_report() {
    global $db;
    $sql = "SELECT items.name AS item_name, 
                   items.receipt_number, 
                   items.quantity AS quantity, 
                   items.price, 
                   (items.quantity * items.price) AS cost, 
                   items.supplier, 
                   items.date_added, 
                   items.min_stock_level, 
                   items.supplier_contact
            FROM items
            ORDER BY items.date_added DESC";
    return $db->query($sql);
}

$usage_report = get_usage_report();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usage Report - Narok Law Courts</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include('layouts/header.php'); ?>
    
    <div class="report-container">
        <h2>Detailed Usage Report</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
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
                <?php if ($usage_report && $usage_report->num_rows > 0): ?>
                    <?php while ($row = $usage_report->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['receipt_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['cost'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($row['min_stock_level']); ?></td>
                            <td><?php echo htmlspecialchars($row['supplier_contact']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include('layouts/footer.php'); ?>
</body>
</html>
