<?php
  $host = 'localhost';
  $login = 'root';
  $db_pwd = NULL;
  $base_name = 'handball' ;

  $connection = new mysqli($host, $login, $db_pwd, $base_name);

  if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
  }
?>