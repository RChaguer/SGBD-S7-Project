<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
    <h2 style="height: auto;width: 680px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Entraineurs</strong><br></h2>
</div>

<?php
function getUpdateForm($connection, $id) {
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour de l'Entraineur</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionEntraineur.php?id_entrain=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    $requete = "select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR
                from (INDIVIDU I inner join SPORTIF S on I.ID_INDIVIDU = S.ID_SPORTIF) where I.ID_INDIVIDU = ?; ";
    if ($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
        $entrain = $res->get_result()->fetch_assoc();
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Nom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='nom' value=\"".$entrain["NOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Prénom</label>
                <div class=\"col\">
                <input class=\"form-control\" name='prenom' value=\"".$entrain["PRENOM"]."\">";
        echo "</div>";
        echo "</div>";
        echo "<div class=\"form-group row\">
                <label  class=\"col-auto col-form-label col-form-label-sm\">Adresse</label>
                <div class=\"col\">
                <input class=\"form-control\" name='adresse' value=\"".$entrain["ADR"]."\">";
        echo "</div>";
        echo "</div>";
    }
     echo "</div>";       
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" class=\"btn btn-primary\">Sauvegrader";
    
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
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Entraineur</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionEntraineur.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Nom</label>
            <div class=\"col\">
            <input class=\"form-control\" name='nom' >";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Prénom</label>
            <div class=\"col\">
            <input class=\"form-control\" name='prenom' >";
    echo "</div>";
    echo "</div>";
    echo "<div class=\"form-group row\">
            <label  class=\"col-auto col-form-label col-form-label-sm\">Adresse</label>
            <div class=\"col\">
            <input class=\"form-control\" name='adresse' >";
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

function deleteOneEntraineur($connection, $id) {
    $requete = "delete from INDIVIDU
                where ID_INDIVIDU = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllEntraineurs($connection) {
    $requete="select I.ID_INDIVIDU ID, I.NOM_INDIVIDU NOM, I.PRENOM_INDIVIDU PRENOM, I.ADRESSE ADR, ET.NOM_EQUIPE NOM_E
            from (INDIVIDU I inner join SPORTIF S on I.ID_INDIVIDU = S.ID_SPORTIF) 
            right outer join ENTRAIN_ACTUAL_TEAM ET on ET.ID_ENTRAINEUR = S.ID_SPORTIF;";

  /* execute la requete */
    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Entraineurs</b></h2>
					</div>
					<div class=\"col-3 order-2\" style=\"width:50\">
						<a href=\"entraineurs.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Entraineur</span></a>
					</div>
				</div>
			</div>
        ";   
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Id </th>";
        echo "<th> Nom Complet </th>";
        echo "<th> Adresse </th>";
        echo "<th> Equipe Actuelle</th>";
        echo "<th> </th>";

        echo "</tr>";
        echo "</thead>"; 
        echo "<tbody>";

        while ($entrain = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$entrain["ID"]."</td>";
            echo "<td>".$entrain["NOM"]." ".$entrain["PRENOM"]."</td>";
            echo "<td>".$entrain["ADR"]."</td>";
            if (is_null($entrain["NOM_E"]))
                echo "<td> SANS EQUIPE </td>";
            else 
                echo "<td>".$entrain["NOM_E"]."</td>";
            echo "<td>  <a href=\"entraineurs.php?id_entrain=".$entrain["ID"]."&amp;edit=enter\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"entraineurs.php?id_entrain=".$entrain["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_entrain"])) {
        $id_entrain = $_GET["id_entrain"];
    if (isset($_GET["delete"])) {
        deleteOneEntraineur($connection, $id_entrain);
    } else if (isset($_GET["edit"])) {
        getUpdateForm($connection, $id_entrain);
    } 
    }
?>

<div class="container py-5">
    <?php
        showAllEntraineurs($connection);
    ?>
</div>
<?php
include "footer.php";
?>