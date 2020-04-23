<?php

// This connects to the database
require_once("./api/connect-to-mysql.php");
// This is a query string to be given to the database
$sql = "SELECT * FROM queue ORDER BY date_added DESC LIMIT 100"; 
// Empty array to store the results
$print_rows = array();
// Run the query and if results put them into the array
if ($result = $mysqli->query($sql)) {
  while ($row = $result->fetch_assoc()) {
    array_push($print_rows, $row);
  }
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
      <h1 class="display-4">Print Queue</h1>
    </div>
    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col">File Name</th>
          <th scope="col">Owner</th>
          <th scope="col">GCode Flavour</th>
          <th scope="col">Material</th>
          <th scope="col">Filament required (mm)</th>
          <th scope="col">Date added</th>
          <th scope="col">Status</th>
          <th scope="col">Date printed</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // echo the array out into the table
          foreach ($print_rows as $row) {
            echo("
              <tr>
                <td>".$row["filename"]."</td>
                <td>".$row["owner"]."</td>
                <td>".$row["gcode_flavour"]."</td>
                <td>".$row["material_required"]."</td>
                <td>".$row["material_length_required"]."</td>
                <td>".$row["date_added"]."</td>
                <td>".$row["status"]."</td>
                <td>".$row["date_printed"]."</td>
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