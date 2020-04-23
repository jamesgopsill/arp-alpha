<!DOCTYPE html>
<html>
<?php echo(file_get_contents("includes/head.html")); ?>

<body>
  <?php echo(file_get_contents("includes/navbar.html")); ?>

  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Welcome to the Autonomous Rapid Prototyping (ARP) Manufacturing Service</h1>
      <p class="lead">This is an experimental Autonomous Rapid Prototyping (RP) Manufacturing Service where the RP tools, such as 3D printers and laser cutters, have their own in built A.I. and use this to decide which components they will manufacture. The aim is to produce a flexible and scalable platform for RP tools of any shape and size can connect to, and provide RP support for the respective group/organisation. As researchers, we're interested in the strategies to provide an optimum ARP as well as how the A.I. enabled RP tools will resolve the demands of the user base.</p>
      <hr class="my-4">
      <a class="btn btn-primary btn-lg" href="./about.php" role="button">Learn more</a>
    </div>
  </div>

  


  <?php echo(file_get_contents("includes/footer.html")); ?>
</body>

<?php echo(file_get_contents("includes/bootstrap-scripts.html")); ?>



</html>