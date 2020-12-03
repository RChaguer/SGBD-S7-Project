<?php
include "header.php";
include "connect.php";
?>

<?php
function showMatchPage($connection, $id) {
    $requete = "select E_R.ID_EQUIPE R, E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, E_V.ID_EQUIPE V, M.ID_RENCONTRE RENCONTRE, M.ID_SAISON SAISON, M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT, SA.LABEL S_LABEL , ST.NOM_STADE STADE     
                    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
                    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
                    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
                    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
                    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
                    inner join STADE ST on ST.ID_STADE = M.ID_STADE
                    where M.ID_RENCONTRE = ".$id."";
    
    if($res = $connection->query($requete)) {
        $match = $res->fetch_assoc();
    } else {
        console_log("error");
        exit();
    }
    
    echo "<div class=\"highlight-phone\" style=\"width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;\">
            <h2 style=\"height: auto;width: 660px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;\">
                <strong>Bienvenue sur la feuille du Match ".$match["RENCONTRE"]."</strong><br></h2>
    </div>";
    if (intval($match["SCOREHOME"]) < intval($match["SCOREAWAY"])) {
        $color_D = "#ff0000";
        $color_V = "#06b803";
    } else if (intval($match["SCOREHOME"]) > intval($match["SCOREAWAY"])) {
        $color_V = "#ff0000";
        $color_D = "#06b803";
    } else {
        $color_V = "#5fa6c5";
        $color_D = "#5fa6c5";
    }

    echo "<div style=\"width: auto;margin-top: 38px;padding: 0px;padding-right: 0px;padding-left: 0px;margin-right: auto;margin-left: auto;\">
        <div class=\"row\" style=\"width: 969px;border-width: 6px;border-style: solid;border-radius: 14px;background: #cccaca;margin: auto;margin-bottom: 50px;margin-left: auto;padding: 0px;margin-top: 0px;margin-right: auto;\">
            <div class=\"col align-self-center\" style=\"width: 152px;margin-right: 10px;\">
                <h1 class=\"text-center\" style=\"font-family: Alata, sans-serif;\">".$match["HOME"]."</h1>
            </div>
            <div class=\"col-1 align-self-center\" style=\"background: ".$color_D.";margin-right: 10px;margin-left: 10px;height: 68px;width: auto;\">
                <h1 style=\"margin: auto;padding: 0;padding-top: auto;padding-bottom: auto;font-size: 50px;width: 50px;\">".$match["SCOREHOME"]."</h1>
            </div>
            <div class=\"col-1 align-self-center\" style=\"background: ".$color_V.";margin-left: 10px;margin-right: 10px;height: 68px;width: auto;\">
                <h1 style=\"font-size: 50px;width: 50px;\">".$match["SCOREAWAY"]."</h1>
            </div>
            <div class=\"col align-self-center\" style=\"width: 250px;margin-right: 10px;margin-left: 10px;\">
                <h1 class=\"text-center\">".$match["AWAY"]."</h1>
            </div>
        </div>";
        echo "<div class=\"card justify-content-center align-items-center align-content-center align-self-center\" style=\"width: 350px;margin-right: auto;margin-left: auto;\">
                <div class=\"card-body justify-content-center align-items-center align-content-center align-self-center\" style=\"width: 424px;margin-right: auto;\">
                    <p class=\"card-text\" style=\"width: 366px;font-size: 22px;height: 50px;\">Stade : ".$match["STADE"]." </p>
                    <p class=\"card-text\" style=\"width: 366px;font-size: 22px;height: 50px;\">Date : ".$match["DATE"]."</p>
                    <p class=\"card-text\" style=\"width: 366px;font-size: 22px;height: 50px;\">Saison : ".$match["S_LABEL"]."</p>
                    <p class=\"card-text\" style=\"width: 366px;font-size: 22px;height: 50px;\">Catégorie : ".$match["CAT"]."</p>
                </div>
            </div>";
        echo "<div class=\"container py-5\">
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Les <b> Entraineurs</b></h2>
					</div>
				</div>
			</div>";  
        $requete_ent = "select I.ID_INDIVIDU, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, E.NOM_EQUIPE EQUIPE 
                        from SPORTIF S inner join INDIVIDU I on I.ID_INDIVIDU = S.ID_SPORTIF 
                        left join JOUEUR J on J.ID_JOUEUR = S.ID_SPORTIF 
                        left outer join (select H.* 
                                        from HISTORIQUE H
                                        where H.DATE_DEBUT <= '".$match["DATE"]."' and (H.DATE_FIN is null or H.DATE_FIN > '".$match["DATE"]."')) H on S.ID_SPORTIF = H.ID_SPORTIF 
                        left outer join EQUIPE E on E.ID_EQUIPE = H.ID_EQUIPE
                        where J.ID_JOUEUR is null and (E.ID_EQUIPE=".$match["R"]." or E.ID_EQUIPE=".$match["V"].");";

        echo "<table style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th> Nom Prénom </th>";
        echo "<th> Equipe </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if($res_ent = $connection->query($requete_ent)) {
            while ($entrain = $res_ent->fetch_assoc()) {
                echo "<tr>";
                echo "<td></td>";
                echo "<td>".$entrain["NOM"]." ".$entrain["PRENOM"]."</td>";
                echo "<td>".$entrain["EQUIPE"]."</td>";
                echo "<td></td>";
                echo "</tr>";
          }
        }
      echo "</tbody>";
      echo "</table>"; 
      echo "</div>";
        $requete_j = "select JM.ID_PARTICIPATION ID, JM.ID_RENCONTRE RENCONTRE, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, JM.NOM_POSTE POSTE, JM.NOMBRE_BUT BUTS, JM.NOMBRE_FAUTE FAUTES, JM.NOM_EQUIPE EQUIPE
                        from JOUEURS_MATCH JM inner join INDIVIDU I on JM.ID_JOUEUR = I.ID_INDIVIDU
                        where JM.ID_RENCONTRE=".$id.";";
        echo "
        <div class=\"container py-5\">
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Participations</b></h2>
					</div>
					<div class=\"col-3 order-2\" style=\"width:50\">
						<a href=\"feuilleMatch.php?new=true&amp;match=".$id."\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Participation</span></a>
					</div>
				</div>
			</div>";  
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th>  </th>";
        echo "<th> Nom Prénom </th>";
        echo "<th> Poste </th>";
        echo "<th> Buts </th>";
        echo "<th> Fautes </th>";
        echo "<th> Equipe </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if($res_j = $connection->query($requete_j)) {
            while ($particip = $res_j->fetch_assoc()) {
                echo "<tr>";
                echo "<td></td>";
                echo "<td>".$particip["NOM"]." ".$particip["PRENOM"]."</td>";
                echo "<td>".$particip["POSTE"]."</td>";
                echo "<td>".$particip["BUTS"]."</td>";
                echo "<td>".$particip["FAUTES"]."</td>";
                echo "<td>".$particip["EQUIPE"]."</td>";
                echo "<td>  <a href=\"feuilleMatch.php?particip=".$particip["ID"]."&amp;match=".$particip["RENCONTRE"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                            <a href=\"gestionfeuilleMatch.php?particip=".$particip["ID"]."&amp;delete=true&amp;match=".$particip["RENCONTRE"]."\"><i class=\"material-icons\">delete</i></a></td>";

                echo "</tr>";
          }
        }
      $connection->close();
      echo "</tbody>";
      echo "</table>";    
    echo "</div>";
    echo "</div>";
}

