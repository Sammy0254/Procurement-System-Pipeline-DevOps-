<?php
  require_once('includes/load.php');
  require_once('includes/sql.php');

  page_require_level(1);
  $court_name = 'Procurement System'; // Court Name
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<div class="row">
  <!-- Recent Activities Section -->
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-time"></span>
          <span>Added Items</span>
        </strong>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php
            $recent_added_items = find_recent_added_items();
            foreach ($recent_added_items as $item):
          ?>
            <li class="list-group-item">
              <?php echo remove_junk(first_character($item['name'])); ?>
              <span class="badge"><?php echo $item['date_added']; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-time"></span>
          <span>Recent Issued Items</span>
        </strong>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php
            $recent_issued_items = find_recent_issued_items();
            foreach ($recent_issued_items as $item):
          ?>
            <li class="list-group-item">
              <?php echo remove_junk(first_character($item['name'])); ?>
              <span class="badge"><?php echo $item['date_issued']; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-time"></span>
          <span>Recent Returned Items</span>
        </strong>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php
            $recent_returned_items = find_recent_returned_items();
            foreach ($recent_returned_items as $item):
          ?>
            <li class="list-group-item">
              <?php echo remove_junk(first_character($item['name'])); ?>
              <span class="badge"><?php echo $item['date_returned']; ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>


<?php include_once('layouts/footer.php'); ?>
