<?php

require_once("fcns/check-ip.php");
$ip = getRealIpAddr();
require_once("fcns/permitted-access.php");

?>

<!DOCTYPE html>
<html>
<?php echo(file_get_contents("includes/head.html")); ?>

<body>
  <?php echo(file_get_contents("includes/uob-navbar.html")); ?>

  <div class="container">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Remove Print</h5>
        <p class="card-text">Please confirm that you want to remove print XX.</p>
        <button class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>

  <?php echo(file_get_contents("includes/footer.html")); ?>
</body>

<?php echo(file_get_contents("includes/bootstrap-scripts.html")); ?>

</html>