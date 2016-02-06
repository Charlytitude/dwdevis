<?php
/**
 * User: maff
 * Date: 29/06/13
 */

//class wpdb

require_once(DWDevisApplication::getIncludeDir() . 'Devis.php');
require_once(DWDevisApplication::getIncludeDir() . 'Piece.php');
require_once(DWDevisApplication::getIncludeDir() . 'Utilisateur.php');
require_once(DWDevisApplication::getIncludeDir() . 'Vehicule.php');
require_once(DWDevisApplication::getIncludeDir() . 'Dommage.php');
require_once(DWDevisApplication::getIncludeDir() . 'Photo.php');
require_once(DWDevisApplication::getIncludeDir() . 'Proposition.php');

require_once(DWDevisApplication::getIncludeDir() . 'Enum.php');
require_once(DWDevisApplication::getIncludeDir() . 'EnumNomPiece.php');
require_once(DWDevisApplication::getIncludeDir() . 'EnumPositionPiece.php');
require_once(DWDevisApplication::getIncludeDir() . 'EnumTypePiece.php');
require_once(DWDevisApplication::getIncludeDir() . 'EnumDevisState.php');



final class Action extends Enum{
    const SAVE_IDENTIFICATION = 1;
    const CHOOSE_PIECE = 2;
    const ADD_DOMMAGE = 3;
    const UPDATE_DOMMAGE = 4;
    const DELETE_PHOTO = 5;
    const DELETE_DOMMAGE = 6;
    const SHOW_RECAPITULATIF = 7;
    const VALIDATE = 8;
}

final class EnumCivilite extends Enum{
    const MR = 'Mr';
    const MME = 'Mme';
    const MLLE = 'Mlle';

    public $libs = array(
        self::MR => 'Mr',
        self::MME => 'Mme',
        self::MLLE => 'Mlle'
    );
}

final class EnumConnu extends Enum{
    const UNKNOWN = 0;
    const INTERNET = 1;
    const PRESSE = 2;
    const TV = 3;
    const BOUCHE_A_OREILLE = 4;
    const FACEBOOK = 5;
    const CAMION = 6;
    const RELATION = 7;
    const AUTRE = 8;

    public static $libs = array(
        self::UNKNOWN => '',
        self::INTERNET => 'Internet',
        self::PRESSE => 'Presse',
        self::TV => 'TV',
        self::BOUCHE_A_OREILLE => 'Bouche a oreille',
        self::FACEBOOK => 'Facebook',
        self::CAMION => 'En croisant un de nos camions',
        self::RELATION => 'Relation',
        self::AUTRE => 'Autre'
    );

}

final class EnumTypeDommage extends Enum{
    const UN_IMPACT = 'un_impact';
    const PLUSIEURS_IMPACTS = 'plusieurs_impacts';
    const RAYURE = 'rayure';
    const ENFONCEMENT = 'enfoncement';
    const RAYURE_ENFONCEMENT = 'rayure_et_enfoncement';

    public static $libs = array(
        self::UN_IMPACT => '1 impact',
        self::PLUSIEURS_IMPACTS => 'Plusieurs impacts',
        self::RAYURE => 'Bosse',
        self::ENFONCEMENT => 'Dommage de grêle',
        self::RAYURE_ENFONCEMENT => 'Autre'
    );

}


final class EnumPeintureDommage extends Enum{
    const OUI = 'oui';
    const NON = 'non';

    public static $libs = array(
        self::OUI => 'OUI',
        self::NON => 'NON'
    );

}

final class EnumTailleDommage extends Enum{
    const PETIT = 'petit';
    const MOYEN = 'moyen';
    const GROS = 'gros';
    public static $libs = array(
        self::PETIT => 'Petit',
        self::MOYEN => 'Moyen',
        self::GROS => 'Gros'
    );
}


final class DevisUtils{


    //TODO à implementer pour le back
    public static function generateUrl(){}


    /**
     * @return bool|string
     */
    public static function now(){
        return date("Y-m-d H:i:s");
    }

    /**
     * @param int $num
     * @return string
     */
    public static function saltDevis($num){
        $salt = md5('azertyuiop123!!AZERTY');
        return md5($num . $salt);
    }

    /**
     * @param int $num
     * @return string
     */
    public static function saltDommage($num){
        $salt = md5('AZERTYazertyuiop123!!');
        return md5($num . $salt);
    }

    /**
     * @param string $img
     * @return string
     */
    public static function getPhotoUrl($img){
        /* Todo voir wordpress et les assets */
        return DWDevisApplication::getImgUrl('uploads/' . $img);
    }

    /**
     * @param string $img
     * @return string
     */
    public static function getPhotoDir($img){
        return DWDevisApplication::getUploadDir() . $img;
    }

    /**
     * @param string $img
     * @return bool
     */
    public static function validateUploadedImage($img){
        //TODO check
        return true;
    }
    public static function checkMandatoryString( $str ){
        //TODO check
        if( '' == $str ) return false;
        return $str;
    }
    public static function checkOptionalString( $str ){
        //TODO check
        return $str;
    }
    public static function checkMandatoryNumber( $str ){
        //TODO check
        if($str == '' ||  !is_numeric($str) ) return false;
        return $str;
    }
    public static function checkOptionalNumber( $str ){
        //TODO check
        if($str != '' &&  !is_numeric($str) ) return false;
        return $str;
    }
    public static function checkEmails($email, $email2){
        if($email == '') return false;
        if($email != $email2) return false;
        //TODO if !is_email
        return $email;
    }
    public static function checkMandatoryEnum($val, $enumClass){
        //TODO check
        //enum should be a class extending Enum
        //Reflection ? check instanceof xxx ? implement_of xxx ?
        return $val;
        //if (!$enumClass::hasEnum($val)) return false;
    }


}