function getAddForm($connection, $id) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter une Participation</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionFeuilleMatch.php?new=true&amp;match=".$id."\">";
    echo "<div class=\"modal-body\">";
    $requete0 = "select ID_EQUIPE_R R, ID_EQUIPE_V V, DATE_RENCONTRE DATE
                from RENCONTRE
                where ID_RENCONTRE = ".$id."";
    if($res0 = $connection->query($requete0)) {
        $match = $res0->fetch_assoc();
    } else {
        exit();
    }
    
    $requete1 = "select J.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM , E.NOM_EQUIPE EQUIPE
                from JOUEUR J inner join HISTORIQUE H on J.ID_JOUEUR = H.ID_SPORTIF 
                inner join INDIVIDU I on I.ID_INDIVIDU = J.ID_JOUEUR 
                inner join EQUIPE E on E.ID_EQUIPE = H.ID_EQUIPE
                where H.DATE_DEBUT <= \"".$match["DATE"]."\" and (H.DATE_FIN is null or H.DATE_FIN > \"".$match["DATE"]."\") and (H.ID_EQUIPE = ".$match["R"]." or H.ID_EQUIPE = ".$match["V"].")";
    
    $requete2 = "select ID_POSTE, NOM_POSTE
                from POSTE";
    
    if($res1 = $connection->query($requete1)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Joueur</label>
                <div class=\"col\">
                <select class=\"form-control\" name='joueur'>";
        while ($joueur = $res1->fetch_assoc()) {
            echo "<option value=".$joueur["ID"].">".$joueur["NOM"]." ".$joueur["PRENOM"]." - ".$joueur["EQUIPE"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
    }
    if($res2 = $connection->query($requete2)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Poste</label>
                <div class=\"col\">
                <select class=\"form-control\" name='poste'>";
        while ($poste = $res2->fetch_assoc()) {
            echo "<option value=".$poste["ID_POSTE"].">".$poste["NOM_POSTE"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
    }
    

    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nombre de Buts</label>
            <div class=\"col\">
            <input class=\"form-control\" name='but'>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nombre de Fautes</label>            <div class=\"col\">
            <input class=\"form-control\" name='faute' >";
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

function getUpdateForm($connection, $id) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Modifier une Participation</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    
    $requete_c = "select ID_JOUEUR ID, ID_POSTE POSTE, ID_RENCONTRE RENCONTRE, NOMBRE_BUT BUTS, NOMBRE_FAUTE FAUTES
                from PARTICIPATION
                where ID_PARTICIPATION = ".$id."";
    if($res_c = $connection->query($requete_c)) {
        $particip = $res_c->fetch_assoc();
    } else {
        exit();
    }

    echo "<form method=\"post\" action=\"gestionFeuilleMatch.php?update=true&amp;particip=".$id."&amp;match=".$particip["RENCONTRE"]."\">";
    echo "<div class=\"modal-body\">";
    
    $requete0 = "select ID_EQUIPE_R R, ID_EQUIPE_V V, DATE_RENCONTRE DATE
                from RENCONTRE
                where ID_RENCONTRE = ".$particip["RENCONTRE"]."";
    if($res0 = $connection->query($requete0)) {
        $match = $res0->fetch_assoc();
    } else {
        exit();
    }
    
    $requete1 = "select J.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM , E.NOM_EQUIPE EQUIPE
                from JOUEUR J inner join HISTORIQUE H on J.ID_JOUEUR = H.ID_SPORTIF 
                inner join INDIVIDU I on I.ID_INDIVIDU = J.ID_JOUEUR 
                inner join EQUIPE E on E.ID_EQUIPE = H.ID_EQUIPE
                where H.DATE_DEBUT <= \"".$match["DATE"]."\" and (H.DATE_FIN is null or H.DATE_FIN > \"".$match["DATE"]."\") and (H.ID_EQUIPE = ".$match["R"]." or H.ID_EQUIPE = ".$match["V"].")";
    
    $requete2 = "select ID_POSTE, NOM_POSTE
                from POSTE";
    
    if($res1 = $connection->query($requete1)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Joueur</label>
                <div class=\"col\">
                <select class=\"form-control\" name='joueur'>";
        while ($joueur = $res1->fetch_assoc()) {
            if (intval($joueur["ID"]) == intval($particip["ID"]))
                echo "<option selected='selected' value=".$joueur["ID"].">".$joueur["NOM"]." ".$joueur["PRENOM"]." - ".$joueur["EQUIPE"]."</option>";
            else
                echo "<option value=".$joueur["ID"].">".$joueur["NOM"]." ".$joueur["PRENOM"]." - ".$joueur["EQUIPE"]."</option>";
        }
        echo   "</select>
                </div>
                </div>";
    }
    if($res2 = $connection->query($requete2)) {
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Poste</label>
                <div class=\"col\">
                <select class=\"form-control\" name='poste'>";
        while ($poste = $res2->fetch_assoc()) {
             if (intval($poste["ID_POSTE"]) == intval($particip["POSTE"]))
                echo "<option selected='selected' value=".$poste["ID_POSTE"].">".$poste["NOM_POSTE"]."</option>";
            else 
                echo "<option value=".$poste["ID_POSTE"].">".$poste["NOM_POSTE"]."</option>";

        }
        echo   "</select>
                </div>
                </div>";
    }
    

    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nombre de Buts</label>
            <div class=\"col\">
            <input class=\"form-control\" value='".$particip["BUTS"]."' name='but'>";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nombre de Fautes</label>            <div class=\"col\">
            <input class=\"form-control\" value='".$particip["FAUTES"]."' name='faute' >";
    echo "</div>";
    echo "</div>";
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" class=\"btn btn-primary\">Modifier";

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
?>


<?php
    if(isset($_GET["match"])) {
        $id = $_GET["match"];
        if (isset($_GET["new"]))
            getAddForm($connection, $id);
        else if (isset($_GET["edit"])) {
            $id_particip = $_GET["particip"];
            getUpdateForm($connection, $id_particip);
        }
        showMatchPage($connection, $id);
    }
    else
        console_log("Manque match id");
?>

<?php
include "footer.php";
?>