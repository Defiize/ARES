
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
        <form action='./index.php?controleur=calendrier&action=genererPDF&idCal=<?php echo $idCal; ?>' method="POST" class="login-form">
            Remplissez-ce formulaire pour génerer le PDF.<br><br>
            
            Conseiller.e en Formation Continue
            <input type="text" placeholder="Nom prénom" name="NPCFC" />
            <input type="text" placeholder="Numéro de Telephone" name="NCFC" />
            <br><br>
            
            Coordonnateur.rice
            <input type="text" placeholder="Nom prénom" name="NPC" />
            <input type="text" placeholder="Numéro de Telephone" name="NC" />
            <br><br>
            
            Assistant.e de formation
            <input type="text" placeholder="Nom prénom" name="NPAF" />
            <input type="text" placeholder="Numéro de Telephone" name="NAF" />
            <br><br>
            
            Assistant.e de formation
            <input type="text" placeholder="Nom prénom" name="NPAF2" />
            <input type="text" placeholder="Numéro de Telephone" name="NAF2" />
            <br><br>
            Choissiez vos logos (4 MAX)

            <div class="checkbox">
            <?php
            $lesLogo=BddPdo::getLesLogoByUser($_SESSION['email']);
            foreach ($lesLogo as $unLogo)
            {
                echo '<div class="lesLogos"><input type="checkbox" id="'.$unLogo['adresseImage'].'" name="checkbox['.$unLogo['adresseImage'].']"/>

            <label for="'.$unLogo['adresseImage'].'">
                <img width="1%" src="./image/logo/'.$unLogo['adresseImage'].'"> 
            </label><br></div>';


            }

            ?>
            </div>
            
            
            <button>Générer le PDF</button>

        </form>
    </div>
</div>
