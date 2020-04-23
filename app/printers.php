<?php

// Query the database for printers
require_once("./api/connect-to-mysql.php");
$sql = "SELECT printer_id, name, owner, material, status FROM printers LIMIT 100"; 
$printers = array();
if ($result = $mysqli->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    array_push($printers, $row);
  }
  // Bath MySQL does not have fecth all
  // $printers = $result->fetch_all(MYSQLI_ASSOC);
}
$mysqli->close();

?>

<!DOCTYPE html>
<html>
<?php echo(file_get_contents("includes/head.html")); ?>

<body>
  <?php echo(file_get_contents("includes/navbar.html")); ?>

  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Printer Status</h1>
    </div>

    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col">Printer</th>
          <th scope="col">Owner</th>
          <th scope="col">Material</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($printers as $printer) {
            echo("
              <tr>
                <td>".$printer["name"]."</td>
                <td>".$printer["owner"]."</td>
                <td>".$printer["material"]."</td>
                <td>".$printer["status"]."</td>
              </tr>
            ");
          }
        ?>
      </tbody>
    </table>

  </div>

  <?php echo(file_get_contents("includes/footer.html")); ?>
</body>

<?php echo(file_get_contents("includes/bootstrap-scripts.html")); ?>

</html>