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
    if (empty($_POST["date_f"])) {
        $requete = "update HISTORIQUE
                set ID_SPORTIF = ?, ID_EQUIPE = ?, DATE_DEBUT = ?, DATE_FIN = null
                where ID_HISTORIQUE = ?;";
        if($res = $connection->prepare($requete)) {
            $res->bind_param('iisi', $id_sportif, $id_equipe, $date_d, $id);
            $res->execute();
        } else {
            console_log("error de requete update");
        }
    } else {
        $requete = "update HISTORIQUE
                set ID_SPORTIF = ?, ID_EQUIPE = ?, DATE_DEBUT = ?, DATE_FIN = ?
                where ID_HISTORIQUE = ?;";
        if($res = $connection->prepare($requete)) {
            $res->bind_param('iissi', $id_sportif, $id_equipe, $date_d, $date_f, $id);
            $res->execute();
        } else {
           console_log("error de requete update");
        }
    }

} else if (isset($_GET['new'])) {
    if (empty($_POST["date_f"])) {
        $requete = "insert into HISTORIQUE (ID_SPORTIF, ID_EQUIPE, DATE_DEBUT)
                values (?, ?, ?);";
        if($res = $connection->prepare($requete)) {
            $res->bind_param('iis', $id_sportif, $id_equipe, $date_d);
            $res->execute();
        } else {
            console_log("error de requete d'ajout");
        }
    } else {
        $requete = "insert into HISTORIQUE (ID_SPORTIF, ID_EQUIPE, DATE_DEBUT, DATE_FIN)
                values (?, ?, ?, ?);";
        if($res = $connection->prepare($requete)) {
            $res->bind_param('iiss', $id_sportif, $id_equipe, $date_d, $date_f);
            $res->execute();
        } else {
            console_log("error de requete d'ajout");
    }
    }

}
$connection->close();
header("Location: historique.php");
ob_enf_flush();
exit();
?>
