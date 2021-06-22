<?php
require ('./../modele/BddPdo.php');
include_once ('./../controleur/function_calendrier.php');

require ('./fpdf.php');
class PDF extends FPDF
{

// Pied de page

   

}
//$leCal = BddPdo::getArrayCal($_REQUEST['idCal']);

$pdf = new FPDF('L');
$pdf->SetAutoPageBreak(false);
$pdf->SetMargins(5, 4);


    $dateDeb = BddPdo::getDateDebCal($_REQUEST['idCal']);
    $dateDeb = new DateTime($dateDeb['annee'].'-'.$dateDeb['mois'].'-'.$dateDeb['jours']);
    $dateFin = BddPdo::getDateFinCal($_REQUEST['idCal']);
    $leCalendrier = BddPdo::getCalendrier($_REQUEST['idCal']);
    $dateFin= new DateTime($dateFin['annee'].'-'.$dateFin['mois'].'-'.$dateFin['jours']);
    //$dateFin->add(DateInterval::createFromDateString('1 months'));
    $lesJours = array();
    $interval = DateInterval::createFromDateString('1 months');
    $period = new DatePeriod($dateDeb,$interval,$dateFin);
    
    
    $libelleForm = BddPdo::getLibelleFormationCal($_REQUEST['idCal'])['libelleFormation'];
    $nbAnnee=intval($dateFin->format('Y'))-intval($dateDeb->format('Y'));
    $annee=intval($dateDeb->format('Y'));
    
    
    
    $lesLogo=array();
    array_push($lesLogo,urlencode($_GET['logo1']),urlencode($_GET['logo2']),urlencode($_GET['logo3']),urlencode($_GET['logo4']));

    



    //boucles années
    for($a=0;$a<=$nbAnnee;$a++) 
    {
        $pdf->AddPage();
        
        $pdf->Image('./../image/logo.png',5,5,35);
        $pdf->Image('./../image/p8.png',280,5,10);
        
  
              $x=5;
              $y=188;
              $w=15;
    foreach ($lesLogo as $leLogo)
    {
        if($leLogo!="")
        {

            list($width, $height, $type, $attr) = getimagesize('./../image/logo/'.$leLogo);
            $ratio = $width / $height;
            $pdf->Image('./../image/logo/'.$leLogo,$x,$y,0,$w);

            $x += 22*$ratio;
        }
    }
        
        $pdf->SetFont('Arial','B',16);
        $pdf->SetTextColor(0, 112, 192);
        $pdf->Cell(297,6,"Calendrier prévisionnel ",0,1,'C',false);
        
        $pdf->SetTextColor(237, 129, 49);
        $pdf->Cell(297,6,"".$libelleForm,0,1,'C',false);
        $pdf->SetTextColor(0,32,96);
        $pdf->Cell(297,6,"du ".$dateDeb->format('j')." ".nomMois($dateDeb->format('n'))." ".$dateDeb->format('Y')." au ".$dateFin->format('j')." ".nomMois($dateFin->format('n'))." ".$dateFin->format('Y'),0,1,'C',false);
        
        $pdf->SetFillColor(0, 32, 96);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(287,6,$annee,1,1,'C',true);
        
        
        
    

                //------------------------------------------------------
                    if ($dateFin->format('Y') == intval($dateDeb->format('Y')))
                        $nbMois = intval($dateFin->format('n'));
                    else
                        $nbMois = 12;

                    $pdf->SetFont('Arial','B',12);
                    $pdf->SetFillColor(237, 124, 49);
                    $pdf->SetTextColor(255, 255, 255);
                    
                    for ($m = 1; $m <= $nbMois; $m++) {
                        
                        $pdf->SetXY(23.9*($m-1)+5, 28);
                        $pdf->Cell(24,6,nomMois($m),1,0,'C',true);
                        
                    }
                    //------------------------------------------------------
                    $pdf->Ln();
                    
                     for ($m = 1; $m <= $nbMois; $m++) 
                     {
                         $totalHCMois=0;
                         $totalHEMois = 0 ;
                         
                         $pdf->SetXY(23.9*($m-1)+5, 34);                         
                         $pdf->SetTextColor(255, 255, 255);
                         // haut du mois
                         $pdf->SetFillColor(0, 112, 192);
                         $pdf->SetFont('Arial','B',6);
                         $pdf->Cell(6,4,"Jour",1,0,'C',true);
                         $pdf->Cell(6,4,"Date",1,0,'C',true);
                         $pdf->Cell(2.95,4,"V",1,0,'C',true);
                         $pdf->Cell(4.5,4,"HC",1,0,'C',true);
                         $pdf->Cell(4.5,4,"HE",1,0,'C',true);
                         $pdf->Ln();
                        // $pdf->SetXY($pdf->GetX()-24.58, $pdf->GetY()+5);
                         
                         $nbJours = cal_days_in_month(CAL_GREGORIAN, $m, $annee);

                         //for i allant de 1 a nb jours du mois
                         for ($k = 1; $k <= $nbJours; $k++) 
                         {
                             $pdf->SetXY(23.9*($m-1)+5, 34+4*$k);
                             $pdf->SetFillColor(255,255,255);
                             $pdf->SetTextColor(0,0,0);
                             // on créer une datetime du jour courant
                             $leJour = new DateTime($annee.'-' . $m . '-' . $k);
                             // on recup les données de la date
                             $dataJour = dataJour($leCalendrier,$leJour);
                             
                             
                             if(!empty($dataJour[2]))
                             {
                                 $r= hexdec(substr($dataJour[2],0,2));
                                 $g= hexdec(substr($dataJour[2],2,2));
                                 $b= hexdec(substr($dataJour[2],4,2));
                                 $pdf->SetFillColor($r,$g,$b);
                             }                                 
                             else
                                 if(jourFerié($leJour))
                                     $pdf->SetFillColor(255,204,204);
                                 else
                                     if(estWeekend($leJour))
                                         $pdf->SetFillColor(216,216,216);
                                     else
                                         $pdf->SetFillColor(255,255,255);
                                     
                                 
                             
                             if($dataJour[2]!='d98c4e')
                             {
                             $pdf->Cell(6,4,getDayString($leJour->format('D')),"LBT",0,'C',true);
                             $pdf->Cell(6,4,$k,"BT",0,'C',true);
                             $pdf->Cell(2.95,4,"","BT",0,'C',true);
                             $pdf->Cell(4.5,4,$dataJour[0],"BT",0,'C',true);
                             $pdf->Cell(4.5,4,$dataJour[1],"BTR",0,'C',true);
                             $totalHCMois +=$dataJour[0];
                             $totalHEMois += $dataJour[1];
                             $pdf->Ln();
                             
                             }else
                             {
                                 $pdf->SetFillColor(153,204,255);
                             $pdf->Cell(6,4,getDayString($leJour->format('D')),"LBT",0,'C',true);
                             $pdf->Cell(6,4,$k,"BT",0,'C',true);
                             $pdf->SetFillColor(0,204,153);
                             $pdf->Cell(2.95,4,"","BT",0,'C',true); 
                             $pdf->Cell(4.5,4,$dataJour[0],"BT",0,'C',true);
                             $pdf->Cell(4.5,4,$dataJour[1],"BTR",0,'C',true);
                             $totalHCMois +=$dataJour[0];
                             $totalHEMois += $dataJour[1];
                             $pdf->Ln();
                             }
                            
                             
                             
                             
                             
                                        
                                        
                        }
//Total HC MOIS ----------------------------------------------------------------
                        $pdf->SetFillColor(104, 204, 255);
                        $pdf->SetXY(23.9*($m-1)+5,162);
                        $pdf->Cell(24,4,"Total HC : ".$totalHCMois,1,0,'C',true);
                        //Total HE MOIS
                        $pdf->SetXY(23.9*($m-1)+5,166);
                        $pdf->SetFillColor(153,255,153);
                        $pdf->Cell(24,4,"Total HE : ".$totalHEMois,1,0,'C',true);
                        //TOTAL MOIS
                        $pdf->SetXY(23.9*($m-1)+5,170);
                        $pdf->SetTextColor(255, 255, 255);
                        $pdf->SetFillColor(51,51,204);
                        $totalMois = $totalHEMois+$totalHCMois;
                        $pdf->Cell(24,4,"Total Mois : ".$totalMois,1,0,'C',true);
                        
                         
                      
                         
                     }
                     
// Légende ---------------------------------------------------------------------
                       $pdf->Ln(5); 
                       $pdf->Cell(25,4,"",0,0,'C',false); 
                       $pdf->SetFillColor(153, 204, 255);
                       $pdf->SetTextColor(0, 0, 0);
                       $pdf->Cell(35,4,"Heures de formation en Centre",1,0,'C',true); 
                       $pdf->SetFillColor(0, 204, 153);
                       $pdf->Cell(35,4,"Heures de stage en Entreprise",1,0,'C',true);  
                       $pdf->SetFillColor(255, 80, 80);
                       $pdf->Cell(35,4,"CCF/Examen",1,0,'C',true); 
                       $pdf->SetFillColor(255, 102, 204);
                       $pdf->Cell(35,4,"Examen blanc",1,0,'C',true); 
                       $pdf->SetFillColor(255, 255, 153);
                       $pdf->Cell(35,4,"Vacances scolaires",1,0,'C',true);
                       $pdf->SetFillColor(255, 204, 204);
                       $pdf->Cell(35,4,"Jours Fériés",1,0,'C',true);
                       $pdf->SetFillColor(216, 216, 216);
                       $pdf->Cell(35,4,"Week-end",1,0,'C',true);
                       
//Bilan annuel -----------------------------------------------------------------
                       $Total = BddPdo::sumHeHC($_REQUEST['idCal']);
                       
                       $pdf->SetXY(221,5);
                       $pdf->SetTextColor(255,255,255);
                       $pdf->SetFillColor(0, 112, 192);
                       $pdf->Cell(50,4,"Total des heures en Centre : ".$Total['totalHC'],1,1,'C',true); 
                       
                       $pdf->SetXY(221,9);
                       $pdf->SetFillColor(237, 124, 49);
                       $pdf->Cell(50,4,"Total des heures en Entreprise : ".$Total['totalHE'],1,1,'C',true);
                       
                       $pdf->SetXY(221,13);
                       $pdf->SetFillColor(0, 32, 96);
                       $totalFormation = $Total['totalHC']+$Total['totalHE'];
                       $pdf->Cell(50,4,"TOTAL DE LA FORMATION : ".$totalFormation,1,1,'C',true);
                       
//Contact ----------------------------------------------------------------------
                       
                       $pdf->SetXY(1,179.5);
                       $pdf->SetTextColor(237,124,49);
                       $pdf->Cell(74,4,"Conseiller.e en Formation Continue - Apprentissage",0,0,'C',false); 
                       $pdf->SetTextColor(0,112,192);
                       $pdf->Cell(74,4,"Coordonnateur.rice",0,0,'C',false); 
                       $pdf->SetTextColor(237,124,49);
                       $pdf->Cell(74,4,"Assistant.e de formation",0,0,'C',false);
                       $pdf->SetTextColor(0,112,192);
                       $pdf->Cell(74,4,"Assistant.e de formation",0,0,'C',false); 
                       
                       $pdf->SetXY(1,181.5);
                       $pdf->SetTextColor(237,124,49);
                       $pdf->Cell(74,4,$_REQUEST['NPCFC']." - ( ".$_REQUEST['NCFC']." )",0,0,'C',false); 
                       $pdf->SetTextColor(0,112,192);
                       $pdf->Cell(74,4,$_REQUEST['NPC']." - ( ".$_REQUEST['NC']." )",0,0,'C',false); 
                       $pdf->SetTextColor(237,124,49);
                       $pdf->Cell(74,4,$_REQUEST['NPAF']." - ( ".$_REQUEST['NAF']." )",0,0,'C',false); 
                       $pdf->SetTextColor(0,112,192);
                       $pdf->Cell(74,4,$_REQUEST['NPAF2']." - ( ".$_REQUEST['NAF2']." )",0,0,'C',false); 
                       
                       $pdf->Ln(3);
                       $pdf->SetTextColor(0,32,96);
                       $pdf->Cell(297,4,"G R E T A   C F A   A Q U I T A I N E - Lycée Camille Jullian - 29 rue de la Croix Blanche - BP 11235 - 33074 BORDEAUX CEDEX - ( 05 56 56 04 04 - contact@greta-cfa-aquitaine.fr - www.greta-cfa-aquitaine.fr )",0,0,'C',false);                 
                        
                    
                   
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
         $annee++;           
    }
  
    $pdf->Output();
       




