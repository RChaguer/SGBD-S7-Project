<?php
include "connect.php";
include "header.php";

// Required field names
$required = array('nom','club', 'cat');

// Loop over field names, make sure each one exists and is not empty
$error = !(isset($_GET['id_equipe']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: equipes.php");
  exit();
}

$nom = $_POST["nom"];
$id_club = $_POST["club"];
$id_cat = $_POST["cat"];
if (isset($_GET['id_equipe'])) {
    $id = $_GET["id_equipe"];

    $requete = "update EQUIPE
                set ID_CATEGORIE = ".$id_cat.", ID_CLUB = ".$id_club.", NOM_EQUIPE = '".$nom."'
                where ID_EQUIPE = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
} else if (isset($_GET['new'])) {
    $requete = "insert into EQUIPE (NOM_EQUIPE, ID_CATEGORIE, ID_CLUB)
                values ('".$nom."', ".$id_cat.", ".$id_club.");";

    if($res = $connection->prepare($requete)) {
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
}
$connection->close();
header("Location: equipes.php");
exit();
?>
