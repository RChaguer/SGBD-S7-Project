<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 887px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page du Classement des Joueurs</strong><br></h2>
</div>



<?php
function showClassementJoueur($connection) {
    $case = 0;
    $requete = "select  RANK() OVER(
                                order by BUTS desc) R,
                        CJ.ID_JOUEUR,
                        I.NOM_INDIVIDU as NOM,
                        I.PRENOM_INDIVIDU as PRENOM,
                        C.NOM_CATEGORIE,
                        ifnull(sum(BUTS),0) as BUTS, 
                        ifnull(sum(FAUTE),0) as FAUTES,
                        CJ.ID_SAISON
                from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
                                    inner join CATEGORIE C on CJ.ID_CATEGORIE = C.ID_CATEGORIE
                group by CJ.ID_JOUEUR";
    if (isset($_GET["id_saison"]) && isset($_GET["id_cat"])) {
        $id_saison = intval($_GET["id_saison"]);
        $id_cat = intval($_GET["id_cat"]);
        
        if ($id_saison != 0 && $id_cat != 0) {
            $case = 3;
            $requete = "select  RANK() OVER(
                                order by BUTS desc) R,
                            CJ.ID_JOUEUR,
                            I.NOM_INDIVIDU as NOM,
                            I.PRENOM_INDIVIDU as PRENOM,
                            ifnull(sum(BUTS),0) as BUTS, 
                            ifnull(sum(FAUTE),0) as FAUTES, 
                            ifnull(avg(NULLIF(`MOYENNE_BUTS`,0)),0) as MOYENNE,
                            CJ.ID_SAISON
                    from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
                    where CJ.ID_SAISON = ".$id_saison." and CJ.ID_CATEGORIE = ".$id_cat." 
                    group by CJ.ID_JOUEUR";}
        else if ($id_saison != 0) {
            $case = 2;
            $requete = "select  RANK() OVER(
                                order by BUTS desc) R,
                            CJ.ID_JOUEUR,
                            I.NOM_INDIVIDU as NOM,
                            I.PRENOM_INDIVIDU as PRENOM,
                            C.NOM_CATEGORIE,
                            ifnull(sum(BUTS),0) as BUTS, 
                            ifnull(sum(FAUTE),0) as FAUTES, 
                            ifnull(avg(NULLIF(`MOYENNE_BUTS`,0)),0) as MOYENNE,
                            CJ.ID_SAISON
                    from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
                                          inner join CATEGORIE C on CJ.ID_CATEGORIE = C.ID_CATEGORIE
                    where CJ.ID_SAISON = ".$id_saison." 
                    group by CJ.ID_JOUEUR";}
        else if ($id_cat != 0) {
            $case = 1;
            $requete = "select  RANK() OVER(
                                order by BUTS desc) R,
                                CJ.ID_JOUEUR,
                                I.NOM_INDIVIDU as NOM,
                                I.PRENOM_INDIVIDU as PRENOM,
                                ifnull(sum(BUTS),0) as BUTS, 
                                ifnull(sum(FAUTE),0) as FAUTES,
                                CJ.ID_SAISON
                        from CLASS_JOUEUR CJ inner join INDIVIDU I on CJ.ID_JOUEUR = I.ID_INDIVIDU
                        where CJ.ID_CATEGORIE = ".$id_cat." 
                        group by CJ.ID_JOUEUR";}
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
						<h2>Classement des <b> Joueurs</b></h2>
					</div>
                    <div class=\"col-4\" >
                    <form method=\"get\" action=\"classementJoueur.php\">
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
        echo "<th> Nom Prénom </th>";
        if ($case != 1 && $case != 3 )
            echo "<th> Catégorie </th>";
        echo "<th> Buts </th>";
        echo "<th> Fautes </th>";
        if ($case != 0 && $case != 1)
            echo "<th> Moyenne Buts</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($joueur = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$joueur["R"]."</td>";
            echo "<td>".$joueur["NOM"]." ".$joueur["PRENOM"]."</td>";
            if ($case != 1 && $case != 3)
                echo "<td>".$joueur["NOM_CATEGORIE"]."</td>";
            echo "<td>".$joueur["BUTS"]."</td>";
            echo "<td>".$joueur["FAUTES"]."</td>";
            if ($case != 0 && $case != 1)
                echo "<td>".$joueur["MOYENNE"]."</td>";            
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
        showClassementJoueur($connection);
    ?>
</div>



<?php
include "footer.php";
?>