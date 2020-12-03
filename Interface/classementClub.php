<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 840px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page du Classement des Clubs</strong><br></h2>
</div>


<?php
function showAllClassement($connection) {
    $requete="select ROW_NUMBER() OVER(
                order by SCORE desc ) RANG ,
              CLUB.ID_CLUB ID,
              CLUB.NOM_CLUB NOM,
              IFNULL(SUM(RANK_CLUB.WINS), 0) WINS,
              IFNULL(SUM(RANK_CLUB.DRAWS), 0) DRAWS,
              IFNULL(SUM(RANK_CLUB.LOSSES), 0) LOSSES,
              (3*IFNULL(SUM(WINS), 0) + IFNULL(SUM(DRAWS), 0)) as SCORE
        from RANK_CLUB right outer join CLUB on RANK_CLUB.ID_CLUB = CLUB.ID_CLUB
        group by RANK_CLUB.ID_CLUB";
    $requete_s="select ID_SAISON as ID, LABEL
                from SAISON";
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Classement des <b> Clubs</b></h2>
					</div>";
                    if($res_s = $connection->query($requete_s)) {
                        echo "<div class=\"col-4\" >
                        <form method=\"get\" action=\"classementClub.php\">
                            <div class=\"col-9\" >
                            <strong>Saison </strong>
                            <select class=\"form-control\" name='saison' id=\"saison_select\" onchange=this.form.submit()>";
                            echo "<option selected='selected' value=0> All </option>";
                            while ($saison = $res_s->fetch_assoc()) {
                                echo "<option value=".$saison["ID"].">".$saison["LABEL"]."</option>";
                            }
                            echo "</select></div></form></div>";
                    }
		echo "</div></div>";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Rang </th>";
        echo "<th> Nom du Club </th>";
        echo "<th> Matchs Gagnés </th>";
        echo "<th> Matchs Nuls </th>";
        echo "<th> Matchs Perdus </th>";
        echo "<th> Score </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($club = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$club["RANG"]."</td>";
            echo "<td> <a href=\"clubs.php?id_club=".$club["ID"]."\" > ".$club["NOM"]." </a></td>";
            echo "<td>".$club["WINS"]."</td>";
            echo "<td>".$club["DRAWS"]."</td>";
            echo "<td>".$club["LOSSES"]."</td>";
            echo "<td>".$club["SCORE"]."</td>";
            echo "</tr>";
      }
      $connection->close();
      echo "</tbody>";
      echo "</table>";
  }
}

function showAllClassementBySaison($connection, $id) {
    $requete="select ROW_NUMBER() OVER(
                order by SCORE desc ) RANG ,
              CLUB.ID_CLUB ID,
              CLUB.NOM_CLUB NOM,
              IFNULL(RANK_CLUB.WINS, 0) WINS,
              IFNULL(RANK_CLUB.DRAWS, 0) DRAWS,
              IFNULL(RANK_CLUB.LOSSES, 0) LOSSES,
              (3*IFNULL(WINS, 0) + IFNULL(DRAWS, 0)) as SCORE
        from RANK_CLUB right outer join CLUB on RANK_CLUB.ID_CLUB = CLUB.ID_CLUB
        where RANK_CLUB.ID_SAISON = ".$id."
        group by RANK_CLUB.ID_CLUB";
    $requete_s="select ID_SAISON as ID, LABEL
                from SAISON";
    
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Classement des <b> Clubs</b></h2>
					</div>";
                    if($res_s = $connection->query($requete_s)) {
                        echo "<div class=\"col-4\" >
                        <form method=\"get\" action=\"classementClub.php\">
                            <div class=\"col-9\" >
                            <strong>Saison </strong>
                            <select class=\"form-control\" name='saison' id=\"saison_select\" onchange=this.form.submit()>";
                            echo "<option value=0> All </option>";
                            while ($saison = $res_s->fetch_assoc()) {
                                if (intval($id) == $saison["ID"])
                                    echo "<option selected='selected' value=".$saison["ID"].">".$saison["LABEL"]."</option>";
                                else 
                                    echo "<option value=".$saison["ID"].">".$saison["LABEL"]."</option>";
                            }
                            echo "</select></div></form></div>";
                    }
        echo "</div></div>";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Rang </th>";
        echo "<th> Nom du Club </th>";
        echo "<th> Matchs Gagnés </th>";
        echo "<th> Matchs Nuls </th>";
        echo "<th> Matchs Perdus </th>";
        echo "<th> Score </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($club = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$club["RANG"]."</td>";
            echo "<td> <a href=\"clubs.php?id_club=".$club["ID"]."\" > ".$club["NOM"]." </a></td>";
            echo "<td>".$club["WINS"]."</td>";
            echo "<td>".$club["DRAWS"]."</td>";
            echo "<td>".$club["LOSSES"]."</td>";
            echo "<td>".$club["SCORE"]."</td>";
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
    if (isset($_GET["saison"]) && intval($_GET["saison"]) != 0)
        showAllClassementBySaison($connection, $_GET["saison"]);
    else 
        showAllClassement($connection);
    ?>
</div>

<?php
include "footer.php";
?>