<!doctype html>

<head>
    <meta charset="utf-8">
    <title>Calendrier de formation</title>
    <link rel="stylesheet" href="./../css/css_calendrier.css">
    <link rel="stylesheet" href="./../css/css_legendCalendrier.css">

    <script>
        var color ;
        var totalHC = new Object();
        var totalHE = new Object();
  
        function sumArray(arr)
        {
            var total = 0;
            var i;
            
            for (i=1;i<=Object.keys(arr).length;i++)
            {
                
                total += arr[i];
            }
            return total;
        }


        function saveHCCalendar(year,month,day) {
            var id = parseInt(""+year+month+day);
            var hc = document.getElementById('HC'+id).value;
            if(hc == null || hc == "")
            {
                 hc=null;
                 totalHC[""+year+month][""+day]=parseFloat(0);
            }
            else
                totalHC[""+year+month][""+day]=parseFloat(hc);
               
            var xhr = new XMLHttpRequest();

            var  url = './../index.php?controleur=calendrier&action=saveHCDate&year='+year+'&month='+month+'&day='+day+'&hc='+hc
            //alert(url);
            xhr.open('GET', url);
            xhr.send(null);
            
            document.getElementById('HCBilan'+year+month).innerHTML = sumArray(totalHC[""+year+month]);
            document.getElementById('totalMois'+year+month).innerHTML = sumArray(totalHC[""+year+month]) + sumArray(totalHE[""+year+month]) ;
            
   

        }
        
        function saveHECalendar(year,month,day) {
            var id = parseInt(""+year+month+day);
            var he = document.getElementById('HE'+id).value;
            if(he == null || he == "")
            {
                 he=null;
                 totalHE[""+year+month][""+day]=parseFloat(0);
            }
            else
                totalHE[""+year+month][""+day]=parseFloat(he);
               
            var xhr = new XMLHttpRequest();

            var  url = './../index.php?controleur=calendrier&action=saveHEDate&year='+year+'&month='+month+'&day='+day+'&he='+he
//            alert(url);
            xhr.open('GET', url);
            xhr.send(null);
            
            document.getElementById('HEBilan'+year+month).innerHTML = sumArray(totalHE[""+year+month]);
            document.getElementById('totalMois'+year+month).innerHTML = sumArray(totalHC[""+year+month]) + sumArray(totalHE[""+year+month]) ;
           
   

        }

        function setColor(uneCouleur)
        {
            if (uneCouleur==color)
            {
                color = null;
                document.body.style.cursor= "default"
            }else
            {
                color = uneCouleur;
                var laCouleur = color.replace('#','')
                document.body.style.cursor= "url('./../image/cursor-"+laCouleur+".png'), wait"
            }

        }
        

        function changeBackgroundColor(year,month,day)
        {
            if(color!='none' && color!='null' && color!=undefined)
            {
                document.getElementById("Row"+year+month+day).style.backgroundColor=color;
                var xhr = new XMLHttpRequest();
                var laCouleur = color.replace('#','')
                var  url = './../index.php?controleur=calendrier&action=saveBgColor&year='+year+'&month='+month+'&day='+day+'&bgcolor='+laCouleur
                xhr.open('GET', url);
                xhr.send(null);

            }
            else
            {
                if (color!=null)
                {
                    document.getElementById("Row"+year+month+day).style.backgroundColor='white';
                    var xhr = new XMLHttpRequest();
                    var  url = './../index.php?controleur=calendrier&action=saveBgColor&year='+year+'&month='+month+'&day='+day+'&bgcolor=NULL'

                    xhr.open('GET', url);
                    xhr.send(null);
                }

            }

        }


    </script>

    <?php

    //Initialisation variables
    include_once ('./../controleur/function_calendrier.php');
    include_once ('./../modele/BddPdo.php');


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



    ?>

</head>


