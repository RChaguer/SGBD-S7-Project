<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 600px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Matchs</strong><br></h2>
</div>

<?php
function getAddForm($connection, $id_cat) {
    $requete0 = "SELECT ID_CATEGORIE, NOM_CATEGORIE
                from CATEGORIE;";
    $requete1 = "SELECT ID_EQUIPE, NOM_EQUIPE 
                from EQUIPE 
                where ID_CATEGORIE= ?;";
    $requete2 = "SELECT ID_SAISON, LABEL
                from SAISON;";
    $requete3 = "SELECT ID_STADE, NOM_STADE, VILLE
                from STADE;";
    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Match</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    if ($id_cat == 0) {
        echo "<form method=\"get\" action=\"matchs.php?new=true\">";
        echo "<div class=\"modal-body\">";

        if($res0 = $connection->query($requete0)) {
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Catégorie</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='cat' id=\"cat_select0\" onchange=\"this.form.submit()\">";
            echo "<option value=0> ---------- </option>";
            while ($cat = $res0->fetch_assoc()) {
                echo "<option value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
            }
    } else {
                
        echo "<form method=\"post\" id=\"add\" action=\"gestionMatch.php?new=true\">";
        echo "<div class=\"modal-body\">";

        if($res0 = $connection->query($requete0)) {
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Catégorie</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='cat' id=\"cat_select0\" onchange=\"window.location.href='matchs.php?new=true'\">";
            while ($cat = $res0->fetch_assoc()) {
                if (intval($id_cat) == intval($cat["ID_CATEGORIE"]))
                    echo "<option selected='selected' value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
                else 
                    echo "<option value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
            }
        if($res1 = $connection->prepare($requete1)) {
            $res1->bind_param('i', $id_cat);
            $res1->execute();
            $result1 = $res1->get_result();
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Eq. à Domicile</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='id_home' id=\"equipe_select1\">";
            while ($equipe = $result1->fetch_assoc()) {
                echo "<option value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
        }
        
        if($res1 = $connection->prepare($requete1)) {
            $res1->bind_param('i', $id_cat);
            $res1->execute();
            $result1 = $res1->get_result();
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Eq. Visiteuse</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='id_away' id=\"equipe_select2\" >";
            while ($equipe = $result1->fetch_assoc()) {
                echo "<option value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
            }
        if($res2 = $connection->query($requete2)) {
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Saison</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='saison' id=\"saison_select0\">";
            while ($saison = $res2->fetch_assoc()) {
                echo "<option value=".$saison["ID_SAISON"].">".$saison["LABEL"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
            }
         echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Date</label>
                <div class=\"col\">
                    <input name='date' type=\"text\" class=\"form-control form-control-sm\">
                </div>
            </div>";
        if($res3 = $connection->query($requete3)) {
            echo "<div class=\"form-group row\">
                    <label  class=\"col-auto col-form-label col-form-label-sm\">Stade</label>
                    <div class=\"col\">
                    <input type=\"hidden\" name=\"new\" value=true/>
                    <select class=\"form-control\" name='stade' id=\"stade_select\">";
            while ($stade = $res3->fetch_assoc()) {
                echo "<option value=".$stade["ID_STADE"].">".$stade["NOM_STADE"]." - ".$stade["VILLE"]."</option>";
            }
            echo   "</select>
                    </div>
                    </div>";
            }        
    }

                
    echo "</div>";
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type='submit' form=\"add\" class=\"btn btn-primary\"";
    echo ">Ajouter";

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

function getUpdateForm($connection, $id) {
    $requete_lock = "SELECT ID_PARTICIPATION
                    from PARTICIPATION
                    where ID_RENCONTRE=?;";
    if($lock = $connection->prepare($requete_lock)) {
        $lock->bind_param('i', $id);
        $lock->execute();
        $lock = $lock->get_result();
        if (mysqli_num_rows($lock)==0)
            $lock = false;
        else 
            $lock = true;
    } else 
        exit();
    $requete_id = "SELECT E_R.ID_EQUIPE R, E_R.NOM_EQUIPE NOM_R, E_V.ID_EQUIPE V, E_V.NOM_EQUIPE NOM_V, R.ID_SAISON SAISON, S.LABEL LABEL, ST.ID_STADE STADE, ST.NOM_STADE NOM_STADE, ST.VILLE VILLE, R.DATE_RENCONTRE DATE
                    from RENCONTRE R inner join EQUIPE E_R on R.ID_EQUIPE_R = E_R.ID_EQUIPE
                    inner join EQUIPE E_V on R.ID_EQUIPE_V = E_V.ID_EQUIPE
                    inner join SAISON S on R.ID_SAISON = S.ID_SAISON
                    inner join STADE ST on R.ID_STADE = ST.ID_STADE
                    where R.ID_RENCONTRE = ?";
    if ($res_id = $connection->prepare($requete_id)) {
        $res_id->bind_param('i', $id);
        $res_id->execute();
        $match = $res_id->get_result()->fetch_assoc();
    } else 
        exit();
    
    if (!$lock) {
        $requete1 = "SELECT ID_EQUIPE, NOM_EQUIPE 
                    from EQUIPE";
        $requete2 = "SELECT ID_SAISON, LABEL
                    from SAISON;";
    }  
    $requete3 = "SELECT ID_STADE, NOM_STADE, VILLE
                from STADE;";

    
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Modifier un Match</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
                
    echo "<form method=\"post\" id=\"add\" action=\"gestionMatch.php?update=true&amp;match=".$id."\">";
    echo "<div class=\"modal-body\">";

    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Eq. à Domicile</label>
            <div class=\"col\">
            <input type=\"hidden\" name=\"new\" value=true/>
            <select class=\"form-control\" name='id_home' id=\"equipe_select1\">";
    if (!$lock) {
        if($res1 = $connection->query($requete1)) {
            while ($equipe = $res1->fetch_assoc()) {
                if (intval($match["R"]) == intval($equipe["ID_EQUIPE"]))
                    echo "<option selected='selected' value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
                else 
                    echo "<option value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
            }
        }
    } else {
        echo "<option value=".$match["R"].">".$match["NOM_R"]."</option>";
    }
    echo   "</select>
            </div>
            </div>";
    
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Eq. à Domicile</label>
            <div class=\"col\">
            <input type=\"hidden\" name=\"new\" value=true/>
            <select class=\"form-control\" name='id_away' id=\"equipe_select2\">";
    if (!$lock) {
        if($res1 = $connection->query($requete1)) {
            while ($equipe = $res1->fetch_assoc()) {
                if (intval($match["V"]) == intval($equipe["ID_EQUIPE"]))
                    echo "<option selected='selected' value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
                else 
                    echo "<option value=".$equipe["ID_EQUIPE"].">".$equipe["NOM_EQUIPE"]."</option>";
            }
        }
    } else {
        echo "<option value=".$match["V"].">".$match["NOM_V"]."</option>";
    }
    echo  "</select>
            </div>
            </div>";
        

    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Saison</label>
            <div class=\"col\">
            <input type=\"hidden\" name=\"new\" value=true/>
            <select class=\"form-control\" name='saison' id=\"saison_select0\">";
    if (!$lock) {
        if($res2 = $connection->query($requete2)) {
            while ($saison = $res2->fetch_assoc()) {
                if (intval($match["V"]) == intval($equipe["ID_EQUIPE"]))
                    echo "<option selected='selected' value=".$saison["ID_SAISON"].">".$saison["LABEL"]."</option>";
                else 
                    echo "<option value=".$saison["ID_SAISON"].">".$saison["LABEL"]."</option>";
            }
        }
    } else {
        echo "<option value=".$match["SAISON"].">".$match["LABEL"]."</option>";
    }
    echo  "</select>
            </div>
            </div>";
    
     echo "<div class=\"form-group row\">
        <label  class=\"col-auto col-form-label col-form-label-sm\">Date</label>
            <div class=\"col\">";
    if (!$lock)
        echo "<input name='date' value='".$match["DATE"]."' type=\"text\" class=\"form-control form-control-sm\">";
    else {
        echo "<select class=\"form-control\" name='date'> <option >".$match["DATE"]."</option></select>";
    }
     echo "</div>
        </div>";
    
    echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Stade</label>
                <div class=\"col\">
                <input type=\"hidden\" name=\"new\" value=true/>
                <select class=\"form-control\" name='stade' id=\"stade_select\">";
    if($res3 = $connection->query($requete3)) {
        while ($stade = $res3->fetch_assoc()) {
            if (intval($match["STADE"]) == intval($stade["ID_STADE"]))
                echo "<option selected='selected' value=".$stade["ID_STADE"].">".$stade["NOM_STADE"]." - ".$stade["VILLE"]."</option>";
            else 
                echo "<option value=".$stade["ID_STADE"].">".$stade["NOM_STADE"]." - ".$stade["VILLE"]."</option>";
        }
    }

    echo  "</select>
            </div>
            </div>";
        


                
    echo "</div>";
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type='submit' form=\"add\" class=\"btn btn-primary\"";
    echo ">Modifier";

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

function showAllMatchs($connection) {
    $case = 0;
    $requete = "select E_R.ID_EQUIPE R, E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, E_V.ID_EQUIPE V, M.ID_RENCONTRE RENCONTRE, M.ID_SAISON SAISON, M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT, SA.LABEL S_LABEL         
                    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
                    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
                    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
                    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
                    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE";
    if (isset($_GET["id_saison"]) && isset($_GET["id_cat"])) {
        $id_saison = intval($_GET["id_saison"]);
        $id_cat = intval($_GET["id_cat"]);
        
        if ($id_saison != 0 && $id_cat != 0) {
            $case = 3;
            $requete = "select E_R.ID_EQUIPE R, E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, E_V.ID_EQUIPE V, M.ID_RENCONTRE RENCONTRE, M.ID_SAISON SAISON, M.DATE_RENCONTRE DATE       
                    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
                    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
                    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
                    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
                    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
                    where SA.ID_SAISON = ? and G.ID_CATEGORIE = ? ";}
        else if ($id_saison != 0) {
            $case = 2;
            $requete = "select E_R.ID_EQUIPE R, E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, E_V.ID_EQUIPE V, M.ID_RENCONTRE RENCONTRE, M.ID_SAISON SAISON, M.DATE_RENCONTRE DATE, G.NOM_CATEGORIE CAT       
                    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
                    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
                    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
                    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
                    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
                    where SA.ID_SAISON = ? ";}
        else if ($id_cat != 0) {
            $case = 1;
            $requete = "select E_R.ID_EQUIPE R, E_R.NOM_EQUIPE HOME, ifnull(S.SCOREHOME, 0) as SCOREHOME, ifnull(S.SCOREAWAY, 0) as SCOREAWAY, E_V.NOM_EQUIPE AWAY, E_V.ID_EQUIPE V, M.ID_RENCONTRE RENCONTRE, M.ID_SAISON SAISON, M.DATE_RENCONTRE DATE, SA.LABEL S_LABEL         
                    from SCORE S right outer join RENCONTRE M on M.ID_RENCONTRE = S.RENCONTRE
                    inner join SAISON SA on SA.ID_SAISON = M.ID_SAISON
                    inner join EQUIPE E_V on E_V.ID_EQUIPE = M.ID_EQUIPE_V
                    inner join EQUIPE E_R on E_R.ID_EQUIPE = M.ID_EQUIPE_R
                    inner join CATEGORIE G on G.ID_CATEGORIE = E_V.ID_CATEGORIE
                    where G.ID_CATEGORIE = ? ";}
    }
    if ($res = $connection->prepare($requete)) {
        switch ($case) {
            case 0:
                $res->execute();
                break;
            case 1:
                $res->bind_param('i', $id_cat);
                $res->execute();
                break;
            case 2:
                $res->bind_param('i', $id_saison);
                $res->execute();
                break;
            case 3:
                $res->bind_param('ii', $id_saison, $id_cat);
                $res->execute();
                break;
        }
        $res = $res->get_result();
    } else 
        exit();
    $requete1 = "select * from CATEGORIE";
    $requete2 = "select * from SAISON";
    $res1 = $connection->query($requete1);
    $res2 = $connection->query($requete2);
    if($res && $res1 && $res2) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col-5\">
						<h2>Gestion des <b> Matchs</b></h2>
					</div>
                    <div class=\"col-4\" >
                    <form method=\"get\" action=\"matchs.php\">
                        <div class=\"col-9\" >
                        <strong>Catégorie </strong>
                        <select class=\"form-control\" name='id_cat' id=\"cat_select\" onchange=this.form.submit()>";
                        if (intval($id_cat) == 0)
                            echo "<option selected='selected' value=0> All </option>";
                        else 
                            echo "<option value=0> All </option>";
                        while ($cat = $res1->fetch_assoc()) {
                            if (intval($id_cat) == $cat["ID_CATEGORIE"])
                                echo "<option selected='selected' value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";
                            else 
                                echo "<option value=".$cat["ID_CATEGORIE"].">".$cat["NOM_CATEGORIE"]."</option>";

                        }
                        echo "</select>";
                        echo "<strong> Saison </strong>";
                        echo "<select class=\"form-control\" name='id_saison' id=\"saison_select\" onchange=this.form.submit()>";
                        if (intval($id_saison) == 0)
                            echo "<option selected='selected' value=0> All </option>";
                        else 
                            echo "<option value=0> All </option>";
                        while ($saison = $res2->fetch_assoc()) {
                            if (intval($id_saison) == $saison["ID_SAISON"])
                                echo "<option selected='selected' value=".$saison["ID_SAISON"].">".$saison["LABEL"]."</option>";
                            else 
                                echo "<option value=".$saison["ID_SAISON"].">".$saison["LABEL"]."</option>";

                        }
                        echo "</select>
                        </div>
                    
                    </form></div>
					<div class=\"col\" style=\"width:50\">
						<a href=\"matchs.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Match</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th>  </th>";
        echo "<th> Equipe à domicile </th>";
        echo "<th> Score </th>";
        echo "<th> Score </th>";
        echo "<th> Equipe Visiteuse </th>";
        echo "<th> Date </th>";
        if ($case != 1 && $case != 3)
            echo "<th> Catégorie </th>";
        if ($case != 2 && $case != 3)
            echo "<th> Saison </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($match = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td></td>";
            echo "<td> <a href=\"equipes.php?id_equipe=".$match["R"]."\" > ".$match["HOME"]." </a></td>";
            echo "<td>".$match["SCOREHOME"]."</td>";
            echo "<td>".$match["SCOREAWAY"]."</td>";
            echo "<td> <a href=\"equipes.php?id_equipe=".$match["V"]."\" > ".$match["AWAY"]." </a></td>";
            echo "<td>".$match["DATE"]."</td>";
            if ($case != 1 && $case != 3)
                echo "<td>".$match["CAT"]."</td>";
            if ($case != 2 && $case != 3)
                echo "<td>".$match["S_LABEL"]."</td>";
            echo "<td>  <a href=\"feuilleMatch.php?match=".$match["RENCONTRE"]."\"><i class=\"material-icons\">assignment</i></a>
                        <a href=\"matchs.php?match=".$match["RENCONTRE"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"gestionMatch.php?match=".$match["RENCONTRE"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
            
            echo "</tr>";
      }
      $connection->close();
      echo "</tbody>";
      echo "</table>";    
  }
}
?>


<div class="container py-5">
    <?php
        if(isset($_GET["new"]))
            if (isset($_GET["cat"]))
                getAddForm($connection, $_GET["cat"]);
            else 
                getAddForm($connection, 0);
        else if(isset($_GET["match"]) && isset($_GET["edit"]))
            getUpdateForm($connection, $_GET["match"]);
            
        showAllMatchs($connection);
    ?>
</div>




<?php
include "footer.php";
?>