<?php
$page_title = 'Edit Item';
require_once('includes/load.php');
page_require_level(1);
require_once('includes/config.php');

$msg = []; // Initialize the message variable as an array

if (isset($_POST['update'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $receipt_number = $_POST['receipt_number'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $supplier = $_POST['supplier'];
    $date_added = $_POST['date_added'];
    $min_stock_level = $_POST['min_stock_level'];
    $supplier_contact = $_POST['supplier_contact'];

    // Update statement with correct type definitions
    $sql = "UPDATE items SET name=?, receipt_number=?, quantity=?, price=?, cost=?, supplier=?, date_added=?, min_stock_level=?, supplier_contact=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssiddsssii", $item_name, $receipt_number, $quantity, $price, $cost, $supplier, $date_added, $min_stock_level, $supplier_contact, $item_id);

    if ($stmt->execute()) {
        $msg[] = "Item updated successfully.";
    } else {
        $msg[] = "Error updating item: " . $stmt->error;
    }

    $stmt->close();
}

$item = null;
if (isset($_GET['item_id'])) {
    $item_id = $_GET['item_id'];
    $sql = "SELECT * FROM items WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();

    $stmt->close();
}

if (!$item) {
    $msg[] = "Item not found.";
    redirect('view_items.php');
}

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
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span>Edit Item</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_item.php" class="form-horizontal">
                    <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                    <div class="form-group">
                        <label for="item_name" class="col-sm-2 control-label">Item Name:</label>
                        <div class="col-sm-10">
                            <input type="text" name="item_name" class="form-control" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="receipt_number" class="col-sm-2 control-label">Receipt Number:</label>
                        <div class="col-sm-10">
                            <input type="text" name="receipt_number" class="form-control" value="<?php echo htmlspecialchars($item['receipt_number']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Quantity:</label>
                        <div class="col-sm-10">
                            <input type="number" name="quantity" class="form-control" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price:</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($item['price']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cost" class="col-sm-2 control-label">Cost:</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" name="cost" class="form-control" value="<?php echo htmlspecialchars($item['cost']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supplier" class="col-sm-2 control-label">Supplier:</label>
                        <div class="col-sm-10">
                            <input type="text" name="supplier" class="form-control" value="<?php echo htmlspecialchars($item['supplier']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_added" class="col-sm-2 control-label">Date Added:</label>
                        <div class="col-sm-10">
                            <input type="date" name="date_added" class="form-control" value="<?php echo htmlspecialchars($item['date_added']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_stock_level" class="col-sm-2 control-label">Min Stock Level:</label>
                        <div class="col-sm-10">
                            <input type="number" name="min_stock_level" class="form-control" value="<?php echo htmlspecialchars($item['min_stock_level']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supplier_contact" class="col-sm-2 control-label">Supplier Contact:</label>
                        <div class="col-sm-10">
                            <input type="text" name="supplier_contact" class="form-control" value="<?php echo htmlspecialchars($item['supplier_contact']); ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" name="update" class="btn btn-primary" value="Update Item">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<?php
// Correct the JavaScript for calculating cost
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.querySelector('input[name="quantity"]');
    const priceInput = document.querySelector('input[name="price"]');
    const costInput = document.querySelector('input[name="cost"]');

    function updateCost() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        costInput.value = (quantity * price).toFixed(2);
    }

    quantityInput.addEventListener('input', updateCost);
    priceInput.addEventListener('input', updateCost);
    updateCost(); // Initialize cost on page load
});
</script>
