<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 620px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Joueurs</strong><br></h2>
</div>

<?php
function getUpdateForm($connection, $id) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour du joueur</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionJoueur.php?id_joueur=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    $requete = "select P.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, P.NUMERO_LICENCE NUM_LIC, P.DATE_NAISSANCE DATE
                from (INDIVIDU I inner join JOUEUR P on I.ID_INDIVIDU = P.ID_JOUEUR) where I.ID_INDIVIDU = ?; ";
    if ($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
        $joueur = $res->get_result()->fetch_assoc();
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Nom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='nom' value=\"".$joueur["NOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Prénom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='prenom' value=\"".$joueur["PRENOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Adresse</label>
                <div class=\"col\">
                <input class=\"form-control\" name='adresse' value=\"".$joueur["ADR"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Numéro de License</label>
                <div class=\"col\">
                <input class=\"form-control\" name='num_lic' value=\"".$joueur["NUM_LIC"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Date de Naissance</label>           
                <div class=\"col\">
                <input class=\"form-control\" name='date' value=\"".$joueur["DATE"]."\">";
        echo "</div>";
        echo "</div>";
    }
     echo "</div>";       
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder";
    
    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<script>";
    echo "$(document).ready(function() {";
    echo "$('#unique_modal').modal('show');";
    echo "});";
    echo "</script>";
}

function getAddForm($connection) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Joueur</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionJoueur.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nom</label>
            <div class=\"col\">
            <input class=\"form-control\" name='nom' >";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Prénom</label>
            <div class=\"col\">
            <input class=\"form-control\" name='prenom' >";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Adresse</label>
            <div class=\"col\">
            <input class=\"form-control\" name='adresse' >";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Numéro de License</label>
            <div class=\"col\">
            <input class=\"form-control\" name='num_lic'>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Date de Naissance</label>            <div class=\"col\">
            <input class=\"form-control\" name='date' >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" class=\"btn btn-primary\">Ajouter";

    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<script>";
    echo "$(document).ready(function() {";
    echo "$('#unique_modal').modal('show');";
    echo "});";
    echo "</script>";
    echo "</div>";

}

function deleteOneJoueur($connection, $id) {
    $requete = "delete from INDIVIDU
                where ID_INDIVIDU = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllJoueurs($connection) {
    $requete="select P.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, P.NUMERO_LICENCE NUM_LIC, P.DATE_NAISSANCE DATE, V.NOM_EQUIPE  NOM_E
                from (INDIVIDU I inner join JOUEUR P on I.ID_INDIVIDU = P.ID_JOUEUR) 
                right outer join PLAYER_ACTUAL_TEAM V on V.ID_JOUEUR=P.ID_JOUEUR;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Joueurs</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"joueurs.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Joueur</span></a>
					</div>
				</div>
			</div>
        ";   
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id du Joueur </th>";
        echo "<th> Nom Complet </th>";
        echo "<th> Adresse </th>";
        echo "<th> Num. Lic. </th>";
        echo "<th> Date de Naissance </th>";
        echo "<th> Equipe Actuelle</th>";
        echo "<th> </th>";

        echo "</tr>";
        echo "</thead>"; 
        echo "<tbody>";

        while ($joueur = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$joueur["ID"]."</td>";
            echo "<td>".$joueur["NOM"]." ".$joueur["PRENOM"]."</td>";
            echo "<td>".$joueur["ADR"]."</td>";
            echo "<td>".$joueur["NUM_LIC"]."</td>";
            echo "<td>".$joueur["DATE"]."</td>";
            if (is_null($joueur["NOM_E"]))
                echo "<td> SANS EQUIPE </td>";
            else 
                echo "<td>".$joueur["NOM_E"]."</td>";
            echo "<td>  <a href=\"joueurs.php?id_joueur=".$joueur["ID"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"joueurs.php?id_joueur=".$joueur["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
            echo "</tr>";
    
      }
      $connection->close();
      echo "</tbody>";
      echo "</table>";
  }
}

?>

<?php
    if(isset($_GET["new"]))
        getAddForm($connection);
    else if(isset($_GET["id_joueur"])) {
        $id_joueur = $_GET["id_joueur"];
    if (isset($_GET["delete"])) {
        deleteOneJoueur($connection, $id_joueur);
    } else if (isset($_GET["edit"])) {
        getUpdateForm($connection, $id_joueur);
    } 
    }
?>

<div class="container py-5">
    <?php
        showAllJoueurs($connection);
    ?>
</div>
<?php
include "footer.php";
?>