<body>
<button onclick="window.location.href = './../index.php?controleur=calendrier&action=formCalPDF&idCal=<?php echo $_REQUEST['idCal']?>';">Générer le PDF</button>
<div class="HautPage">

    <div class="logoGreta"><img src="./../image/logo.png" alt=""></div>
    <h1>Calendrier prévisionnel </h1>
    <h2><?php echo $libelleForm ?></h2>
    <h3> du <?php echo $dateDeb->format('j')." ".nomMois($dateDeb->format('n'))." ".$dateDeb->format('Y') ?>
    au <?php echo $dateFin->format('j')." ".nomMois($dateFin->format('n'))." ".$dateFin->format('Y') ?>
    </h3>
</div>

<div class="Calendrier">

    <?php



    //boucles années
    for($a=0;$a<=$nbAnnee;$a++) {


        ?>

        <div class="legende">
            Cliquer sur une couleur pour la sélectionner <br>
            <div class="uneLegende"> <div class="legendeCentre" onclick="setColor('#99ccff')"></div> En Centre </div>
            <div class="uneLegende"> <div class="legendeMixte" onclick="setColor('#d98c4e')"></div> En Centre et Entreprise </div>
            <div class="uneLegende"> <div class="legendeEntreprise" onclick="setColor('#00cc99')"></div> En Entreprise </div>
            <div class="uneLegende"> <div class="legendeCCF" onclick="setColor('#ff5050')"></div> CCF/Examens </div>
            <div class="uneLegende"> <div class="legendeExamBlanc" onclick="setColor('#ff66cc')"></div> Examen blanc </div>
            <div class="uneLegende"> <div class="legendeVacSco" onclick="setColor('#ffff99')"></div> Vacances scolaires </div>
            <div class="uneLegende"> <div class="legendeJoursFerie" onclick="setColor('#ffcccc')"></div> Jours Fériés </div>
            <div class="uneLegende"> <div class="legendeWeekEnd" onclick="setColor('#d8d8d8')"></div> Week-end </div>
            <div class="uneLegende"> <div class="legendeReset" onclick="setColor('none')"></div> Effacer </div>

        </div>

        <table class="tableauCalendar">
            <tr>
                <td class="annee"><?php echo $annee; ?></td>
            </tr>

            <tr>
                <table class="tableauMois" >
                    <?php

                    if ($dateFin->format('Y') == intval($dateDeb->format('Y')))
                        $nbMois = intval($dateFin->format('n'));
                    else
                        $nbMois = 12;

                    for ($m = 1; $m <= $nbMois; $m++) {
                        echo '<td class="mois">' . nomMois($m) . '</td>';
                    }

                    ?>
                    <tr>
                        <?php
                        for ($m = 1; $m <= $nbMois; $m++) {
                            
                            ?>
                        <script type="text/javascript">totalHC[<?php echo $annee.$m ;?>]=new Object();</script>
                        <script type="text/javascript">totalHE[<?php echo $annee.$m ;?>]=new Object();</script>
                        
                            <td class="headerMois">
                                <table class="tableJours">
                                    <tr class="jours">
                                        <td>Jour</td>
                                        <td>Date</td>
                                        <td>V</td>
                                        <td>HC</td>
                                        <td>HE</td>
                                    </tr>

                                    <?php
                                    // si deniers moi on va jusqu'au jour de fin sinon jusqu'a la fin du mois
                                    if($annee==$dateFin->format('Y') && $m==$dateFin->format('n'))
                                        $nbJours=$dateFin->format('j');
                                    else
                                        $nbJours = cal_days_in_month(CAL_GREGORIAN, $m, $annee);

                                    //for i allant de 1 a nb jours du mois
                                    for ($k = 1; $k <= $nbJours; $k++) {
                                        // on créer une datetime du jour courant
                                        $leJour = new DateTime($annee.'-' . $m . '-' . $k);
                                        // on recup les données de la date
                                        $dataJour = dataJour($leCalendrier,$leJour);
                                        
                                     

                                        ?>
                                        <!-- création du tableau -->
                                        <tr class="<?php if(jourFerié($leJour)) echo 'ferie '; if(estWeekend($leJour)) echo 'weekend '?>" id="Row<?php echo $annee; ?><?php echo $m; ?><?php echo $k; ?>" onclick="changeBackgroundColor(<?php echo $annee; ?>,<?php echo $m; ?>,<?php echo $k; ?>)" style="background-color: <?php echo '#'.$dataJour[2]; ?>">
                                            <td>
                                                <?php

                                                echo getDayString($leJour->format('D'));

                                                ?>
                                            </td>
                                            <td><?php echo $k; ?></td>
                                            <td></td>
                                            <td><input type="number" id='HC<?php echo $annee; ?><?php echo $m; ?><?php echo $k; ?>' onchange="saveHCCalendar(<?php echo $annee; ?>,<?php echo $m; ?>,<?php echo $k; ?>)"
                                                value="<?php echo $dataJour[0];?>">
                                            </td>
                                                        <script type="text/javascript">totalHC[<?php echo $annee.$m ;?>][<?php echo $k ;?>]=<?php if($dataJour[0]!="")echo $dataJour[0]; else echo "0";?></script>
                                            
                                            <td><input type="number" id='HE<?php echo $annee; ?><?php echo $m; ?><?php echo $k; ?>' onchange="saveHECalendar(<?php echo $annee; ?>,<?php echo $m; ?>,<?php echo $k; ?>)"
                                                value="<?php echo $dataJour[1];?>"></td>
                                            <script type="text/javascript">totalHE[<?php echo $annee.$m ;?>][<?php echo $k ;?>]=<?php if($dataJour[1]!="")echo $dataJour[1]; else echo "0";?></script>
                                            
                                        </tr>

                                    <?php } ?>

                                   


                                </table>
                            </td>
                        <?php } ?>

                    </tr>
                    <tr class="trBilanMois">
                        <?php 
                        for ($m = 1; $m <= $nbMois; $m++) { ?>
                        <td class="tdTableBilan">
                            <table class="tableBilan">
                                <tr class="trTotalMois totalHC">
                                    <td class="tdBilanMois">Total HC</td>
                                    <td class="tdBilanMois" id="HCBilan<?php echo $annee.$m  ?>"></td>          
                                </tr>
                                <tr class="trTotalMois totalHE">
                                    <td class="tdBilanMois">Total HE</td>
                                    <td class="tdBilanMois" id="HEBilan<?php echo $annee.$m  ?>" ></td>   
                                </tr>
                                <tr class="trTotalMois totalMois">
                                    <td class="tdBilanMois">Total Mois</td>
                                    <td class="tdBilanMois" id="totalMois<?php echo $annee.$m  ?>"></td>   
                                </tr>
                            </table>
                        </td>
                        
                    <script>
                        document.getElementById('HCBilan<?php echo $annee.$m  ?>').innerHTML = sumArray(totalHC[<?php echo $annee.$m  ?>]);
                        document.getElementById('HEBilan<?php echo $annee.$m  ?>').innerHTML = sumArray(totalHE[<?php echo $annee.$m  ?>]);
                        document.getElementById('totalMois<?php echo $annee.$m  ?>').innerHTML = sumArray(totalHC[<?php echo $annee.$m  ?>]) +  sumArray(totalHE[<?php echo $annee.$m  ?>]);
                    </script>
                        <?php } ?>
                        
                    </tr>

                </table>
            </tr>


        </table>
        <?php
        $annee++;
    }

        ?>
</div>

    <div class="recapCal">
        <?php $Total = BddPdo::sumHeHC($_REQUEST['idCal'])?>
        <table>
            <tr class="recapCalRow1">
                <td>Total des heures en Centre</td>
                <td> <?php echo $Total['totalHC'];?></td>
            </tr>
            <tr class="recapCalRow2">
                <td>Total des heures en Entreprise</td>
                <td><?php echo $Total['totalHE'];?></td>
            </tr>
            <tr class="recapCalRow3">
                <td>TOTAL DE LA FORMATION</td>
                <td><?php echo $Total['totalHE']+$Total['totalHC'];?></td>
            </tr>
        </table>
    </div>

</body>
</html>

