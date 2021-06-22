<?php

require ('./fpdf.php');
class PDF extends FPDF
{

// Pied de page

    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-10);
        // Select Arial italic 8
        $this->SetFont('Arial','I',5);
        // Print centered page number
        $this->Cell(0,10,'N:\0.1_Référentiel_GCA\2_FORMULAIRES\FOR CO et APPR\P_Pendant Fo\P5 - ETAT DE PRESENCE INDIVIDUEL EN ENTREPRISE (Word).dotx',0,0,'L');
        $this->ln(3);
        $this->Cell(30,10,'Date de mise à jour : 01/01/2020',0,0,'L');
        $this->Cell(70,10,'ARCHIVAGE',0,0,'C');
        $this->Cell(70,10,'Original : dossier stagiaire',0,0,'C');
        $this->Cell(25,10,'Copie : service comptable - financeur',0,0,'C');
        $this->ln(3);


    }

}



// Recupération données formulaire
$laDateDebut = new DateTime($_REQUEST['dateDebPDF']);
$laDateDebutSave = $laDateDebut;
$laDateFin= new DateTime($_REQUEST['dateFinPDF']);


//on enleve 1 mois pour avoir le bon nombre de page
$laDateDebut->sub(new DateInterval("P1M"));

// Instanciation pdf
    $pdf = new PDF();
    $pdf->SetMargins(5,5,5);
    $pdf->AliasNbPages();

    // 1 boucle pour 1 page tant que le mois et l'année de la dateDebut et DateFin sont différent
while($laDateDebut->format('Y-m')!=$laDateFin->format('Y-m')) {

    // on incrémente le mois de 1
    $laDateDebut->add(new DateInterval("P1M"));


    $pdf->AddPage();

    // Logo Greta + logo p5 ou p3
    $pdf->Image('./../image/logo.png',5,5,38);

    if($_GET['entreprise']==1)
        $pdf->Image('./../image/P5.png',192,5,125);
    else
        $pdf->Image('./../image/P3.png',192,5,10);


// -----------------------------
    // on met les logo dans un array puis on les affiche
    $lesLogo=array();
    array_push($lesLogo,urlencode($_GET['logo1']),urlencode($_GET['logo2']),urlencode($_GET['logo3']),urlencode($_GET['logo4']));


    $x=5;
    $y=268;
    $w=25;
    foreach ($lesLogo as $leLogo)
    {
        if($leLogo!="")
        {

            list($width, $height, $type, $attr) = getimagesize('./../image/logo/'.$leLogo);
            $ratio = $width / $height;
            $pdf->Image('./../image/logo/'.$leLogo,$x,$y,0,20);

            $x += 22*$ratio;
        }



    }

//------------------------------------


    $pdf->Image('./../image/banniere.png',5,20,200);


    // Police Arial gras 15
    $pdf->SetFont('Arial','B',19);
    //Couleur en bleu
    $pdf->SetTextColor(0,32,95);
    // Décalage à droite
    $pdf->Cell(80);
    // Titre
    if($_GET['entreprise']==1)
        $pdf->Cell(50,10,'État de présence individuel en entreprise',0,1,'C');
    else
        $pdf->Cell(50,10,'État de présence individuel en centre',0,1,'C');


    // Saut de ligne
    $pdf->Ln(16);

    $pdf->SetFont('Times', 'B', 9);
    $pdf->setFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 32, 96);

    //ligne 1 tableau
    $pdf->Cell(100, 6, "Formation : ".$_GET['nomFormation'], 1, 0, 'L',true);
    $pdf->Cell(50, 6, "Niveau : ".$_GET['niveau'], 1, 0, 'L', true);
    $pdf->Cell(50, 6, "N°Action : ".$_GET['laction'], 1, 0, 'L', true);
    $pdf->ln();
    //ligne 2 tableau
    $pdf->Cell(100, 6, "Établissement : ".$_GET['etablissement'], 1, 0, 'L',true);
    $pdf->Cell(50, 6, "Date début : ".$_GET['dateDeb'], 1, 0, 'L', true);
    $pdf->Cell(50, 6, "Date Fin : " .$_GET['dateFin'], 1, 0, 'L', true);
    $pdf->ln();
    //ligne 3 tableau
    $pdf->Cell(100, 5, "Conseiller Formation Continue : ".$_GET['conseillerFC'], 1, 0, 'L', true);
    $pdf->Cell(100, 5, "Coordonnateur : ".$_GET['coordinateur'], 1, 0, 'L', true);
    $pdf->ln();
    //ligne 4 tableau
    $pdf->Cell(100, 5, "Conseiller Apprentissage : ".$_GET['conseillerA'], 1, 0, 'L', true);
    $pdf->Cell(100, 5, "Assistant : ".$_GET['assistant'], 1, 0, 'L', true);
    $pdf->ln();

    $pdf->Ln(2);

    // police times gras 12, couleur texte bleu, couleur case blanc
    $pdf->SetFont('Times', 'B', 12);
    $pdf->setFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 32, 96);

    //Nom prénom stagiaire + mois de la page affiché
    $pdf->Cell(150, 6, "Nom & Prénom Stagiaire : ".$_GET['nomPrenom'], 0, 0, 'L' );
    $pdf->Cell(100, 6, "MOIS DE : ".getMonthString($laDateDebut->format('m')), 0, 0, 'L');
    $pdf->ln();


