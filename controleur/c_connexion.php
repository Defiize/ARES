
<?php

switch ($_GET['action']) {
    case 'connexion':

        require_once ('vue/v_connexion.php');
        break;

    case 'connexionOK':


        if (isset($_POST['password']) || isset($_POST['email']))
        {
            $lemdp=BddPdo::getPassword($_POST['email']);
            if($lemdp==md5($_POST['password']))
            {

                $_SESSION['password']=$_POST['password'];
                $_SESSION['email']=$_POST['email'];
                $_SESSION['typeUtilisateur']=BddPdo::getTypeUtilisateur($_SESSION['email']);
                header("Refresh: 0;url=./index.php?controleur=fichePresence&action=gestionLogo");

            }
            else
                require_once ('vue/v_connexionErreur.php');
        }else
            header("Refresh: 0;url=./index.php?controleur=connexion&action=connexion");


        break;



    case 'deconnexion':
        session_destroy();
        header('Location: ./index.php?controleur=connexion&action=connexion');
        break;

    case 'gestionCompte':
        require_once ('vue/v_gestionCompte.php');
        break;

    case 'updateUser':

        $passActu=$_REQUEST['passwordActuelle'];
        $newPass1=$_REQUEST['newPassword1'];
        $newPass2=$_REQUEST['newPassword2'];

        if($newPass1 == $newPass2 && $passActu == $_SESSION['password'])
        {
            BddPdo::updatePassword(md5($newPass1),$_SESSION['email']);
            session_destroy();
            header('Location: ./index.php?controleur=connexion&action=connexion');
        }else
        {
            header('Location: ./index.php?controleur=connexion&action=gestionCompte&erreur=1');
        }

        break;



}







