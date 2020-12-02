<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 660px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page de l'historique</strong><br></h2>
</div>

<?php
function getUpdateForm($connection, $id) {
    $requete0 = "SELECT *
                from HISTORIQUE
                where ID_HISTORIQUE=".$id.";";
    $requete1 = "SELECT S.ID_SPORTIF ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM
                from SPORTIF S inner join INDIVIDU I on I.ID_INDIVIDU = S.ID_SPORTIF ;";
    $requete2 = "SELECT ID_EQUIPE, NOM_EQUIPE
                from EQUIPE;";
   if($res0 = $connection->query($requete0)) {
        $histo = $res0->fetch_assoc();
    } else {
        console_log("Erreur de mise à jour");
        exit();
    }
    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Historique</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionHistorique.php?id_histo=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    if($res1 = $connection->query($requete1)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Sportif</label>
            <div class=\"col\">
            <select class=\"form-control\" name='sportif' id=\"club_select\">";
    while ($sportif = $res1->fetch_assoc()) {
        if (intval($histo["ID_SPORTIF"]) == intval($sportif["ID"])) {
            echo "<option selected=\"selected\""; }
        else {
            echo "<option ";
        }     
        echo "value=".$sportif["ID"].">".$sportif["ID"]." - ".$sportif["NOM"]." ".$sportif["PRENOM"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }
    if($res2 = $connection->query($requete2)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Equipe</label>
            <div class=\"col\">
            <select class=\"form-control\" name='equipe' id=\"club_select\">";
    while ($equipe = $res2->fetch_assoc()) {
            if (intval($histo["ID_EQUIPE"]) == intval($equipe["ID_E"])) {
            echo "<option selected=\"selected\""; }
        else {
            echo "<option ";
        }     
        echo "value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Date Début</label>";
    echo "<div class=\"col\">";
    echo "<input name='date_d' type=\"text\" value=\"".$histo["DATE_DEBUT"]."\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Date Fin</label>";
    echo "<div class=\"col\">";
    echo "<input name='date_f' type=\"text\" value=\"".$histo["DATE_FIN"]."\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
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
}

function getAddForm($connection) {
    $requete1 = "SELECT S.ID_SPORTIF ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM
                from SPORTIF S inner join INDIVIDU I on I.ID_INDIVIDU = S.ID_SPORTIF ;";
    $requete2 = "SELECT ID_EQUIPE, NOM_EQUIPE
                from EQUIPE;";
    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Historique</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionHistorique.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    if($res1 = $connection->query($requete1)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Sportif</label>
            <div class=\"col\">
            <select class=\"form-control\" name='sportif' id=\"club_select\">";
    while ($sportif = $res1->fetch_assoc()) {
            echo "<option value=".$sportif["ID"].">".$sportif["ID"]." - ".$sportif["NOM"]." ".$sportif["PRENOM"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }
    if($res2 = $connection->query($requete2)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Equipe</label>
            <div class=\"col\">
            <select class=\"form-control\" name='equipe' id=\"club_select\">";
    while ($equipe = $res2->fetch_assoc()) {
            echo "<option value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Date Début</label>";
    echo "<div class=\"col\">";
    echo "<input name='date_d' type=\"text\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Date Fin</label>";
    echo "<div class=\"col\">";
    echo "<input name='date_f' type=\"text\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
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
}

function deleteOneHistorique($connection, $id) {
    $requete = "delete from HISTORIQUE
                where ID_HISTORIQUE = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllHistorique($connection) {
    $requete="select H.ID_HISTORIQUE as ID, E.ID_EQUIPE as ID_E, E.NOM_EQUIPE as NOM_E, I.NOM_INDIVIDU as NOM_S, I.PRENOM_INDIVIDU as PRENOM_S, H.DATE_DEBUT as DATE_D, H.DATE_FIN as DATE_F
            from (HISTORIQUE H inner join EQUIPE E on E.ID_EQUIPE = H.ID_EQUIPE)
            inner join INDIVIDU I on H.ID_SPORTIF = I.ID_INDIVIDU;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion de <b> l'Historique</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"historique.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter un Historique</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> </th>";
        echo "<th> Nom du Sportif </th>";
        echo "<th> Nom de l'Equipe </th>";
        echo "<th> Date Début </th>";
        echo "<th> Date Fin </th>";
        echo "<th> </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($histo = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td> </td>";
            echo "<td> ".$histo["NOM_S"]." ".$histo["PRENOM_S"]." </td>";
            echo "<td> <a href=\"equipes.php?id_equipe=".$histo["ID_E"]."\" >".$histo["NOM_E"]."</a></td>";
            echo "<td>".$histo["DATE_D"]."</td>";
            echo "<td>";
            if (is_null($histo["DATE_F"]))
                echo "En cours";
            else 
                echo $histo["DATE_F"];
            echo "</td>";
            echo "<td>  <a href=\"historique.php?id_histo=".$histo["ID"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"historique.php?id_histo=".$histo["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_histo"])) {
        $id_histo = $_GET["id_histo"];
    if (isset($_GET["delete"])) {
        deleteOneHistorique($connection, $id_histo);
    } else if (isset($_GET["edit"])) {
        getUpdateForm($connection, $id_histo);
        }
    }
?>

<div class="container py-5">
    <?php
        showAllHistorique($connection);
    ?>
</div>






<?php
include "footer.php";
?>