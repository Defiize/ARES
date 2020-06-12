
<link href="./css/css_form.css" rel="stylesheet">
<meta charset="UTF-8">
<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header">Veuillez remplir le formulaire ci-dessous pour générer le PDF</div>
    </div>
</div>

<! -- Bulle formulaire -->
<div class="formulaire">
    <div class="form">

        <form action='./index.php?controleur=fichePresence&action=GenererPDF' method="post" class="login-form">
            Date de début PDF:
            <input required type="date" placeholder="date" name="dateDebutPDF"/>
            Date de fin PDF:
            <input required type="date" placeholder="date" name="dateFinPDF"/>
            <div id="SelectFichePresence">Fiche <select name="SelectFichePresence" id="SelectFichePresence">
                    <option value="0">en centre</option>
                    <option value="1">en entreprise</option>
                </select></div>
            <br>
            <input autocomplete="on" type="text" placeholder="Intitulé de la formation (facultatif)" name="nomFormation"/>
            <input autocomplete="on" type="text" placeholder="Nom Prénom stagiaire (facultatif)" name="nomPrenom"/>

            <input autocomplete="on" type="text" placeholder="Niveau (facultatif)" name="niveau"/>
            <input autocomplete="on" type="text" placeholder="N°Action (facultatif)" name="action"/>
            <input autocomplete="on" type="text" placeholder="Établissement (facultatif)" name="etablissement"/>
            <input autocomplete="on" type="text" placeholder="Date début formation (facultatif)" name="dateDebut"/>
            <input autocomplete="on" type="text" placeholder="Date fin formation (facultatif)" name="dateFin"/>
            <input autocomplete="on" type="text" placeholder="Conseiller formation continue (facultatif)" name="conseillerFC"/>
            <input autocomplete="on" type="text" placeholder="Coordinateur (facultatif)" name="coordinateur"/>
            <input autocomplete="on" type="text" placeholder="Conseiller apprentissage (facultatif)" name="conseillerA"/>
            <input autocomplete="on" type="text" placeholder="Assistant (facultatif)" name="assistant"/>

            Cliquez sur vos logos(Max 4)<br><br><br>



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
            <button>Générer PDF</button>
        </form>
    </div>
</div>