// Header du tableau

    // on réduit la taille de la police
    $pdf->SetFont('Times', 'B', 9);

    // on change la couleur des cellules
    $pdf->setFillColor(230, 230, 230);
    $pdf->SetTextColor(235, 168, 52);

    $pdf->Cell(15, 6, "", 0, 0, 'C');
    $pdf->Cell(92.5, 6, "Matin", 1, 0, 'C', true);
    $pdf->Cell(92.5, 6, "Après-Midi", 1, 0, 'C', true);
    $pdf->Ln();


// Header du tableau

    $pdf->setFillColor(190, 190, 190);
    $pdf->SetTextColor(47, 62, 130);


    $pdf->Cell(15, 5.5, "Date", 1, 0, 'C', true);
    for ($i = 0; $i <= 1; $i++) {
        $pdf->Cell(33.5, 5.5, "Horaires", 1, 0, 'C', true);
        $pdf->Cell(20, 5.5, "Nbre Heure", 1, 0, 'C', true);
        $pdf->Cell(39, 5.5, "Signature stagiaire", 1, 0, 'C', true);
    }
    $pdf->Ln();

// Création ligne tableau

    // on récup le nombre de jours dans le mois
    $nbJours = cal_days_in_month(CAL_GREGORIAN,intval($laDateDebut->format('m')),intval($laDateDebut->format('Y')));

// Une ligne par jours dans le mois
    for ($i = 1; $i <= $nbJours; $i++) {
        $ajd=new DateTime($laDateDebut->format('Y')."-".$laDateDebut->format('m')."-".$i);
        $pdf->setFillColor(190, 190, 190);
        $pdf->Cell(15, 5.5, getDayString($ajd->format('D')).' '.$i.'/'.$laDateDebut->format('m/y'), 1, 0, 'C', true);

        for ($j = 0; $j <= 1; $j++) {
            if(!($ajd->format('D')=='Sat' || $ajd->format('D')=='Sun'))
                $pdf->setFillColor(255, 255, 255);


            $pdf->Cell(33.5, 5.5, '', 1,0,'C',true);
            $pdf->Cell(20, 5.5, '', 1,0,'C',true);
            $pdf->Cell(39, 5.5, '', 1,0,'C',true);

        }
        $pdf->Ln();
    }

    // bas du tableau
    $pdf->SetTextColor(235, 168, 52);
    $pdf->Cell(68.5, 6, "Nombre d'heures prévu :", 1);
    $pdf->Cell(72.5, 6, "Absences : ", 1);
    $pdf->Cell(59, 6, "Nombre d'heures réalisé : ", 1);
    $pdf->ln();




    // Police Arial italique 8
    $pdf->SetFont('Arial','I',8);

    // Bas de page


    $pdf->SetTextColor(0, 0, 0);

    $pdf->Cell(68.5, 6, "Fait à __________________________,", 0);
    $pdf->Cell(72.5, 6, "Le chef d'Établissement", 0,0,'c');
    if($_GET['entreprise']==1)
        $pdf->Cell(60, 6, "L’Entreprise", 0,0,'c');
    $pdf->ln();

    $pdf->Cell(66.5, 6, "Le ____ / ____ / _________", 0);
    $pdf->Cell(73.5, 6, "de la formation", 0,0,'c');
    if($_GET['entreprise']==1)
        $pdf->Cell(60, 6, "(cachet & signature)", 0,0,'c');
    $pdf->ln();
    $pdf->Cell(66.5, 6, "", 0);
    $pdf->Cell(73.5, 6, "(cachet & signature)", 0,0,'c');



}


$pdf->Output();

function getMonthString($leNumMois)
{
    switch ($leNumMois) {
        case '1':

            return "Janvier";
            break;
        case '2':

            return "Février";
            break;
        case '3':

            return "Mars";
            break;
        case '4':

            return "Avril";
            break;
        case '5':

            return "Mai";
            break;
        case '6':

            return "Juin";
            break;
        case '7':

            return "Juillet";
            break;
        case '8':

            return "Août";
            break;
        case '9':

            return "Septembre";
            break;
        case '10':

            return "Octobre";
            break;
        case '11':

            return "Novembre";
            break;
        case '12':

            return "Décembre";
            break;

    }

}

function getDayString($day)
{
    switch ($day) {
        case 'Mon':

            return "L";
            break;
        case 'Tue':

            return "M";
            break;
        case 'Wed':

            return "M";
            break;
        case 'Thu':

            return "J";
            break;
        case 'Fri':

            return "V";
            break;
        case 'Sat':

            return "S";
            break;
        case 'Sun':

            return "D";
            break;


    }
}

