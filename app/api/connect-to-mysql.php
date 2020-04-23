<?php


  $mysqli = new mysqli(
    getenv('ARP_DB_HOST'),
    getenv('ARP_DB_USERNAME'),
    getenv('ARP_DB_PASSWORD'),
    getenv('ARP_DB_DATABASE')
  );

  if (mysqli_connect_error()) {
    die("Connect Error (".mysqli_connect_errno().") ".mysqli_connect_error());
  }
?>