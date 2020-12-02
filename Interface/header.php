<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HandBall</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alata">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta+Stencil">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arizonia">
    <link rel="stylesheet" href="assets/css/Bootstrap-DataTables.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/css/Highlight-Phone.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/table.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>

    <script src="assets/js/Bootstrap-DataTables.js"></script>
    <script >
        $(document).ready(function() {
            $('#default_table').DataTable();
        } );
    </script>
    
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search" style="background: url(&quot;assets/img/bg-footer.svg&quot;);">
        <div class="container"><a class="navbar-brand" href="index.php" style="font-family: Arizonia, cursive;border-radius: 52px;color: rgb(255,255,255);border: 2px dashed rgb(159,157,157) ;">&nbsp; FF HandBall&nbsp;&nbsp;</a><button data-toggle="collapse" class="navbar-toggler"
                data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="clubs.php" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Clubs</a></li>
                    <li class="nav-item"><a class="nav-link" href="equipes.php" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Equipes</a></li>
                    <li class="nav-item dropdown">
                        <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link" href="#" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Effectif Sportif</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="joueurs.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Joueurs</a>
                            <a class="dropdown-item" href="entraineurs.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Entraineurs</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link" href="#" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Effectif Administratif</a>
                        <div class="dropdown-menu">
                            <a  class="dropdown-item" href="personnels.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Personnels</a>
                            <a  class="dropdown-item" href="roles.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Roles</a>
                            <a  class="dropdown-item" href="gestiondesroles.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Gestion des Roles</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="matchs.php" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Matchs</a></li>
                    <li class="nav-item"><a class="nav-link" href="historique.php" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Historique</a></li>
                    <li class="nav-item dropdown">
                    <a data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle nav-link" href="#" style="color: rgb(255,255,255);font-family: Alata, sans-serif;">Classement</a>
                        <div class="dropdown-menu">
                            <a  class="dropdown-item" href="classementClub.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Clubs</a>
                            <a  class="dropdown-item" href="classementEquipe.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Equipes</a>
                            <a  class="dropdown-item" href="classementJoueur.php" style="color: rgb(69,69,69);font-family: Alata, sans-serif;">Joueurs</a>
                        </div>
                    </li>
                </ul>
        </div>
        </div>
    </nav>
</body>

<?php    
function console_log( $data ){
  echo '<script>';
  echo "console.log('". $data  ."')";
  echo '</script>';
}
?>
      
</html>