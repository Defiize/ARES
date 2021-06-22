
<link href="./css/css_form.css" rel="stylesheet">

<! -- haut de page -->
<div class="wrapper">
    <div class="main_content">
        <div class="header">Veuillez remplire un des formulaire ci-dessous</div>
    </div>
</div>

<! -- Bulle de upload logo -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=fichePresence&action=UploadLogo' method="post" enctype="multipart/form-data" class="login-form">
            Selectionez une image à upload : <br><br>
            <input type="file" name="fileToUpload" id="fileToUpload">

            <button>Upload image</button>

        </form>
    </div>
</div>

<! -- Bulle supprimer logo -->
<div class="formulaire">
    <div class="form">
        <form action='./index.php?controleur=fichePresence&action=supprimerLogo' method="post" enctype="multipart/form-data" class="login-form">
            Selectionez Les logo a supprimer : <br><br>



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


            <button>supprimer les logos</button>

        </form>
    </div>
</div>


