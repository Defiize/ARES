<?php

function jourFerié($date)
{
    $res = false;
    $laDate=$date->format('m-d');
    // verif des jours ferié fixe
    if($laDate=='01-01' || $laDate=='05-01' || $laDate=='05-08' || $laDate=='07-14' || $laDate=='08-15' || $laDate=='11-01' || $laDate=='11-11'
        || $laDate=='12-25')
        $res=true;


    $easterDate = DateTime::createFromFormat('U',easter_date($date->format('Y')))->add(DateInterval::createFromDateString('1 days'));
    $ascension= DateTime::createFromFormat('U',easter_date($date->format('Y')))->add(DateInterval::createFromDateString('40 days'));
    $pentecote = DateTime::createFromFormat('U',easter_date($date->format('Y')))->add(DateInterval::createFromDateString('50 days'));;





    if($easterDate->format('m-d')==$laDate || $ascension->format('m-d')==$laDate || $pentecote->format('m-d')==$laDate)
        $res=true;






    return $res;

}

function estWeekend($date)
{
    if($date->format('D')=='Sat' || $date->format('D')=='Sun')
        return true;
    else
        return false;
}


function nomMois($leMois)
{
    switch ($leMois)
    {
        case 1:
            return "Janvier";
            break;
        case 2:
            return "Février";
            break;
        case 3:
            return "Mars";
            break;
        case 4:
            return "Avril";
            break;
        case 5:
            return "Mai";
            break;
        case 6:
            return "Juin";
            break;
        case 7:
            return "Juillet";
            break;
        case 8:
            return "Aout";
            break;
        case 9:
            return "Septembre";
            break;
        case 10:
            return "Octobre";
            break;
        case 11:
            return "Novembre";
            break;
        case 12:
            return "Décembre";
            break;

    }

}


function dataJour($leCal,$leJour)
{
    $i = 0;
    $max = count( $leCal );
    $trouver = false;

    while( $i < $max && $trouver==false)
    {


        $jourCal = new datetime($leCal[$i]['annee'].'-'.$leCal[$i]['mois'].'-'.$leCal[$i]['jours']);

        if ($leJour == $jourCal)
        {
            $trouver=true;
            $res = array();
            array_push($res,$leCal[$i]['HC'],$leCal[$i]['HE'],$leCal[$i]['bgColor']);
            return $res;
        }
        $i++;


    }

    if (!$trouver)
        return null;


}

function getDayString($day)
{
    switch ($day) {
        case 'Mon':

            return "Lun";
            break;
        case 'Tue':

            return "Mar";
            break;
        case 'Wed':

            return "Mer";
            break;
        case 'Thu':

            return "Jeu";
            break;
        case 'Fri':

            return "Ven";
            break;
        case 'Sat':

            return "Sam";
            break;
        case 'Sun':

            return "Dim";
            break;


    }
}