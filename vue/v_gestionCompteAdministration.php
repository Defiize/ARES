
<link href="./css/css_form.css" rel="stylesheet">

<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header">Vous trouverez les informations de votre compte ci-dessous</div>
    </div>
</div>

<! -- Bulle gestion du compte -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=admin&action=updateUser' method="POST" class="login-form">
            Adresse email :
            <input type="text" value="<?php echo $leCompte ?>" name="email" readonly />
            Modifier le mot de passe :
            <input type="new-password" placeholder="Nouveau mot de passe" name="newPassword1" required/>
            <input type="new-password" placeholder="Confirmez mot de passe" name="newPassword2" required/>
            <button>Modifier les données du compte</button>

        </form>
    </div>
</div>

<! -- Bulle de erreur -->
<?php
if(isset($_GET['erreur']))
    if($_GET['erreur']==1)
        echo '  
                    <div class="pageError">
                    Erreur saisie
                    </div>
                 ';
    else
        echo '  
                    <div class="pageSuccess">
                   Le mot de passe a bien été modifier
                    </div>
                 ';

?>






