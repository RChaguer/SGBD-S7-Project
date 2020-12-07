<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 675px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Personnels</strong><br></h2>
</div>

<?php
function getUpdateForm($connection, $id) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour du personnel</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionPersonnel.php?id_perso=".$id."\">";
    echo "<div class=\"modal-body\">";
    $requete0 = "select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, P.ID_CLUB CLUB
                from (INDIVIDU I inner join PERSONNEL P on I.ID_INDIVIDU = P.ID_PERSONNEL) where I.ID_INDIVIDU = ?; ";
    $requete1 = "SELECT ID_CLUB, NOM_CLUB
                from CLUB;";
    if ($res = $connection->prepare($requete0)) {
        $res->bind_param('i', $id);
        $res->execute();
        $perso = $res->get_result()->fetch_assoc();
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Nom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='nom' value=\"".$perso["NOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Prénom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='prenom' value=\"".$perso["PRENOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Adresse</label>
                <div class=\"col\">
                <input class=\"form-control\" name='adresse' value=\"".$perso["ADR"]."\">";
        echo "</div>";
        echo "</div>";
        
        if($res1 = $connection->query($requete1)) {
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Club</label>
                    <div class=\"col\">
                    <select class=\"form-control\" name='club' id=\"club_select\">";
            while ($club = $res1->fetch_assoc()) {
                    if (intval($perso["CLUB"]) == intval($club["ID_CLUB"])) {
                        echo "<option selected=\"selected\""; }
                    else {
                        echo "<option ";
                    }
                    echo "value=".$club["ID_CLUB"].">".$club["NOM_CLUB"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
        }

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
    $requete1 = "SELECT ID_CLUB, NOM_CLUB
                from CLUB;";
    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Personnel</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionPersonnel.php?new=true\">";
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
    
    if($res1 = $connection->query($requete1)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Club</label>
            <div class=\"col\">
            <select class=\"form-control\" name='club' id=\"club_select\">";
    while ($club = $res1->fetch_assoc()) {
            echo "<option value=".$club["ID_CLUB"].">".$club["NOM_CLUB"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }
    
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

function deleteOnePersonnel($connection, $id) {
    $requete = "delete from INDIVIDU
                where ID_INDIVIDU = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllPersonnels($connection) {
    $requete="select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, C.NOM_CLUB CLUB
                from (INDIVIDU I inner join PERSONNEL P on I.ID_INDIVIDU = P.ID_PERSONNEL) inner join CLUB C on C.ID_CLUB = P.ID_CLUB;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Personnels</b></h2>
					</div>
					<div class=\"col-3 order-2\" style=\"width:50\">
						<a href=\"personnels.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Personnel</span></a>
					</div>
				</div>
			</div>
        ";   
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Nom Complet </th>";
        echo "<th> Adresse </th>";
        echo "<th> Club </th>";
        echo "<th> </th>";

        echo "</tr>";
        echo "</thead>"; 
        echo "<tbody>";

        while ($perso = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$perso["NOM"]." ".$perso["PRENOM"]."</td>";
            echo "<td>".$perso["ADR"]."</td>";
            echo "<td>".$perso["CLUB"]."</td>";
            echo "<td>  <a href=\"personnels.php?id_perso=".$perso["ID"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"personnels.php?id_perso=".$perso["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_perso"])) {
        $id_perso = $_GET["id_perso"];
    if (isset($_GET["delete"])) {
        deleteOnePersonnel($connection, $id_perso);
    } else if (isset($_GET["edit"])) {
        getUpdateForm($connection, $id_perso);
    } 
    }
?>

<div class="container py-5">
    <?php
        showAllPersonnels($connection);
    ?>
</div>
<?php
include "footer.php";
?>