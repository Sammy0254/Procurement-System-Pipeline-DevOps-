<?php
$page_title = 'Issue Item';
require_once('includes/load.php');
page_require_level(1);

if (isset($_POST['issue'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $issued_to = $_POST['issued_to'];
    $issue_date = $_POST['issue_date'];

    // Check if the item is available
    $item = find_by_id('items', $item_id);
    if ($item['quantity'] >= $quantity) {
        // Deduct the quantity from the items table
        $new_quantity = $item['quantity'] - $quantity;
        $update_item_sql = "UPDATE items SET quantity=? WHERE id=?";
        $stmt = $conn->prepare($update_item_sql);
        $stmt->bind_param("ii", $new_quantity, $item_id);
        $stmt->execute();

        // Insert into issuances table
        $insert_issuance_sql = "INSERT INTO issuances (item_id, quantity, issued_to, issue_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_issuance_sql);
        $stmt->bind_param("iiss", $item_id, $quantity, $issued_to, $issue_date);

        if ($stmt->execute()) {
            $session->msg('s', "Item issued successfully.");
        } else {
            $session->msg('d', "Failed to issue item.");
        }
        $stmt->close();
    } else {
        $session->msg('d', "Not enough items.");
    }
}

$all_items = find_all('items');

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
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-indent-left"></span>
                    <span>Issue Item</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="issue_item.php">
                    <div class="form-group">
                        <label for="item_id">Item</label>
                        <select class="form-control" name="item_id" required>
                            <?php foreach ($all_items as $item): ?>
                                <option value="<?php echo (int)$item['id']; ?>">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="issued_to">Issued To</label>
                        <input type="text" class="form-control" name="issued_to" required>
                    </div>
                    <div class="form-group">
                        <label for="issue_date">Issue Date</label>
                        <input type="date" class="form-control" name="issue_date" required>
                    </div>
                    <button type="submit" name="issue" class="btn btn-primary">Issue Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
