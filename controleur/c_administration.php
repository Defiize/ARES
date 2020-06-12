
<?php
if (isset($_SESSION['typeUtilisateur']))
{
    if($_SESSION['typeUtilisateur']=='administrateur')
    {
        switch ($_GET['action']) {
            case 'gestionUtilisateur':

                require_once ('vue/v_gestionUtilisateur.php');
                break;

            case 'createUser':
                $reussi = BddPdo::createUser($_POST['email'],md5($_POST['password']),2);
                header("Refresh: 0;./index.php?controleur=admin&action=gestionUtilisateur&reussi=$reussi");




                break;
            case 'deleteUser':
                $deleteSuccess = BddPdo::deleteUser($_GET['email']);
                header("Refresh: 0;./index.php?controleur=admin&action=gestionUtilisateur&deleteSuccess=$deleteSuccess");

                break;
            case 'modifUser':

                $leCompte=$_REQUEST['compte'];
                require_once ('vue/v_gestionCompteAdministration.php');
                break;
            case 'updateUser':


                $newPass1=$_REQUEST['newPassword1'];
                $newPass2=$_REQUEST['newPassword2'];

                if($newPass1 == $newPass2 )
                {
                    BddPdo::updatePassword(md5($newPass1),$_REQUEST['email']);
                    header('Location: ./index.php?controleur=admin&action=modifUser&compte='.$_REQUEST['email'].'&erreur=0');
                }else
                {
                    header('Location: ./index.php?controleur=admin&action=modifUser&compte='.$_REQUEST['email'].'&erreur=1');
                }

                break;

        }
    }else
        header("Refresh: 0;./index.php");
}else
    header("Refresh: 0;./index.php");







