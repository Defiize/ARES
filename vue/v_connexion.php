
<link href="./css/css_form.css" rel="stylesheet">

<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header">Veuillez vous connecter pour accéder aux fonctionnalités de l'application</div>
    </div>
</div>

<! -- Bulle de connexion -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=connexion&action=connexionOK' method="POST" class="login-form">
            <input type="text" placeholder="Email" name="email" required/>
            <input type="password" placeholder="Mot de passe" name="password" required/>
            <button>login</button>

        </form>
    </div>
</div>