class FlashBag{

    const SUCCES = 'success';
    const ERROR = 'error';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    public function __construct($type, $message){
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }


}

function checkForm($whichForm, &$data){
    return true;
    switch ($whichForm){
    }
}

/**
 * @param array $post
 * @param Devis $devis
 * @return Devis
 */
function hydrateDevisIdentification(Array $post, Devis $devis = null){
    if($devis === null){
        $devis = new Devis();
    }
    $errors = array();

    foreach ($post as $k=>$v){
        $$k = trim(stripslashes($v));
    }


    $devis->getUtilisateur()->setCivilite($civilite);
    $devis->getUtilisateur()->setNom($nom);
    $devis->getUtilisateur()->setPrenom($prenom);
    $devis->getUtilisateur()->setSociete($societe);
    $devis->getUtilisateur()->setCodeClient($code_client);
    $devis->getUtilisateur()->setAdresse($adresse);
    $devis->getUtilisateur()->setComplementAdresse($cmplt_adresse);
    $devis->getUtilisateur()->setCp($cp);
    $devis->getUtilisateur()->setVille($ville);
    $devis->getUtilisateur()->setPays($pays);
    $devis->getUtilisateur()->setTel($tel);
    $devis->getUtilisateur()->setMobile($mobile);
    $devis->getUtilisateur()->setEmail($email);
    $devis->getUtilisateur()->setCommentConnu($comment_connu);
    $devis->getVehicule()->setImmatriculation($immatriculation);
    $devis->getVehicule()->setMarque($marque);
    $devis->getVehicule()->setModele($modele);
    $devis->getVehicule()->setModele($modele);
    $devis->getVehicule()->setKms($kms);
    $devis->getVehicule()->setNumeroChassis($numero_chassis);


    $civilite           = DevisUtils::checkMandatoryEnum($civilite, 'EnumCivilite');
    $nom                = DevisUtils::checkMandatoryString($nom);
    $prenom             = DevisUtils::checkMandatoryString($prenom);
    $societe            = DevisUtils::checkOptionalString($societe);
    $code_client        = DevisUtils::checkOptionalString($code_client);
    $adresse            = DevisUtils::checkMandatoryString($adresse);
    $cmplt_adresse      = DevisUtils::checkOptionalString($complement_adresse);
    $cp                 = DevisUtils::checkMandatoryString($cp);
    $ville              = DevisUtils::checkMandatoryString($ville);
    $pays               = DevisUtils::checkOptionalString($pays);
    $tel                = DevisUtils::checkMandatoryString($tel);
    $mobile             = DevisUtils::checkOptionalString($mobile);
    $email              = DevisUtils::checkEmails($email, $confirm_email);
    $comment_connu      = DevisUtils::checkMandatoryEnum($comment_connu, 'EnumConnu');
    $immatriculation    = DevisUtils::checkMandatoryString($immatriculation);
    $marque             = DevisUtils::checkMandatoryString($marque);
    $modele             = DevisUtils::checkMandatoryString($modele);
    $kms                = DevisUtils::checkOptionalNumber($kms);
    $numero_chassis     = DevisUtils::checkOptionalString($numero_chassis);

    if(false === $civilite)         $errors['civilite'] = true;
    if(false === $nom)              $errors['nom'] = true;
    if(false === $prenom)           $errors['prenom'] = true;
    if(false === $societe)          $errors['societe'] = true;
    if(false === $code_client)      $errors['code_client'] = true;
    if(false === $adresse)          $errors['adresse'] = true;
    if(false === $cmplt_adresse)    $errors['complement_adresse'] = true;
    if(false === $cp)               $errors['cp'] = true;
    if(false === $ville)            $errors['ville'] = true;
    if(false === $pays)             $errors['pays'] = true;
    if(false === $tel)              $errors['tel'] = true;
    if(false === $mobile)           $errors['mobile'] = true;
    if(false === $email)            $errors['email'] = true;
    if(false === $comment_connu)    $errors['comment_connu'] = true;
    if(false === $immatriculation)  $errors['immatriculation'] = true;
    if(false === $marque)           $errors['marque'] = true;
    if(false === $modele)           $errors['modele'] = true;
    if(false === $modele)           $errors['modele'] = true;
    if(false === $kms)              $errors['kms'] = true;
    if(false === $numero_chassis)   $errors['numero_chassis'] = true;


    return array('devis' => $devis, 'errors' => $errors);
}

/**
 * @param array $post
 * @param array $files
 * @param Dommage $dommage
 * @return Dommage
 */
function hydrateDommage(array $post, array $files, Dommage $dommage = null){
    if($dommage === null){
        $dommage = new Dommage();
    }

    //TODO gestion erreurs notament min 1 fichier
    $errors = array();

    foreach ($post as $k=>$v){
        $$k = trim(stripslashes($v));
    }


    if(isset($taille)){
        $dommage->setTaille($taille);
    }
    if(isset($type)){
        $dommage->setType($type);
    }
    if(isset($peinture)){
        $dommage->setPeinture($peinture);
    }

    $dommage->setCommentaire($commentaire);


    for($i=1; $i<=3; ++$i){
        if(isset($files['photo' . $i])){
            $file = $files['photo' . $i];
            /* TODO better control (mime) */
            if($file['name']){
                $photo = new Photo();
                $photo->setFile($file);
                $dommage->addPhoto($photo);
            }
        }
    }


    return array('dommage' => $dommage, 'errors' => $errors);
}

/**
 * @param Piece $piece
 * @param Devis $devis
 * @return string
 */
function element_is_on_off(Piece $piece, Devis $devis) {

    if ($devis->hasElement($piece)) return 'on';
    return 'off';
}
