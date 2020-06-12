
<?php

switch ($_GET['action']) {
    case 'fromFichePresence':


        require_once ('vue/v_fichePresence.php');


        break;

    case 'GenererPDF':

        // Récupération données formulaire ---------------------------------------------

            $dateDebutPDF = urlencode($_REQUEST['dateDebutPDF']);
            $dateFinPDF = urlencode($_REQUEST['dateFinPDF']);

            $entreprise=$_REQUEST['SelectFichePresence'];

        if(isset($_REQUEST['nomPrenom']))
            $nomPrenom = urlencode($_REQUEST['nomPrenom']);
        else
            $nomPrenom = "";
        if(isset($_REQUEST['nomFormation']))
            $nomFormation = urlencode($_REQUEST['nomFormation']);
        else
            $nomFormation = "";

        if(isset($_REQUEST['niveau']))
            $niveau = urlencode($_REQUEST['niveau']);
        else
            $niveau = "";

        if(isset($_REQUEST['action']))
            $laction = urlencode($_REQUEST['action']);
        else
            $laction = "";

        if(isset($_REQUEST['etablissement']))
            $etablissement = urlencode($_REQUEST['etablissement']);
        else
            $etablissement = "";

        if(isset($_REQUEST['dateDebut']))
            $dateDeb = urlencode($_REQUEST['dateDebut']);
        else
            $dateDeb = "";

        if(isset($_REQUEST['dateFin']))
            $dateFin = urlencode($_REQUEST['dateFin']);
        else
            $dateFin = "";

        if(isset($_REQUEST['conseillerFC']))
            $conseillerFC = urlencode($_REQUEST['conseillerFC']);
        else
            $conseillerFC = "";

        if(isset($_REQUEST['coordinateur']))
            $coordinateur =urlencode( $_REQUEST['coordinateur']);
        else
            $coordinateur = "";

        if(isset($_REQUEST['conseillerA']))
            $conseillerA = urlencode($_REQUEST['conseillerA']);
        else
            $conseillerA = "";

        if(isset($_REQUEST['assistant']))
            $assistant = urlencode($_REQUEST['assistant']);
        else
            $assistant = "";


        //--------------------------------------------------------------------------------


        if(isset($_REQUEST['checkbox']))
        {
            $lesLogo=$_REQUEST['checkbox'];
            $lesLogo = array_keys($lesLogo);

        }
        for($i=0;$i<=4;$i++)
        {
            if(!isset($lesLogo[$i]))
            {
                $lesLogo[$i]="";
            }



        }


        header("Refresh: 0;url=./FPDF/PdfFichePresence.php?dateDebPDF=$dateDebutPDF&dateFinPDF=$dateFinPDF&nomPrenom=".$nomPrenom."&nomFormation=".$nomFormation."&niveau=".$niveau."&laction=$laction&etablissement=$etablissement&dateDeb=$dateDeb&dateFin=$dateFin&conseillerFC=$conseillerFC&coordinateur=$coordinateur&conseillerA=$conseillerA&assistant=$assistant&logo1=".$lesLogo[0]."&logo2=".$lesLogo[1]."&logo3=".$lesLogo[2]."&logo4=".$lesLogo[3]."&entreprise=".$entreprise);

        break;

    case 'gestionLogo':
        require_once ('vue/v_gestionLogo.php');
        break;

    case 'UploadLogo':


        // permet de retiré tout les accents et espace du nom de l'image
        $search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u, ,@,&,%,$,£,€,',(,)");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,,,,,");

        $basename = basename($_FILES["fileToUpload"]["name"]);
        $basename = str_replace($search, $replace, $basename);

        $target_dir = "./image/logo/";
        $target_file = $target_dir . $basename;
        $nomImage = $basename;


        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // si l'image existe
        if (file_exists($target_file)) {



            $res=BddPdo::ajouterImageUtilisateur(BddPdo::getIdLogo($nomImage),BddPdo::getIdUser($_SESSION['email']));
            if($res==1)
                header("Refresh: 0;url=./index.php?controleur=fichePresence&action=gestionLogo");


            // si l'image n'existe pas
            echo "cc";
        }else{

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "svg") {
                echo "<div style=\"text-align: center;\">Désolé, seuls les fichiers JPG, JPEG et PNG sont autorisés.</div>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<div style=\"text-align: center;\">Désolé, votre fichier n'a pas été téléverser.</div>";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    BddPdo::ajouterImage($nomImage);
                    BddPdo::ajouterImageUtilisateur(BddPdo::getIdLogo($nomImage),BddPdo::getIdUser($_SESSION['email']));


                    // on désactive l'interlacement des image car le fpdf ne le prends pas
                    if($imageFileType == "png")
                    {

                        $chemin = './image/logo/'.$nomImage;
                        $monImage=imagecreatefrompng($chemin);
                        imagecolorallocatealpha($monImage,255,255,255,0);
                        imageinterlace($monImage,0);
                        imagesavealpha($monImage,true);
                        imagepng($monImage,$chemin);
                    }



                  header("Refresh: 0;url=./index.php?controleur=fichePresence&action=gestionLogo");

                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                    echo $_FILES["fileToUpload"]["tmp_name"];
                    echo "<br>".$target_file;
                }
            }

        }





        break;
    case 'supprimerLogo':

        var_dump($_POST);
        $lesLogo = array_keys($_POST['checkbox']);

        foreach ($lesLogo as $unLogo)
        {
            BddPdo::supprimerLogoUtilisateur(BddPdo::getIdUser($_SESSION['email']),BddPdo::getIdLogo($unLogo));
            //unlink('./image/logo/'.$unLogo);
            header("Refresh: 0;url=./index.php?controleur=fichePresence&action=gestionLogo");


        }


        break;









}






