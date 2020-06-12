<?php


class BddPdo
{
    private static $lePDO ;
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        self::$lePDO = new PDO('mysql:host=localhost;dbname=bdnemo', 'root', '',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        self::$initialized = true;
    }

    public static function createUser($email,$password,$idType)
    {
        self::initialize();
        $sql="insert into utilisateur values ('$email','$password',$idType)";
        $req=self::$lePDO->exec($sql);
        return $req;
    }

    public static function getPassword($email)
    {
        self::initialize();
        $sql="select password from utilisateur where email='".$email."'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req['password'];

    }

    public static function getTypeUtilisateur($email)
    {
        self::initialize();
        $sql="SELECT libelleType FROM `utilisateur`
                INNER JOIN typeutilisateur on typeutilisateur.id = utilisateur.idTypeUtilisateur
                WHERE email = '$email'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req['libelleType'];

    }

    public static function updatePassword($nouveauPass,$email)
    {
        self::initialize();
        $sql="update utilisateur set password='$nouveauPass' where email='$email'";
        $req=self::$lePDO->exec($sql);
        echo $sql;
        return $req;

    }

    public static function getIdUser($email)
    {
        self::initialize();
        $sql="SELECT email FROM utilisateur WHERE email='$email'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req['email'];
    }

    public static function getLesLogo()
    {
        self::initialize();
        $sql="SELECT id, adresseImage FROM `logo`";
        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();
        return $req;

    }

    public static function getLesLogoByUser($email)
    {
        self::initialize();
        $sql="SELECT logo.id, logo.adresseImage FROM `logo`
                INNER join posseder on posseder.idLogo = logo.id
                Inner join utilisateur on utilisateur.email = posseder.email
                where utilisateur.email = '$email'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();
        return $req;

    }

    public static function ajouterImage($nom)
    {
        self::initialize();
        $sql="insert  into logo values(null,'".$nom."')";

        $req=self::$lePDO->exec($sql);

        return $req;
    }
    public static function ajouterImageUtilisateur($idImage,$email)
    {
        self::initialize();
        $sql="insert  into posseder values('$email', $idImage)";
        $req=self::$lePDO->exec($sql);

        return $req;
    }

    public static function supprimerLogo($nom)
    {
        self::initialize();
        $sql="DELETE FROM `logo` WHERE adresseImage='".$nom."'";
        $req=self::$lePDO->exec($sql);

        return $req;
    }
    public static  function supprimerLogoUtilisateur($email,$idLogo)
    {
        self::initialize();
        $sql="DELETE FROM `posseder` WHERE email='$email' and idLogo=$idLogo";
        $req=self::$lePDO->exec($sql);
        return $req;
    }


    public static  function getIdLogo($nom)
    {
        self::initialize();
        $sql="SELECT id from logo where adresseImage='$nom'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req['id'];
    }

    public static function getLesUtilisateur()
    {
        self::initialize();

        $sql="SELECT email FROM `utilisateur`";

        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();

        return $req;

    }

    public static function getNbUtilisateur()
    {
        self::initialize();
        $sql="select count(id) from utilisateur";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();

        return $req;

    }

    public static function deleteUser($email)
    {
        self::initialize();
        $sql="delete from utilisateur where email = '$email'";
        $req=self::$lePDO->exec($sql);
        
        return $req;

    }

    public static function getLesCalendriers($email)
    {
        self::initialize();
        $sql="SELECT DISTINCT nomCalendrier,idCalendrier FROM calendrier WHERE emailUtilisateur = '$email'";
        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();
        return $req;

    }
    public static function getDateDebCal($id)
    {
        self::initialize();
        $sql="SELECT * FROM `calendrier` WHERE idCalendrier=$id ORDER BY annee,mois,jours LIMIT 1";

        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req;

    }
    public static function getDateFinCal($id)
    {
        self::initialize();
        $sql="SELECT * FROM `calendrier` WHERE idCalendrier=$id ORDER BY annee DESC,mois DESC,jours DESC LIMIT 1";

        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req;

    }

    public static function getCalendrier($id)
    {
        self::initialize();
        $sql="SELECT * FROM calendrier WHERE idCalendrier=$id";
        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();
        return $req;

    }
    
    public static function sumHeHC($id)
    {
        self::initialize();
        $sql="SELECT SUM(hc) as totalHC, SUM(HE) as totalHE FROM calendrier WHERE idCalendrier = $id";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req;

    }


    public static function saveCalendar($lesJours,$email,$nomCal,$libelleForm)
    {
        self::initialize();

        $sql = 'SELECT idCalendrier FROM calendrier ORDER BY idCalendrier DESC LIMIT 1';
        echo $sql;
        $req=self::$lePDO->query($sql);
        $id=$req->fetch();
        $id=intval($id['idCalendrier'])+1;

        if(!isset($id))
            $id=1;
        $sql="";
        foreach ($lesJours as $leJour)
        {
            $leJour = new DateTime($leJour);
            $sql = $sql."insert into calendrier values ($id,".$leJour->format('Y').",".$leJour->format('m').",".$leJour->format('d').",'$email','$nomCal',null,null,null,'$libelleForm');";
            
            
        }
        

        $req=self::$lePDO->exec($sql);

        return $req;

    }


    public static function saveHCDate($year,$month,$day,$email,$hc)
    {
        self::initialize();

        $sql="update calendrier set HC=$hc where annee=$year and mois=$month and jours=$day and emailUtilisateur='$email'";
        echo $sql;
        $req=self::$lePDO->exec($sql);
        return $req;

    }
    
    public static function saveHEDate($year,$month,$day,$email,$he)
    {
        self::initialize();

        $sql="update calendrier set HE=$he where annee=$year and mois=$month and jours=$day and emailUtilisateur='$email'";
        echo $sql;
        $req=self::$lePDO->exec($sql);
        return $req;

    }

    public static function saveBgColor($year,$month,$day,$email,$bgColor)
    {
        self::initialize();

        if($bgColor=='NULL')
            $sql="update calendrier set bgColor=null where annee=$year and mois=$month and jours=$day and emailUtilisateur='$email'";
        else
            $sql="update calendrier set bgColor='$bgColor' where annee=$year and mois=$month and jours=$day and emailUtilisateur='$email'";


        $req=self::$lePDO->exec($sql);
        return $req;

    }
    
    public static function getArrayCal($id)
    {
        self::initialize();
        $sql="SELECT * FROM `calendrier` WHERE idCalendrier=$id ORDER BY `calendrier`.`annee` ASC, `calendrier`.`mois` ASC, `calendrier`.`jours` ASC";
        $req=self::$lePDO->query($sql);
        $req=$req->fetchAll();
        
        $res=array();
        foreach($req as $row)
        {
            if(array_search($row['annee'], $res)===false)
           
                array_push ($res,$row['annee']);
   
        }
        
       
        return $req;

    }
    
    public static function deleteCal($idCal)
    {
        self::initialize();

        $sql="delete from calendrier where idCalendrier=$idCal";
        
        $req=self::$lePDO->exec($sql);
        return $req;

    }
    
    public static function getLibelleFormationCal($id)
    {
        self::initialize();
        $sql="SELECT DISTINCT libelleFormation FROM calendrier WHERE idCalendrier=$id";
        $req=self::$lePDO->query($sql);
        $req=$req->fetch();
        return $req;

    }
    
    


}