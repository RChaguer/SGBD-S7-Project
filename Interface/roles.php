<?php
include "header.php";
include "connect.php";
?>

<div class="highlight-phone" style="width: 1920;height: auto;background: linear-gradient(rgba(10,70,131,0.46), white);margin: auto;padding-right: auto;">
        <h2 style="height: auto;width: 576px;border-bottom: 8px solid rgb(0,61,119);font-family: 'Allerta Stencil', sans-serif;font-size: 35px;margin: auto;"><strong>Bienvenue sur la page des Roles</strong><br></h2>
</div>

<?php
function getUpdateForm($connection, $id) {
    $requete="select NOM_ROLE
                from ROLE 
                where ID_ROLE=?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();
        $role = $res->get_result()->fetch_assoc();
    } else {
        header("Location : roles.php");
        exit();
    }
    echo "<div class=\"modal fade\" id=\"unique_modal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=`\"exampleModalCenterTitle\" aria-hidden=\"false\">";
    echo "<div class=\"modal-dialog modal-dialog-centered\" role=\"document\">";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"modal-header\">";
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Mise à jour du Role</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionRole.php?id_role=".$id."\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom du Role</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" value=\"".$role["NOM_ROLE"]."\" >";
    echo "</div>";
    echo "</div>";
    
    echo "</div>";            
    
    echo "<div class=\"modal-footer\">";
    echo "<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>";
    echo "<button type=\"submit\" class=\"btn btn-primary\">Sauvegarder";

    echo "</div>";
    echo "</form>";
    echo "</div>";
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
    echo "<h4 class=\"modal-title\" id=\"modal_title\">Ajouter un Role</h4>";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
    echo "</button>";
    echo "</div>";
    echo "<form method=\"post\" action=\"gestionRole.php?new=true\">";
    echo "<div class=\"modal-body\">";
    
    echo "<div class=\"form-group row\">";
    echo "<label  class=\"col-auto col-form-label col-form-label-sm\">Nom du Role</label>";
    echo "<div class=\"col\">";
    echo "<input name='nom' type=\"text\" class=\"form-control form-control-sm\" \" >";
    echo "</div>";
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
    echo "</div>";

    echo "<script>";
    echo "$(document).ready(function() {";
    echo "$('#unique_modal').modal('show');";
    echo "});";
    echo "</script>";
}

function deleteOneRole($connection, $id) {
    $requete = "delete from ROLE
                where ID_ROLE = ?;";
    if($res = $connection->prepare($requete)) {
        $res->bind_param('i', $id);
        $res->execute();  
    }
}

function showAllRoles($connection) {
    $requete="select ID_ROLE ID, NOM_ROLE NOM
                from ROLE;";

    if($res = $connection->query($requete)) {
        echo "
            <div class=\"table-title\">
				<div class=\"row\" >
					<div class=\"col\">
						<h2>Gestion des <b> Roles</b></h2>
					</div>
					<div class=\"col-2 order-2\" style=\"width:50\">
						<a href=\"roles.php?new=true\" class=\"btn btn-success\"><i class=\"material-icons\">&#xE147;</i> <span>Ajouter Role</span></a>
					</div>
				</div>
			</div>
        ";
        echo "<table id=\"default_table\" style=\"width:100%\" class=\"table table-striped table-bordered\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th> Nom du Role </th>";
        echo "<th>  </th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($role = $res->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$role["NOM"]."</td>";
            echo "<td>  <a href=\"roles.php?id_role=".$role["ID"]."&amp;edit=true\"><i class=\"material-icons\">edit</i></a>
                        <a href=\"roles.php?id_role=".$role["ID"]."&amp;delete=true\"><i class=\"material-icons\">delete</i></a></td>";
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
    else if(isset($_GET["id_role"])) {
        $id_role = $_GET["id_role"];
        if (isset($_GET["delete"])) {
            deleteOneRole($connection, $id_role);
        } else if (isset($_GET["edit"])) {
            getUpdateForm($connection, $id_role);
        } 
    }
?>

<div class="container py-5">
        <?php
        showAllRoles($connection);
        ?>
</div>


<?php
include "footer.php";
?>