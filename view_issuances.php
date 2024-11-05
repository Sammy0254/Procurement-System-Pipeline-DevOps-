<?php
  require_once('includes/load.php');
  
  // Check if the user is logged in
  if(!$session->isUserLoggedIn(true)) { redirect('index.php', false); }


  function find_all_issuances() {
    global $db;
    $sql = "SELECT i.id, it.name AS item_name, i.quantity, i.issued_to, i.date_issued 
            FROM issuances i
            JOIN items it ON i.item_id = it.id";
    return $db->query($sql);
  }
  


  $all_issuances = find_all_issuances();
?>

<?php include_once('layouts/header.php'); ?>

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
          <span>All Issuances</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th class="text-center">#</th>
              <th class="text-center">Item Name</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Issued To</th>
              <th class="text-center">Issue Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($all_issuances): ?>
              <?php foreach ($all_issuances as $issuance): ?>
              <tr>
                <td class="text-center"><?php echo (int)$issuance['id']; ?></td>
                <td class="text-center"><?php echo remove_junk($issuance['item_name']); ?></td>
                <td class="text-center"><?php echo (int)$issuance['quantity']; ?></td>
                <td class="text-center"><?php echo remove_junk($issuance['issued_to']); ?></td>
                <td class="text-center"><?php echo read_date($issuance['date_issued']); ?></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">No Issuances Found</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
