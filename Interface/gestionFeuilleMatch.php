<?php
ob_start();
include "connect.php";
include "header.php";

$error = !((isset($_GET['particip']) && (isset($_GET["delete"]) || isset($_GET["update"]) )) || isset($_GET['new']));

if (! isset($_GET["delete"])) {
    $required = array('joueur', 'poste');

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
    $id = $_GET["particip"];
    
    $requete = "delete from PARTICIPATION
                where ID_PARTICIPATION = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    } else {
        console_log("Erreur Delete");
    }
        
} else {
    $id_joueur = $_POST["joueur"];
    $id_poste = $_POST["poste"];
    $but = $_POST["but"];
    $faute = $_POST["faute"];

    if (isset($_GET['update'])) {
        $id = $_GET["particip"];

        $requete = "update PARTICIPATION
                    set ID_JOUEUR = ".$id_joueur.", ID_POSTE = ".$id_poste.", NOMBRE_BUT = ".$but.", NOMBRE_FAUTE = ".$faute."
                    where ID_PARTICIPATION = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
    } else if (isset($_GET['new'])) {
        $id = $_GET["match"];
        $requete = "insert into PARTICIPATION (ID_JOUEUR, ID_RENCONTRE, ID_POSTE, NOMBRE_BUT, NOMBRE_FAUTE)
                values (".$id_joueur.", ".$id.", ".$id_poste.", ".$but.", ".$faute.");";

    if($res = $connection->prepare($requete)) {
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
    }
}

$connection->close();
header("Location: feuilleMatch.php?match=".$_GET["match"]."");
ob_enf_flush();
exit();
?>