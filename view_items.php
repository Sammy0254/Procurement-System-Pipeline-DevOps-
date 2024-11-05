<?php
$page_title = 'View Items';
require_once('includes/load.php');
page_require_level(1);

$search_term = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $db->escape($_GET['search']);
    // Search only by existing columns
    $items = $db->query("SELECT * FROM items WHERE name LIKE '%$search_term%'");
} else {
    $items = find_all('items'); // Ensure this function fetches the correct columns
}

include_once('layouts/header.php');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Items List</span>
                </strong>
                <form action="view_items.php" method="get" class="form-inline pull-right">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="<?php echo htmlspecialchars($search_term); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <a href="add_items.php" class="btn btn-info pull-right btn-sm" style="margin-right: 10px;">Add New Item</a>
            </div>
            <div class="panel-body">
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
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach ($items as $item): 
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td><?php echo htmlspecialchars($item['receipt_number']); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($item['price']); ?></td>
                            <td><?php echo htmlspecialchars($item['cost']); ?></td>
                            <td><?php echo htmlspecialchars($item['supplier']); ?></td>
                            <td><?php echo htmlspecialchars($item['date_added']); ?></td>
                            <td><?php echo htmlspecialchars($item['min_stock_level']); ?></td>
                            <td><?php echo htmlspecialchars($item['supplier_contact']); ?></td>
                            <td>
                                <a href="edit_item.php?item_id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                            </td>
                            <td>
                                <a href="delete_item.php?item_id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">
                                    <i class="fa fa-trash"></i> Delete
                                </a>
                            </td>
                            <td>
                                <a href="item_details.php?item_id=<?php echo $item['id']; ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-info-circle"></i> Details
                                </a>
                            </td>
                        </tr>
                        <?php 
                        $i++;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
