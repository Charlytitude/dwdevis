<?php
/**
 * User: maff
 * Date: 30/06/13
 */

if ( ! class_exists( 'WP_List_Table' ) ){
    //require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
/**
 * Controler
 */
if(!isset($_GET['view'])){
    $view = 'list';
}else{
    $view = $_GET['view'];
}

if(isset($_GET['do'])){
    //todo checker enum pour do
    $do = $_GET['do'];
}

$page = $_GET['page'];
$redirect = false;

switch($do){

    case 'send_mail':
        $devis = new Devis($_GET['id']);
        require_once 'do-send-mail.php';
        break;

    case 'create_proposition':
        $devis = new Devis($_GET['id']);
        require_once 'do-create-proposition.php';
        break;

    case 'mark_as_treated':
        $devis = new Devis($_GET['id']);
        $devis->setState(EnumDevisState::TREATED);
        $devis->save();
        $redirect = sprintf('admin.php?page=%s&view=devis&id=%d&flash=1', $page, $devis->getId());
        break;

    case 'mark_as_finalised':
        $devis = new Devis($_GET['id']);
        $devis->setState(EnumDevisState::FINALISED);
        $devis->save();
        $redirect = sprintf('admin.php?page=%s&view=devis&id=%d&flash=2', $page, $devis->getId());
        break;

    case 'delete':
        $devis = new Devis($_GET['id']);
        $devis->setState(EnumDevisState::DELETED);
        $devis->save();
        $redirect = sprintf('admin.php?page=%s&id=%d&flash=3', $page, $devis->getId());
        break;

}

if($redirect){
    echo '<script>window.location = "' . $redirect . '";</script>';
    exit();
}


if(isset($_GET['flash'])){
    switch ($_GET['flash']){
        case 1:
            DWDevisApplication::registerFlashBag(FlashBag::SUCCES, 'Ce devis a bien été marqué comme traité');
            break;
        case 2:
            DWDevisApplication::registerFlashBag(FlashBag::SUCCES, 'Ce devis a bien été marqué comme finalisé');
            break;
        case 3:
            DWDevisApplication::registerFlashBag(FlashBag::SUCCES, 'Le devis #'.$_GET['id'].' a bien été archivé');
            break;
    }
}

?>

<div class="devis-messages">
    <?php /** var FlashBag[] */ ?>
    <?php foreach(DWDevisApplication::$flashBags as $fb): ?>

        <div class="devis-<?php echo $fb->getType() ?>-message">
            <p><?php echo $fb->getMessage() ?></p>
        </div>

    <?php endforeach; ?>
</div>



<?php
switch ($view){

    case 'list':
        $liste = DevisRepository::getWithStateEquals(DEVIS_FILTER_STATE);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view-liste.php');
        break;

    case 'devis':
        /* TODO : Controler variable */
        $devis = new Devis($_GET['id']);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view-detail-static.php');
        break;

    case 'dommage':
        /* TODO : Controler variable */
        $dommage = new Dommage($_GET['id']);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view-dommage.php');
        break;

    default:
        $liste = DevisRepository::getWithStateEquals(DEVIS_FILTER_STATE);
        include (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'view-liste.php');
        break;
}


?>
