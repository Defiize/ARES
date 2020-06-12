
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
        <form action='./index.php?controleur=connexion&action=updateUser' method="POST" class="login-form">
            Adresse email :
            <input type="text" placeholder="<?php echo $_SESSION['email'] ?>" name="email" disabled />
            Modifier mon mot de passe :
            <input type="password" placeholder="Mot de passe actuelle" name="passwordActuelle" required/>
            <input type="password" placeholder="Nouveau mot de passe" autocomplete="new-password" name="newPassword1" required/>
            <input type="password" placeholder="Confirmez mot de passe" autocomplete="new-password" name="newPassword2" required/>
            <button>Modifier mes données</button>

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
?>





