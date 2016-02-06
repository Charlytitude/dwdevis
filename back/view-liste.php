<?php
/**
 * User: maff
 * Date: 30/06/13
 */
/* TODO : terminer (ou pas) cette classe */
class DWDevis_List_Table extends WP_List_Table {

    public static function define_columns() {
        return array(
            'id' => '#',
            'date' => 'Date',
            'name' => 'Nom / Prénom',
            'marque' => 'Marque',
            'immat' => 'Immatriculation',
            'cp' => 'Code postal',
            'state' => 'Etat',
            'action' => 'Actions'
        );
    }

    function __construct() {
        parent::__construct( array(
            'singular' => 'post',
            'plural' => 'posts',
            'ajax' => false ) );
    }

    function prepare_items() {

        $this->_column_headers = $this->get_column_info();

        $this->items = DevisRepository::getWithStateEquals(DEVIS_FILTER_STATE);

        $total_items = count($this->items);
        $total_pages = 1;

        $this->set_pagination_args( array(
            'total_items' => $total_items,
            'total_pages' => $total_pages,
            'per_page' => 0 ) );
    }

    function get_columns() {
        return get_column_headers( get_current_screen() );
    }

    function get_sortable_columns() {
        return array();
        $columns = array(
            'title' => array( 'title', true ),
            'author' => array( 'author', false ),
            'date' => array( 'date', false ) );

        return $columns;
    }

    function get_bulk_actions() {
        return array();
        $actions = array(
            'delete' => __( 'Delete', 'wpcf7' ) );

        return $actions;
    }

    function column_default( $item, $column_name ) {
        return '';
    }

    function column_id( $devis ){
        return '<a href="?view=devis&id=' . $devis->getId() . '">#' . $devis->getId() . '</a>';
    }
    function column_date( $devis ){
        return date('d/m/Y', strtotime($devis->getCreationDate()));
    }
    function column_name( $devis ){
        return htmlentities($devis->getUtilisateur());
    }
    function column_marque( $devis ){
        return htmlentities($devis->getVehicule()->getMarque());
    }
    function column_immat( $devis ){
        return htmlentities($devis->getVehicule()->getImmatriculation());
    }
    function column_cp( $devis ){
        return htmlentities($devis->getUtilisateur()->getCp());
    }
    function column_state( $devis ){
        return EnumDevisState::$libs[$devis->getState()];
    }
    function column_actions( $devis ){
        return '<a href="?view=devis&id=' . $devis->getId() . '">#' . $devis->getId() . '</a>';
    }

    function column_title( $item ) {
        $url = admin_url( 'admin.php?page=wpcf7&post=' . absint( $item->id ) );
        $edit_link = add_query_arg( array( 'action' => 'edit' ), $url );

        $actions = array(
            'edit' => '<a href="' . $edit_link . '">' . __( 'Edit', 'wpcf7' ) . '</a>' );

        if ( current_user_can( 'wpcf7_edit_contact_form', $item->id ) ) {
            $copy_link = wp_nonce_url(
                add_query_arg( array( 'action' => 'copy' ), $url ),
                'wpcf7-copy-contact-form_' . absint( $item->id ) );

            $actions = array_merge( $actions, array(
                'copy' => '<a href="' . $copy_link . '">' . __( 'Copy', 'wpcf7' ) . '</a>' ) );
        }

        $a = sprintf( '<a class="row-title" href="%1$s" title="%2$s">%3$s</a>',
            $edit_link,
            esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'wpcf7' ), $item->title ) ),
            esc_html( $item->title ) );

        return '<strong>' . $a . '</strong> ' . $this->row_actions( $actions );
    }

}

/*$list_table = new DWDevis_List_Table();
$list_table->prepare_items();
$list_table->display();*/

?>

<div class="tablenav top">

    <table class="wp-list-table widefat fixed posts">
        <thead>
            <th>#</th>
            <th>Date</th>
            <th>Nom/Pr&eacute;nom</th>
            <th>Marque</th>
            <th>Immatriculation</th>
            <th>Code postal</th>
            <th>Etat</th>
            <th>Actions</th>
            <th>Supprimer</th>
        </thead>
        <tbody>
        <?php if(count($liste)) : ?>

            <?php /* @var $liste Devis[] */ ?>
            <?php foreach($liste as $devis): ?>
            <tr>
                <td><a href="?page=<?php echo $page ?>&view=devis&id=<?php echo $devis->getId(); ?>"><?php echo $devis->getId() ?></a></td>
                <td><?php echo date('d/m/Y', strtotime($devis->getCreationDate())); ?></td>
                <td><?php echo htmlentities($devis->getUtilisateur()) ?></td>
                <td><?php echo htmlentities($devis->getVehicule()->getMarque()) ?></td>
                <td><?php echo htmlentities($devis->getVehicule()->getImmatriculation()) ?></td>
                <td><?php echo htmlentities($devis->getUtilisateur()->getCp()) ?></td>
                <td><?php echo EnumDevisState::$libs[$devis->getState()] ?></td>
                <td>
                    <?php
                    switch($devis->getState()){
                        case EnumDevisState::DRAFT:
                            if($devis->getMailSent()){
                                echo 'Email envoyé';
                            }else{
                                echo '<a class="a-mail" href="?page=' . $page . '&do=send_mail&id=' . $devis->getId() . '">Envoyer l\'e-mail</a>';
                            }
                            break;

                        default:
                            echo '<a class="a-view" href="?page=' . $page . '&view=devis&id=' . $devis->getId() .'">Voir le d&eacute;tail</a>';
                            break;
                    }?>
                </td>
                <td>
                    <a class="a-del" href="?page=<?php echo $page ?>&do=delete&id=<?php echo $devis->getId() ?>"><img width="25" src="<?php echo DWDevisApplication::getImgUrl('corbeille.png') ?>" /></a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan = "8">Aucun résultat ne correspond à votre recherche</td>
            </tr>
        <?php endif; ?>
    </tbody>
    </table>

</div>
