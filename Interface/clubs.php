<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 576px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Clubs</strong><br></h2>
</div>

<?php
function showAllClubs($connection) {
    $requete="select ID_CLUB, NOM_CLUB, DATE_CREATION
            FROM CLUB;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id du Club </th>";
        echo "<th> Nom du Club </th>";
        echo "<th> Date de Création </th>";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($club = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$club["ID_CLUB"]."</td>";
            echo "<td>".$club["NOM_CLUB"]."</td>";
            echo "<td>".$club["DATE_CREATION"]."</td>";
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
        showAllClubs($connection);
        ?>
    </table>
</div>

<?php
include "footer.php";
?>