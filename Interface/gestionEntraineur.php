<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('nom', 'prenom', 'adresse');

$error = !(isset($_GET['id_entrain']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: entraineurs.php");
    ob_enf_flush();
  exit();
}

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$adresse = $_POST["adresse"];

if (isset($_GET['id_entrain'])) {
    $id = $_GET["id_entrain"];
                
    $requete_ind = "update INDIVIDU
                set NOM_INDIVIDU = ?, PRENOM_INDIVIDU = ?, ADRESSE = ?
                where ID_INDIVIDU = ?;";

    if ( $res_ind = $connection->prepare($requete_ind) ) {
        $res_ind->bind_param('sssi', $nom, $prenom, $adresse, $id);
        $res_ind->execute();
    } else {
        console_log("erreur de requete update");
    }
    
 
} else if (isset($_GET['new'])) {
    $requete = "call INSERER_ENTRAINEUR(?, ?, ?);";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('sss', $nom, $prenom, $adresse);
        $res->execute();
    } else 
        console_log("erreur de requete d\'ajout");
}
$connection->close();
header("Location: entraineurs.php");
ob_enf_flush();
exit();
?>
