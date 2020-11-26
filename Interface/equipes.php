<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 621px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Equipes</strong><br></h2>
</div>

<?php
function showAllEquipes($connection) {
    $requete="select E.ID_EQUIPE as ID, E.NOM_EQUIPE as NOM, C.NOM_CLUB as CLUB, G.NOM_CATEGORIE as CAT
            from (EQUIPE E inner join CLUB C on E.ID_CLUB = C.ID_CLUB)
            inner join CATEGORIE G on G.ID_CATEGORIE = E.ID_CATEGORIE;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id de l'équipe </th>";
        echo "<th> Nom de l'équipe </th>";
        echo "<th> Nom du club </th>";
        echo "<th> Nom de la catégorie </th>";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($equipe = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$equipe["ID"]."</td>";
            echo "<td>".$equipe["NOM"]."</td>";
            echo "<td>".$equipe["CLUB"]."</td>";
            echo "<td>".$equipe["CAT"]."</td>";
            echo "</tr>";
      }
      $connection->close();
      echo "</tbody>";
  }
}
?>

<div class="container py-5">
    <table id="default_table" style="width:100%" class="table table-striped table-bordered">
        <?php
        showAllEquipes($connection);
        ?>
    </table>
</div>

<?php
include "footer.php";
?>