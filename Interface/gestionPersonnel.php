<?php
ob_start();
include "connect.php";
include "header.php";

// Required field names
$required = array('nom', 'prenom', 'adresse', 'club');

// Loop over field names, make sure each one exists and is not empty
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

    $requete_perso = "update PERSONNEL set  ID_CLUB= ".$club." where ID_PERSONNEL = ?;";
                
    $requete_ind = "update INDIVIDU
                set NOM_INDIVIDU = '".$nom."', PRENOM_INDIVIDU = '".$prenom."', ADRESSE = '".$adresse."'
                where ID_INDIVIDU = ?;";

    if($res_perso = $connection->prepare($requete_perso)){
        $res_perso->bind_param('i', $id);
        $res_perso->execute();
        if ( $res_ind = $connection->prepare($requete_ind) ) {
            $res_ind->bind_param('i', $id);
            $res_ind->execute();
        } else {
        console_log("erreur de requete update");
        }
    } else {
        console_log("erreur de requete update");
    }
    
} else if (isset($_GET['new'])) {
    $requete_ind = "insert into INDIVIDU (NOM_INDIVIDU, PRENOM_INDIVIDU, ADRESSE) 
                values (\"".$nom."\", \"".$prenom."\", \"".$adresse."\");";
    
    if($res_ind = $connection->prepare($requete_ind)) {
        $res_ind->execute();
        $new_id = $connection->insert_id;
            
        $requete_perso = "insert into PERSONNEL (ID_PERSONNEL, ID_CLUB) 
                            values (".$new_id.", ".$club."); ";

        if($res_perso = $connection->query($requete_perso)) {
            console_log("done");
        } else {
            console_log("erreur de requete d\'ajout1");
        }
    } else 
        console_log("erreur de requete d\'ajout2");

}
$connection->close();
header("Location: personnels.php");
ob_enf_flush();
exit();
?>
