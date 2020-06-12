
<link href="./css/css_form.css" rel="stylesheet">

<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header">Vous trouverez ci-dessous la gestion des comptes utilisateurs</div>
    </div>
</div>

<! -- Bulle création d'un compte utilisateur -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=admin&action=createUser' method="POST" class="login-form">


            <input autocomplete="off" type="text" placeholder="Adresse email" name="email" />
            <input autocomplete="off" type="text" placeholder="Mot de passe" name="password" required/>

            <button>Créer un compte utilisateur</button>
        </form>
    </div>
</div>

<! -- Bulle de erreur -->
<?php
if(isset($_GET['reussi']))
    if($_GET['reussi']!=1)
        echo '  
                    <div class="pageError">
                    Erreur saisie
                    </div>
                 ';
    else
        echo '  
                    <div class="pageSuccess">
                   Le compte a été créer
                    </div>
                 ';

?>

<! -- Formulaire affichage des comptes-->


<div class="formulaire">
    <div class="form">
        <form action='' method="" class="form-gestionUtilisateur">

            <?php
            $lesUtilisateurs = BddPdo::getLesUtilisateur();

            foreach ($lesUtilisateurs as $unUtilisateur)
            {
                echo $unUtilisateur['email'].' <a href="index.php?controleur=admin&action=modifUser&compte='.$unUtilisateur['email'].'">Modifier</a><a id="delete" href="./index.php?controleur=admin&action=deleteUser&email='.$unUtilisateur['email'].'">Supprimer</a><br><br>';


            }

            ?>



        </form>
    </div>

    <! -- bulle succès-->
    <?php

    if(isset($_GET['deleteSuccess']))
        if($_GET['deleteSuccess']!=1)
            echo '  
                    <div class="pageError">
                    Erreur supression
                    </div>
                 ';
        else
            echo '  
                    <div class="pageSuccess">
                   Le compte a été supprimé
                    </div>
                 ';

    ?>
</div>

