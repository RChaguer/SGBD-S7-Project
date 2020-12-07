<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 621px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Equipes</strong><br></h2>
</div>

<?php
function showOneEquipe($connection, $id) {
    $requete1="select E.NOM_EQUIPE NOM,  G.NOM_CATEGORIE CAT, C.NOM_CLUB CLUB
                from EQUIPE E inner join CLUB C on E.ID_CLUB=C.ID_CLUB 
                                inner join CATEGORIE G on G.ID_CATEGORIE=E.ID_CATEGORIE
                where ID_EQUIPE=".$id.";";
    $requete2="select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, V.DATE_DEBUT DATE
                from JOUEUR P inner join PLAYER_ACTUAL_TEAM V on P.ID_JOUEUR = V.ID_JOUEUR
                                inner join INDIVIDU I on I.ID_INDIVIDU = P.ID_JOUEUR
                where V.ID_EQUIPE=".$id.";";

  /* execute la requete */
    if($res1 = $connection->query($requete1)) {
        $equipe = $res1->fetch_assoc();
        echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
        echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
        echo "<div class=\"modal-content\">";
        echo "<div class=\"modal-header\">";
        echo "<h4 class=\"modal-title\" id=\"modal_title\">Nom De l'Equipe : ".$equipe["NOM"]."</h4>";
        echo "<button type=\"button\" class=\"clos///////////////////////////////////////////e\" data-dismiss=\"modal\" aria-label=\"Close\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "</div>";
        echo "<div class=\"modal-body\">";
        if ($res2 = $connection->query($requete2)) {
            echo "<h5 class=\"modal-title\" id=\"modal_title\"> Club : ".$equipe["CLUB"]."</h5>";
            echo "<h5 class=\"modal-title\" id=\"modal_title\"> Catégorie : ".$equipe["CAT"]."</h5>";
            echo "<h5 class=\"modal-title\" id=\"modal_title\"> Les Joueurs de l'équipe :</h5>";
            echo "<table id=\"joueur_table\" class=\"table\" >";
            echo "<thead>";
            echo "<tr>";
            echo "<th> Nom et Prénom </th>";
            echo "<th> Date Début Contrat</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($joueur = $res2->fetch_assoc()) {
                echo "<tr>";
                echo "<td> <a href=\"joueurs.php?id_joueur=".$joueur["ID"]."\" > ".$joueur["NOM"]." ".$joueur["PRENOM"]." </a></td>";
                echo "<td>".$joueur["DATE"]."</td>";
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

  } else {
        console_log("error");
    }
}

function getUpdateForm($connection, $id) {
    $requete0 = "SELECT NOM_EQUIPE, ID_CLUB, ID_CATEGORIE
                from EQUIPE
                where ID_EQUIPE=?;";
    $requete1 = "SELECT ID_CLUB, NOM_CLUB
                from CLUB;";
    $requete2 = "SELECT ID_CATEGORIE, NOM_CATEGORIE
                from CATEGORIE;";
     if($res0 = $connection->prepare($requete0)) {
        $res0->bind_param('i', $id);
        $res0->execute();
        $equipe = $res0->get_result()->fetch_assoc();
    } else {
        console_log("Erreur de mise à jour");
        exit();
    }
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour de l'Equipe</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionEquipe.php?id_equipe=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom de L'Equipe</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" value=\"".$equipe["NOM_EQUIPE"]."\">";
    echo "</div>";
    echo "</div>";
    
    if($res1 = $connection->query($requete1)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Club</label>
                <div class=\"col\">
                <select class=\"form-control\" name='club' id=\"club_select\">";
        while ($club = $res1->fetch_assoc()) {
                if (intval($equipe["ID_CLUB"]) == intval($club["ID_CLUB"])) {
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
    
    if($res2 = $connection->query($requete2)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Catégorie</label>
                <div class=\"col\">
                <select class=\"form-control\" name='cat' id=\"club_select\">";
        while ($cat = $res2->fetch_assoc()) {
                if (intval($equipe["ID_CATEGORIE"]) == intval($cat["ID_CATEGORIE"])) {
                    echo "<option selected=\"selected\""; }
                else {
                    echo "<option ";
                }
                echo "value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
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
    $requete2 = "SELECT ID_CATEGORIE, NOM_CATEGORIE
                from CATEGORIE;";
    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter une Equipe</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionEquipe.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom de L'Equipe</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" \" >";
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
    if($res2 = $connection->query($requete2)) {
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Catégorie</label>
            <div class=\"col\">
            <select class=\"form-control\" name='cat' id=\"club_select\">";
    while ($cat = $res2->fetch_assoc()) {
            echo "<option value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    }

                
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

function deleteOneEquipe($connection, $id) {
    $requete = "delete from EQUIPE
                where ID_EQUIPE = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllEquipes($connection) {
    $requete="select E.ID_EQUIPE as ID, E.NOM_EQUIPE as NOM, C.NOM_CLUB as CLUB, G.NOM_CATEGORIE as CAT
            from (EQUIPE E inner join CLUB C on E.ID_CLUB = C.ID_CLUB)
            inner join CATEGORIE G on G.ID_CATEGORIE = E.ID_CATEGORIE;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Equipes</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"equipes.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Equipe</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id de l'équipe </th>";
        echo "<th> Nom de l'équipe </th>";
        echo "<th> Nom du club </th>";
        echo "<th> Nom de la catégorie </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($equipe = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$equipe["ID"]."</td>";
            echo "<td> <a href=\"equipes.php?id_equipe=".$equipe["ID"]."\" > ".$equipe["NOM"]." </a></td>";
            echo "<td>".$equipe["CLUB"]."</td>";
            echo "<td>".$equipe["CAT"]."</td>";
            echo "<td>  <a href=\"equipes.php?id_equipe=".$equipe["ID"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"equipes.php?id_equipe=".$equipe["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_equipe"])) {
        $id_equipe = $_GET["id_equipe"];
    if (isset($_GET["delete"])) {
        deleteOneEquipe($connection, $id_equipe);
    } else if (isset($_GET["edit"])) {
        getUpdateForm($connection, $id_equipe);
    } else {
        showOneEquipe($connection, $id_equipe);
    }
    }
?>

<div class="container py-5">
    <?php
        showAllEquipes($connection);
    ?>
</div>

<?php
include "footer.php";
?>