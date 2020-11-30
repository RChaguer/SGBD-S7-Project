<?php
ob_start();
include "connect.php";
include "header.php";

// Required field names
$required = array('nom', 'prenom', 'adresse');

// Loop over field names, make sure each one exists and is not empty
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
                set NOM_INDIVIDU = '".$nom."', PRENOM_INDIVIDU = '".$prenom."', ADRESSE = '".$adresse."'
                where ID_INDIVIDU = ?;";

    if ( $res_ind = $connection->prepare($requete_ind) ) {
        $res_ind->bind_param('i', $id);
        $res_ind->execute();
    } else {
        console_log("erreur de requete update");
    }
    
 
} else if (isset($_GET['new'])) {
    $requete_ind = "insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
                values (\"".$nom."\", \"".$prenom."\", \"".$adresse."\");";
    
    if($res_ind = $connection->prepare($requete_ind)) {
        $res_ind->execute();
        $new_id = $connection->insert_id;
        $requete_spo = "insert into SPORTIF (ID_SPORTIF) 
                        values (".$new_id."); ";
    
        if($res_spo = $connection->query($requete_spo)) {
            console_log("done");
        } else {
            console_log("erreur de requete d\'ajout");
        }
    } else 
        console_log("erreur de requete d\'ajout");
}
$connection->close();
header("Location: entraineurs.php");
ob_enf_flush();
exit();
?>
