<link href="./css/css_navbar.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

<div class="wrapper">
    <div class="sidebar">
        <h2><img  src="./image/test.png"/></h2>
        <ul>

            <?php



                if(isset($_SESSION['email']) && isset($_SESSION['password']))
                {
                    echo'
            <li><a href="./index.php?controleur=fichePresence&action=fromFichePresence"><i class="fas fa-address-card"></i>Fiche de présence</a></li>
            <li><a href="./index.php?controleur=fichePresence&action=gestionLogo"><i class="fas fa-grip-horizontal"></i>Gestion des logos</a></li>
            <li><a href="./index.php?controleur=calendrier&action=gestionCalendrier"><i class="far fa-calendar-alt"></i> Gestion calendrier formation</a></li>
            
            <li><a href="./index.php?controleur=connexion&action=gestionCompte"><i class="fas fa-user"></i>Gestion du compte</a></li>
            ';

                    if($_SESSION['typeUtilisateur']=='administrateur')
                    {
                        echo '<li><a href="./index.php?controleur=admin&action=gestionUtilisateur&page=1"><i class="fas fa-toolbox"></i>Administration</a></li>';
                    }
                    echo '<li><a href="./index.php?controleur=connexion&action=deconnexion"><i class="fas fa-sign-out-alt"></i>Deconnexion</a></li>';
                }



                else
                    echo '<li><a href="./index.php?controleur=connexion&action=connexion"><i class="fas fa-home"></i>Connexion</a></li>';

            ?>

        </ul>
        <div class="social_media">
            <a href="https://fr-fr.facebook.com/GRETASudAquitaine/"><i class="fab fa-facebook-f" style="padding-top: 10px;"></i></a>
            <a href="https://twitter.com/greta_cfa_aquit"><i class="fab fa-twitter" style="padding-top: 10px;"></i></a>
            <a href="https://greta-cfa-aquitaine.fr/"><i class="fab fa-firefox-browser" style="padding-top: 10px;"></i></a>
        </div>
    </div>

</div>