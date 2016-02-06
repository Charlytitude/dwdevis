<?php
/**
 * User: maff
 * Date: 29/06/13
 */

/**
 * Define $action
 */

if(isset($_POST['action'])){
    $action = $_POST['action'];
}else{
    $action = '';
}

if (isset($_POST['devis'])){
    //check validity
    if (isset($_POST['key']) && $_POST['key'] == DevisUtils::saltDevis($_POST['devis'])){
        $devis = new Devis($_POST['devis']);
        if (isset($_POST['dommage'])){
            if (isset($_POST['key2']) && $_POST['key2'] == DevisUtils::saltDommage($_POST['dommage'])){
                $dommage = new Dommage($_POST['dommage']);
                $dommage->setDevis($devis);
                $piece = $dommage->getPiece();
            }else{
                /* @todo rediriger les hackers */
                //header('Location:/');
            }
        }else{
            $dommage = new Dommage();
        }
        if (isset($_POST['piece'])){
            /* var $piece Piece */
            $piece = DWDevisApplication::$pieces[$_POST['piece']];
        }

    }else{
        /* @todo rediriger les hackers */
        //header('Location:/');
    }
}else{
    $devis = new Devis();
    $dommage = new Dommage();
}


?>



<?php
switch($action){

    case Action::SAVE_IDENTIFICATION:
        $return = hydrateDevisIdentification($_POST);

        $errors = $return['errors'];
        $devis = $return['devis'];

        if(count($errors) > 0){
            include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-identification.php');
        }else{
            $devis->save();
            include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        }
        break;

    case Action::CHOOSE_PIECE:
        /* TODO : contrôler validité pièce */

        if($devis->hasDommageForPiece($piece)){ //on est dans le cas d'une piece existante
            $dommage = $devis->getDommageForPiece($piece);
        }else{ // il s'agit d'un nouveau dommage
            $dommage->setPiece($piece);
        }
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        break;

    /* CREATION DOMMAGE */
    case Action::ADD_DOMMAGE:

        /* TODO : contrôler validité */
        $return = hydrateDommage($_POST, $_FILES);
        $dommage = $return['dommage'];
        $dommage->setDevis($devis);
        $dommage->setPiece($piece);

        $dommage->save();
        $devis->addDommage($dommage);

        /* on reset le dommage */
        $dommage = new Dommage();
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        break;

    case Action::UPDATE_DOMMAGE:

        $return = hydrateDommage($_POST, $_FILES, $dommage);
        $dommage = $return['dommage'];
        $dommage->save();

        $dommage = new Dommage();
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        break;

    case Action::DELETE_PHOTO:
        /* TODO controles */

        $photo = new Photo($_POST['photo']);
        $dommage->removePhoto($photo);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        break;

    case Action::DELETE_DOMMAGE:

        $devis->removeDommage($dommage);
        $dommage = new Dommage();
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-elements.php');
        break;

    case Action::SHOW_RECAPITULATIF:
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-recap.php');
        break;

    case Action::VALIDATE:
        /* TODO envoyer email */
        $devis->setState(EnumDevisState::FINALISED);
        $devis->save();
        DevisHelper::sendConfirmationEmail($devis);
        DevisHelper::sendInternalEmail($devis);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-merci.php');
        break;

    default:
        $errors = array();
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'step-identification.php');
        break;

}

?>

</div>
