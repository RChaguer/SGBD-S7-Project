<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 620px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Joueurs</strong><br></h2>
</div>

<?php
function showAllJoueurs($connection) {
    $requete="select J.ID_JOUEUR ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, J.NUMERO_LICENCE NUM_LIC, J.DATE_NAISSANCE DATE, E.NOM_EQUIPE NOM_E
                from ((JOUEUR J inner join INDIVIDU I on J.ID_JOUEUR = I.ID_INDIVIDU) 
                left outer join (select H.*
                                 from HISTORIQUE H
                                 where H.DATE_DEBUT <= CURDATE() and H.DATE_FIN is null) H on J.ID_JOUEUR = H.ID_SPORTIF) 
                left outer joiN EQUIPE E on E.ID_EQUIPE=H.ID_EQUIPE ";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id du Joueur </th>";
        echo "<th> Nom Complet </th>";
        echo "<th> Adresse </th>";
        echo "<th> Numero de Licence </th>";
        echo "<th> Date de Naissance </th>";
        echo "<th> Equipe Actuelle</th>";

        echo "</tr>";
        echo "</thead>"; 
        echo "<tbody>";

        while ($joueur = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$joueur["ID"]."</td>";
            echo "<td>".$joueur["NOM"]." ".$joueur["PRENOM"]."</td>";
            echo "<td>".$joueur["ADR"]."</td>";
            echo "<td>".$joueur["NUM_LIC"]."</td>";
            echo "<td>".$joueur["DATE"]."</td>";
            if (is_null($joueur["NOM_E"]))
                echo "<td> SANS EQUIPE </td>";
            else 
                echo "<td>".$joueur["NOM_E"]."</td>";
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
        showAllJoueurs($connection);
        ?>
    </table>
</div>
<?php
include "footer.php";
?>