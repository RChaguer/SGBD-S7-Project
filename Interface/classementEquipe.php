<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 883px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page du Classement des Equipes</strong><br></h2>
</div>

<?php
function showClassementEquipe($connection) {
    $case = 0;
    $requete = "select  RANK() OVER(
                                order by SUM(SCORE) desc) R,
                        TS.ID_EQUIPE,
                        TS.NOM_EQUIPE as NOM,
                        C.NOM_CLUB,
                        G.NOM_CATEGORIE,
                        SUM(WINS) as WINS,
                        SUM(DRAWS) as DRAWS,
                        SUM(LOSSES) as LOSSES,
                        SUM(SCORE) as SCORE,
                        SUM(SOMME_POINTS_MARQUES) as BUTS_M, 
                        SUM(SOMME_POINTS_RECUS) as BUTS_R,
                        SUM(DIFFERENCE) as DIFFERENCE
                from TABLE_S TS 
                        inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
                        inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
                group by TS.ID_EQUIPE";
    if (isset($_GET["id_saison"]) && isset($_GET["id_cat"])) {
        $id_saison = intval($_GET["id_saison"]);
        $id_cat = intval($_GET["id_cat"]);
        
        if ($id_saison != 0 && $id_cat != 0) {
            $case = 3;
            $requete = "select  RANK() OVER(
                                order by SCORE desc) R,
                                TS.ID_EQUIPE,
                                TS.NOM_EQUIPE as NOM,
                                C.NOM_CLUB,
                                G.NOM_CATEGORIE,
                                WINS,
                                DRAWS,
                                LOSSES,
                                SCORE,
                                SOMME_POINTS_MARQUES as BUTS_M, 
                                SOMME_POINTS_RECUS as BUTS_R,
                                DIFFERENCE, 
                                MOYENNE_POINTS_MARQUES as MOYENNE
                        from TABLE_S TS 
                                inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
                                inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
                        where TS.ID_SAISON = ".$id_saison." and TS.ID_CATEGORIE = ".$id_cat." 
                        group by TS.ID_EQUIPE";}
        else if ($id_saison != 0) {
            $case = 2;
            $requete = "select  RANK() OVER(
                                order by SCORE desc) R,
                                TS.ID_EQUIPE,
                                TS.NOM_EQUIPE as NOM,
                                C.NOM_CLUB,
                                G.NOM_CATEGORIE,
                                WINS,
                                DRAWS,
                                LOSSES,
                                SCORE,
                                SOMME_POINTS_MARQUES as BUTS_M, 
                                SOMME_POINTS_RECUS as BUTS_R,
                                DIFFERENCE, 
                                MOYENNE_POINTS_MARQUES as MOYENNE
                        from TABLE_S TS 
                                inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
                                inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
                        where TS.ID_SAISON = ".$id_saison." 
                        group by TS.ID_EQUIPE";}
        else if ($id_cat != 0) {
            $case = 1;
            $requete = "select  RANK() OVER(
                                order by (3*SUM(WINS) + SUM(DRAWS)) desc) R,
                                TS.ID_EQUIPE,
                                TS.NOM_EQUIPE as NOM,
                                C.NOM_CLUB,
                                G.NOM_CATEGORIE,
                                SUM(WINS) as WINS,
                                SUM(DRAWS) as DRAWS,
                                SUM(LOSSES) as LOSSES,
                                SUM(SCORE) as SCORE,
                                SUM(SOMME_POINTS_MARQUES) as BUTS_M, 
                                SUM(SOMME_POINTS_RECUS) as BUTS_R,
                                SUM(DIFFERENCE) as DIFFERENCE
                        from TABLE_S TS
                                inner join CATEGORIE G on TS.ID_CATEGORIE=G.ID_CATEGORIE
                                inner join CLUB C on TS.ID_CLUB = C.ID_CLUB
                        where TS.ID_CATEGORIE = ".$id_cat." 
                        group by TS.ID_EQUIPE";}
    }
    $requete1 = "select * from CATEGORIE";
    $requete2 = "select * from SAISON";
    $res = $connection->query($requete);
    $res1 = $connection->query($requete1);
    $res2 = $connection->query($requete2);
    if($res && $res1 && $res2) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col-7\">
						<h2>Classement des <b> Equipes</b></h2>
					</div>
                    <div class=\"col-4\" >
                    <form method=\"get\" action=\"classementEquipe.php\">
                        <div class=\"col-9\" >
                        <strong>Catégorie </strong>
                        <select class=\"form-control\" name='id_cat' onchange=this.form.submit() id=\"cat_select\">";
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
                        echo "<select class=\"form-control\" name='id_saison' onchange=this.form.submit() id=\"saison_select\">";
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
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Rank </th>";
        echo "<th> Equipe </th>";
        if ($case != 1 && $case != 3)
            echo "<th> Catégorie </th>";
        echo "<th> Club </th>";
        echo "<th> Matchs Gagnés </th>";
        echo "<th> Matchs Nuls </th>";
        echo "<th> Matchs Perdus </th>";
        echo "<th> Score </th>";
        echo "<th> Buts Marqués </th>";
        echo "<th> Buts Reçus </th>";
        echo "<th> Différence Buts </th>";
        if ($case != 0 && $case != 1)
            echo "<th> Moyenne Buts </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($equipe = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$equipe["R"]."</td>";
            echo "<td> <a href=\"equipes.php?id_equipe=".$equipe["ID_EQUIPE"]."\" > ".$equipe["NOM"]." </a></td>";
            if ($case != 1 && $case != 3)
                echo "<td>".$equipe["NOM_CATEGORIE"]."</td>";
            echo "<td>".$equipe["NOM_CLUB"]."</td>";
            echo "<td>".$equipe["WINS"]."</td>";
            echo "<td>".$equipe["DRAWS"]."</td>";
            echo "<td>".$equipe["LOSSES"]."</td>";
            echo "<td>".$equipe["SCORE"]."</td>";
            echo "<td>".$equipe["BUTS_M"]."</td>";   
            echo "<td>".$equipe["BUTS_R"]."</td>";   
            echo "<td>".$equipe["DIFFERENCE"]."</td>"; 
            if ($case != 0 && $case != 1)
                echo "<td>".$equipe["MOYENNE"]."</td>"; 
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
        showClassementEquipe($connection);
    ?>
</div>

<?php
include "footer.php";
?>