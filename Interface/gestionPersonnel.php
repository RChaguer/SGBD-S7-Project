<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('nom', 'prenom', 'adresse', 'club');

$error = !(isset($_GET['id_perso']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: personnels.php");
  exit();
}

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$adresse = $_POST["adresse"];
$club = $_POST["club"];
if (isset($_GET['id_perso'])) {
    $id = $_GET["id_perso"];

    $requete_perso = "update PERSONNEL set  ID_CLUB= ? where ID_PERSONNEL = ?;";
                
    $requete_ind = "update INDIVIDU
                set NOM_INDIVIDU = ?, PRENOM_INDIVIDU = ?, ADRESSE = ?
                where ID_INDIVIDU = ?;";

    if($res_perso = $connection->prepare($requete_perso)){
        $res_perso->bind_param('ii', $club, $id);
        $res_perso->execute();
        if ( $res_ind = $connection->prepare($requete_ind) ) {
            $res_ind->bind_param('sssi', $nom, $prenom, $adresse, $id);
            $res_ind->execute();
        } else {
        console_log("erreur de requete update");
        }
    } else {
        console_log("erreur de requete update");
    }
    
} else if (isset($_GET['new'])) {
    $requete = "call INSERER_PERSONNEL(?, ?, ?, ?);";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('sssi', $nom, $prenom, $adresse, $club);
        $res->execute();
    } else 
        console_log("erreur de requete d\'ajout2");
}
$connection->close();
header("Location: personnels.php");
ob_enf_flush();
exit();
?>
