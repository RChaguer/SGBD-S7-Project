<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('nom', 'prenom', 'adresse', 'num_lic', 'date');

$error = !(isset($_GET['id_joueur']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: joueurs.php");
  ob_enf_flush();
  exit();
}

$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$adresse = $_POST["adresse"];
$num_lic = $_POST["num_lic"];
$date = $_POST["date"];
if (isset($_GET['id_joueur'])) {
    $id = $_GET["id_joueur"];

    $requete_jou = "update JOUEUR set NUMERO_LICENCE = ?, DATE_NAISSANCE = ? where ID_JOUEUR = ?;";
                
    $requete_ind = "update INDIVIDU
                set NOM_INDIVIDU = ?, PRENOM_INDIVIDU = ?, ADRESSE = ?
                where ID_INDIVIDU = ?;";
    if($res_jou = $connection->prepare($requete_jou)){
        $res_jou->bind_param('isi', $num_lic, $date, $id);
        $res_jou->execute();
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
    $requete_jou = "call INSERER_JOUEUR(?, ?, ?, ?, ?);";
    if($res_jou = $connection->prepare($requete_jou)) {
        $res_jou->bind_param('sssis', $nom, $prenom, $adresse, $num_lic, $date);
        $res_jou->execute();
    } else 
        console_log("erreur de requete d\'ajout");

}
$connection->close();
/*header("Location: joueurs.php");
ob_enf_flush();
exit();*/
?>
