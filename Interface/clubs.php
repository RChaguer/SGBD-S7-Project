<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 576px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Clubs</strong><br></h2>
</div>

<?php
function showOneClub($connection, $id) {
    $requete1="select NOM_CLUB, DATE_CREATION 
                from CLUB C 
                where ID_CLUB=".$id.";";
    $requete2="select E.ID_EQUIPE ID, E.NOM_EQUIPE NOM, G.NOM_CATEGORIE CAT
                from EQUIPE E inner join CATEGORIE G on G.ID_CATEGORIE = E.ID_CATEGORIE 
                where E.ID_CLUB=".$id." 
                order by G.NOM_CATEGORIE";

  /* execute la requete */
    if($res1 = $connection->query($requete1)) {
        $club = $res1->fetch_assoc();
        echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
        echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
        echo "<div class=\"modal-content\">";
        echo "<div class=\"modal-header\">";
        echo "<h4 class=\"modal-title\" id=\"modal_title\">Nom Du Club : ".$club["NOM_CLUB"]."</h4>";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "</div>";
        echo "<div class=\"modal-body\">";
        if ($res2 = $connection->query($requete2)) {
            echo "<h5 class=\"modal-title\" id=\"modal_title\"> Date de Création : ".$club["DATE_CREATION"]."</h5>";
            echo "<h5 class=\"modal-title\" id=\"modal_title\"> Les Equipes du Club :</h5>";
            echo "<table id=\"equipe_table\" class=\"table\" >";
            echo "<thead>";
            echo "<tr>";
            echo "<th> Nom Equipe </th>";
            echo "<th> Catégorie </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($equipe = $res2->fetch_assoc()) {
                console_log($equipe["NOM"]);
                echo "<tr>";
                echo "<td> <a href=\"equipes.php?id_equipe=".$equipe["ID"]."\" > ".$equipe["NOM"]." </a></td>";
                echo "<td>".$equipe["CAT"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        echo "</div>";
        echo "<div class=\"modal-footer\">";
        echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
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
}

function getUpdateForm($connection, $id) {
    $requete="select NOM_CLUB, DATE_CREATION 
                from CLUB C 
                where ID_CLUB=".$id.";";
    if($res = $connection->query($requete)) {
        $club = $res->fetch_assoc();
    } else {
        header("Location : clubs.php");
        exit();
    }
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour du Club</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionClub.php?id_club=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom du Club</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" value=\"".$club["NOM_CLUB"]."\" >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Date</label>
                <div class=\"col\">
                    <input name='date' type=\"text\" class=\"form-control form-control-sm\" value=\"".$club["DATE_CREATION"]."\">
                </div>
            </div>";
                
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
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Club</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionClub.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom du Club</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Date</label>
                <div class=\"col\">
                    <input name='date' type=\"text\" class=\"form-control form-control-sm\">
                </div>
            </div>";
                
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

function deleteOneClub($connection, $id) {
    $requete = "delete from CLUB
                where ID_CLUB = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllClubs($connection) {
    $requete="select ID_CLUB as ID, NOM_CLUB as NOM, DATE_CREATION AS DATE
            from CLUB;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Clubs</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"clubs.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Club</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> </th>";
        echo "<th> Nom du Club </th>";
        echo "<th> Date de Création </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($club = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td> </td>";
            echo "<td> <a href=\"clubs.php?id_club=".$club["ID"]."\" > ".$club["NOM"]." </a></td>";
            echo "<td>".$club["DATE"]."</td>";
            echo "<td>  <a href=\"clubs.php?id_club=".$club["ID"]."&amp;edit=true\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"clubs.php?id_club=".$club["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_club"])) {
        $id_club = $_GET["id_club"];
        if (isset($_GET["delete"])) {
            deleteOneClub($connection, $id_club);
        } else if (isset($_GET["edit"])) {
            getUpdateForm($connection, $id_club);
        } else {
            showOneClub($connection, $id_club);
        }
    }
?>

<div class="container py-5">
        <?php
        showAllClubs($connection);
        ?>
</div>


<?php
include "footer.php";
?>