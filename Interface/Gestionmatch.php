<?php
ob_start();
include "connect.php";
include "header.php";

$error = !((isset($_GET['match']) && (isset($_GET["delete"]) || isset($_GET["update"]) )) || isset($_GET['new']));

if (! isset($_GET["delete"])) {
    $required = array('id_home','id_away', 'date', 'saison', 'stade');

    foreach($required as $field) {
      if (empty($_POST[$field])) {
        $error = true;
      }
    }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: matchs.php");
  ob_enf_flush();
  exit();
}


if (isset($_GET['delete'])) {
    $id = $_GET["match"];
    
    $requete = "delete from RENCONTRE
                where ID_RENCONTRE = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    } else {
        console_log("Erreur Delete");
    }
        
} else {
    $id_home = $_POST["id_home"];
    $id_away = $_POST["id_away"];
    $date = $_POST["date"];
    $saison = $_POST["saison"];
    $stade = $_POST["stade"];

    if (isset($_GET['update'])) {
        $id = $_GET["match"];

        $requete = "update RENCONTRE
                    set ID_SAISON = ".$saison.", ID_STADE = ".$stade.", ID_EQUIPE_R = ".$id_home.", ID_EQUIPE_V = ".$id_away.", DATE_RENCONTRE = '".$date."'
                    where ID_RENCONTRE = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
    } else if (isset($_GET['new'])) {
    $requete = "insert into RENCONTRE (ID_SAISON, ID_STADE, ID_EQUIPE_R, ID_EQUIPE_V, DATE_RENCONTRE)
                values (".$saison.", ".$stade.", ".$id_home.", ".$id_away.", '".$date."');";

    if($res = $connection->prepare($requete)) {
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
    }
}
$connection->close();
header("Location: matchs.php");
ob_enf_flush();
exit();
?>
