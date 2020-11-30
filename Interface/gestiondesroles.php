<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 760px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page de gestion de Roles</strong><br></h2>
</div>

<?php
function getAddForm($connection) {
    $requete1 = "select P.ID_PERSONNEL ID_PERSONNEL, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU  PRENOM
                from PERSONNEL P inner join INDIVIDU I on P.ID_PERSONNEL = I.ID_INDIVIDU; ";
    $requete2 = "select ID_ROLE, NOM_ROLE
                from ROLE";

    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter une Liaison Role Personnel</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"get\" action=\"gestionRolePerso.php?add=true\">";
    echo "<div class=\"modal-body\">";
    
    if($res1 = $connection->query($requete1)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Personnel</label>
                <div class=\"col\">
                <select class=\"form-control\" name='id_perso'>";
        while ($perso = $res1->fetch_assoc()) {
            echo "<option value=".$perso["ID_PERSONNEL"].">".$perso["NOM"]." ".$perso["PRENOM"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
        }
    
    if($res2 = $connection->query($requete2)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Role</label>
                <div class=\"col\">
                <select class=\"form-control\" name='id_role'>";
        while ($role = $res2->fetch_assoc()) {
            echo "<option value=".$role["ID_ROLE"].">".$role["NOM_ROLE"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
    }

    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" name='add' class=\"btn btn-primary\">Ajouter";

    echo "</div>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<script>";
    echo "$(document).ready(function() {";
    echo "$('#unique_modal').modal('show');";
    echo "});";
    echo "</script>";
}


function showAllPersoRoles($connection) {
    $requete="select R.ID_ROLE ID_ROLE, R.NOM_ROLE ROLE, P.ID_PERSONNEL ID_PERSONNEL, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM
                from ROLE R inner join ROLE_PERSONNEL RP on R.ID_ROLE=RP.ID_ROLE
                inner join PERSONNEL P on P.ID_PERSONNEL = RP.ID_PERSONNEL 
                inner join INDIVIDU I on I.ID_INDIVIDU = P.ID_PERSONNEL;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Roles des Personnels</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"gestiondesroles.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Liaison</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th>  </th>";  
        echo "<th> Nom Complet </th>";  
        echo "<th> Role </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($rel = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td></td>";
            echo "<td>".$rel["NOM"]." ".$rel["PRENOM"]."</td>";
            echo "<td>".$rel["ROLE"]."</td>";
            echo "<td>  <a href=\"gestionRolePerso.php?id_role=".$rel["ID_ROLE"]."&amp;id_perso=".$rel["ID_PERSONNEL"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a>";

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
?>

<div class="container py-5">
        <?php
        showAllPersoRoles($connection);
        ?>
</div>


<?php
include "footer.php";
?>