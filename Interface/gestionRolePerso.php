<?php
ob_start();
include "connect.php";
include "header.php";

// Loop over field names, make sure each one exists and is not empty
$error = !((isset($_GET['id_perso']) &&  isset($_GET['id_role'])) && (isset($_GET['add']) || isset($_GET['delete']) ));


if ($error) {
  console_log("All fields are required.");
  header("Location: gestiondesroles.php");
  ob_enf_flush();
  exit();
}

$role = $_GET['id_role'];
$perso = $_GET['id_perso'];
if (isset($_GET['delete'])) {

    $requete = "delete from ROLE_PERSONNEL where ID_ROLE = ? and  ID_PERSONNEL = ?;";

    if($res = $connection->prepare($requete)){
        $res->bind_param('ii', $role, $perso);
        $res->execute();
    } else {
        console_log("erreur de requete de suppression");
    }
    
} else if (isset($_GET['add'])) {
    $requete = "insert into ROLE_PERSONNEL (ID_ROLE, ID_PERSONNEL) 
                values (?, ?);";
    
    if($res = $connection->prepare($requete)) {
        $res->bind_param('ii', $role, $perso);
        $res->execute();
    } else 
        console_log("erreur de requete d\'ajout");

}
$connection->close();
header("Location: gestiondesroles.php");
ob_enf_flush();
exit();
?>
