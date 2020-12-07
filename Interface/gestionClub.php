<?php
ob_start();
include "connect.php";
include "header.php";



$required = array('nom','date');

$error = !(isset($_GET['id_club']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: clubs.php");
  ob_enf_flush();
  exit();
}

$nom = $_POST["nom"];
$date = $_POST["date"];
if (isset($_GET['id_club'])) {
    $id = $_GET["id_club"];

    $requete = "update CLUB
                set DATE_CREATION = ?, NOM_CLUB = ?
                where ID_CLUB = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('ssi', $date, $nom, $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
} else if (isset($_GET['new'])) {
    $requete = "insert into CLUB (NOM_CLUB, DATE_CREATION)
                values ( ?, ?);";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('ss', $date, $nom);
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
}
$connection->close();
header("Location: clubs.php");
ob_enf_flush();
exit();

?>
