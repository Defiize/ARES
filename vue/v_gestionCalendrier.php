
<link href="./css/css_form.css" rel="stylesheet">

<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header"></div>
    </div>
</div>

<! -- Bulle gestion du compte -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=calendrier&action=createCalendar' method="POST" class="login-form">
            Date Debut :
            <input type="date" placeholder="" name="dateDeb" />
            Date Fin :
            <input type="date" placeholder="" name="dateFin" />
            
            <input type="text" placeholder="Nom calendrier" name="nomCal" />
            <input type="text" placeholder="Intitulé de la formation" name="libelleForm" />

            <button>Créer un calendrier</button>

        </form>
    </div>
</div>

<! -- Bulle gestion du compte -->
<div class="formulaire">
    <div class="form">
        <form action='' method="POST" class="form-gestionUtilisateur">
            <?php
            $lesCal = BddPdo::getLesCalendriers($_SESSION['email']);

            foreach ($lesCal as $leCal)
            {
                echo "<div class='rowCal'>".$leCal['nomCalendrier'].' <a href="./index.php?controleur=calendrier&action=calendrier&idCal='.$leCal['idCalendrier'].'">Ouvrir</a><a id="delete" href="./index.php?controleur=calendrier&action=deleteCalendrier&idCal='.$leCal['idCalendrier'].'">Supprimer</a></div>';
            }
            ?>



        </form>
    </div>
</div>