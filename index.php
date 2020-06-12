<link rel="icon" href="./image/greta_favicon.png">
<title>ARES</title>
<?php
session_start();
require_once ('./vue/v_entete_layout.php');
require_once ('./modele/BddPdo.php');

//Redirection si non connecté
if(!(isset($_SESSION['email'])) || !(isset($_SESSION['password'])) )
    if($_GET['controleur']!='connexion')
        header('Location: ./index.php?controleur=connexion&action=connexion');


// Redirection page d'accueil
if(!(isset($_GET['controleur'])))
    header('Location: ./index.php?controleur=connexion&action=connexion');

switch ($_GET['controleur']) {
    case 'connexion':
        require_once ('controleur/c_connexion.php');
        break;
    case 'fichePresence':
        require_once ('controleur/c_fichePresence.php');
        break;
    case 'admin':
        require_once ('controleur/c_administration.php');
        break;
    case 'calendrier':
        require_once ('controleur/c_calendrier.php');
        break;

}

?>





