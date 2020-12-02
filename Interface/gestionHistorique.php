<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('sportif','equipe', 'date_d');

$error = !(isset($_GET['id_histo']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: historique.php");
  ob_enf_flush();
  exit();
}

$id_sportif = $_POST["sportif"];
$id_equipe = $_POST["equipe"];
$date_d = $_POST["date_d"];
$date_f = $_POST["date_f"];

if (isset($_GET['id_histo'])) {
    $id = $_GET["id_histo"];

    $requete = "update HISTORIQUE
                set ID_SPORTIF = ".$id_sportif.", ID_EQUIPE = ".$id_equipe.", DATE_DEBUT = '".$date_d."', DATE_FIN = '".$date_f."'
                where ID_HISTORIQUE = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
} else if (isset($_GET['new'])) {
    if (empty($_POST["date_f"]))
        $requete = "insert into HISTORIQUE (ID_SPORTIF, ID_EQUIPE, DATE_DEBUT)
                values (".$id_sportif.", ".$id_equipe.", '".$date_d."');";
    else 
        $requete = "insert into HISTORIQUE (ID_SPORTIF, ID_EQUIPE, DATE_DEBUT, DATE_FIN)
                values (".$id_sportif.", ".$id_equipe.", '".$date_d."', '".$date_f."');";

    if($res = $connection->prepare($requete)) {
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
}
$connection->close();
header("Location: historique.php");
ob_enf_flush();
exit();
?>
