<?php
echo "cc";
require_once ('./../modele/BddPdo.php');

$handle = fopen('./../agence_pau_mail.csv','r');
$data = fgetcsv($handle);

$search = explode("+",",");
$replace = explode("+","");


while ( ($data = fgetcsv($handle) ) !== FALSE )
{
    $adresse = str_replace($search, $replace, $data[1]);
    BddPdo::createUser($adresse,md5("greta123456*"),2);
    echo $adresse.'<br>';
}


