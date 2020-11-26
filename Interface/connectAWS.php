<?php
  $host = 'handball.cyeieakhk6yt.us-east-1.rds.amazonaws.com';
  $login = 'admin';
  $db_pwd = 'sgbd2020';
  $base_name = 'HANDBALL' ;
  /* Creation de l'objet qui gere la connexion: */
  $connection = new mysqli($host, $login, $db_pwd, $base_name);

  if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
  }
?>