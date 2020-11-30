<?php
ob_start();
include "connect.php";
include "header.php";

// Required field names
$required = array('nom');

// Loop over field names, make sure each one exists and is not empty
$error = !(isset($_GET['id_role']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: roles.php");
  ob_enf_flush();
  exit();
}

$nom = $_POST["nom"];

if (isset($_GET['id_role'])) {
    $id = $_GET["id_role"];

    $requete = "update ROLE set  NOM_ROLE = \"".$nom."\" where ID_ROLE = ?;";

    if($res = $connection->prepare($requete)){
        $res->bind_param('i', $id);
        $res->execute();
    } else {
        console_log("erreur de requete update");
    }
    
} else if (isset($_GET['new'])) {
    $requete = "insert into ROLE (NOM_ROLE) 
                values (\"".$nom."\");";
    
    if($res = $connection->prepare($requete)) {
        $res->execute();
    } else 
        console_log("erreur de requete d\'ajout");

}
$connection->close();
header("Location: roles.php");
ob_enf_flush();
exit();
?>
