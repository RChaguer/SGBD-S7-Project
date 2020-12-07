<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('nom');

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

    $requete = "update ROLE set  NOM_ROLE = ? where ID_ROLE = ?;";

    if($res = $connection->prepare($requete)){
        $res->bind_param('si', $nom, $id);
        $res->execute();
    } else {
        console_log("erreur de requete update");
    }
    
} else if (isset($_GET['new'])) {
    $requete = "insert into ROLE (NOM_ROLE) 
                values (?);";
    
    if($res = $connection->prepare($requete)) {
        $res->bind_param('s', $nom);
        $res->execute();
    } else 
        console_log("erreur de requete d\'ajout");

}
$connection->close();
header("Location: roles.php");
ob_enf_flush();
exit();
?>
