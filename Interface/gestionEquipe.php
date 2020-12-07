<?php
ob_start();
include "connect.php";
include "header.php";

$required = array('nom','club', 'cat');

$error = !(isset($_GET['id_equipe']) || isset($_GET['new']));

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
  console_log("All fields are required.");
  header("Location: equipes.php");
  ob_enf_flush();
  exit();
}

$nom = $_POST["nom"];
$id_club = $_POST["club"];
$id_cat = $_POST["cat"];
if (isset($_GET['id_equipe'])) {
    $id = $_GET["id_equipe"];

    $requete = "update EQUIPE
                set ID_CATEGORIE = ?, ID_CLUB = ?, NOM_EQUIPE = ?
                where ID_EQUIPE = ?;";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('iisi', $id_cat, $id_club, $nom, $id);
        $res->execute();
    } else {
        console_log("error de requete update");
    }
} else if (isset($_GET['new'])) {
    $requete = "insert into EQUIPE (NOM_EQUIPE, ID_CATEGORIE, ID_CLUB)
                values (?, ?, ?);";

    if($res = $connection->prepare($requete)) {
        $res->bind_param('sii', $nom, $id_cat, $id_club);
        $res->execute();
    } else {
        console_log("error de requete d'ajout");
    }
}
$connection->close();
header("Location: equipes.php");
ob_enf_flush();
exit();
?>
