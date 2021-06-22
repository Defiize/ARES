
<?php
if (isset($_SESSION['typeUtilisateur']))
{

        switch ($_GET['action']) {
            case 'calendrier':

                $idCal = $_REQUEST['idCal'];
                header('Location: ./vue/v_calendrierFormation.php?controleur=fichePresence&action=gestionLogo&idCal='.$idCal);
                //
                break;
            
            case 'calendrierPDF':

                $idCal = $_REQUEST['idCal'];
                header('Location: ./FPDF/pdfCalendrierFormation.php?idCal='.$idCal);
                
                break;
            case 'gestionCalendrier':


                include_once ('./vue/v_gestionCalendrier.php');
                //
                break;

            case 'saveHCDate':

                $year=$_REQUEST['year'];
                $month=$_REQUEST['month'];
                $day=$_REQUEST['day'];
                $hc=$_REQUEST['hc'];
                $email=$_SESSION['email'];
                BddPdo::saveHCDate($year,$month,$day,$email,$hc);
                break;
            
            case 'saveHEDate':
                
                $year=$_REQUEST['year'];
                $month=$_REQUEST['month'];
                $day=$_REQUEST['day'];
                $he=$_REQUEST['he'];
                $email=$_SESSION['email'];
                BddPdo::saveHEDate($year,$month,$day,$email,$he);
                break;

            case 'saveBgColor':

                $year=$_REQUEST['year'];
                $month=$_REQUEST['month'];
                $day=$_REQUEST['day'];
                $email=$_SESSION['email'];
                $bgColor=$_REQUEST['bgcolor'];
                echo $bgColor;
                BddPdo::saveBgColor($year,$month,$day,$email,$bgColor);
                break;

            case 'createCalendar':

                $dateDeb= new dateTime($_REQUEST['dateDeb']);
                $dateFin=new dateTime($_REQUEST['dateFin']);
                $nomCal=$_REQUEST['nomCal'];
                $libelleForm=$_REQUEST['libelleForm'];
                
                $lesJours = array();


                while ($dateDeb<$dateFin)
                {
                    $laDate = $dateDeb->format('Y-m-d');;
                    array_push($lesJours,$laDate);
                    $dateDeb->add(DateInterval::createFromDateString('1 day'));
                }
                BddPdo::saveCalendar($lesJours,$_SESSION['email'],$nomCal,$libelleForm);
                
                header("Refresh: 0;url=./index.php?controleur=calendrier&action=gestionCalendrier");

                break;
                
                case 'deleteCalendrier':

                $idCal=$_REQUEST['idCal'];
                
                BddPdo::deleteCal($idCal);
                header("Refresh: 0;url=./index.php?controleur=calendrier&action=gestionCalendrier");
                break;
            
            case 'formCalPDF':
                $idCal=$_REQUEST['idCal'];
                include_once ('./vue/v_formCalPDF.php');
                
                break;
            
            case 'genererPDF':
                
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
                
                $idCal=$_REQUEST['idCal'];
                $NPCFC=$_REQUEST['NPCFC'];
                $NCFC=$_REQUEST['NCFC'];
                $NPC=$_REQUEST['NPC'];
                $NC=$_REQUEST['NC'];
                $NPAF=$_REQUEST['NPAF'];
                $NAF=$_REQUEST['NAF'];
                $NPAF2=$_REQUEST['NPAF2'];
                $NAF2=$_REQUEST['NAF2'];
                
                header("Refresh: 0;url=./FPDF/pdfCalendrierFormation.php?idCal=$idCal&NPCFC=$NPCFC&NCFC=$NCFC&NPC=$NPC&NC=$NC&NPAF=$NPAF&NAF=$NAF&NPAF2=$NPAF2&NAF2=$NAF2&logo1=".$lesLogo[0]."&logo2=".$lesLogo[1]."&logo3=".$lesLogo[2]."&logo4=".$lesLogo[3]);
                
                
                break;
            
            
                

        }
        
       

}else
    header("Refresh: 0;./index.php");










