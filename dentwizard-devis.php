<?php
/*
Plugin Name: DWDevis
Plugin URI: nc
Description: Gestion de demande de devis
Version: 1.0.0
Author: @maffpool
Author URI: http://twitter.com/maffpool
License: GPL2
*/

/*  Copyright 2013  @maffpool (email : matthieu.verrecchia@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(! class_exists( "DWDevisApplication" ) ){

    class DWDevisApplication{

        const DB_VERSION = '1.0';
        const CONTACT_EMAIL = 'adv@dentmaster.fr';

        static $mailfrom = 'Dentwizard <contact@dentwizard.fr>';

        static $menus = array();

        static $capabilities = "manage_options";
        static $plugin_title = "Gestion des devis";

        static $menu_slug = "admin_devis";
        static $menu_title = "Devis";
        static $menu_page_title = "Gérer les devis enregistrés sur Dentwizard";

        static $submenu_slug = "allow-php-information";
        static $submenu_title = "Plugin Information";
        static $submenu_page_title = "Plugin Information";

        static $database_version = "1";
        public $_shared = "";

        /**
         * @var Piece[]
         */
        static $pieces = array();

        /**
         * @var FlashBag[]
         */
        static $flashBags = array();

        public static function init(){

            add_action( "admin_menu", array( __CLASS__, "registerMenu" ));
            wp_enqueue_style( 'devis-back', plugins_url( 'css/devis-back.css', __FILE__ ) );
            wp_enqueue_style( 'devis-front', plugins_url( 'css/devis.css', __FILE__ ) );
            //add_action( 'admin_init', array( __CLASS__, "menu_register_extras"),0);

            /**
             * @var Piece[]
             */
            self::$pieces[1] = new Piece (1, EnumNomPiece::PARE_CHOC, EnumPositionPiece::AV, EnumTypePiece::RAYURE);
            self::$pieces[2] = new Piece (2, EnumNomPiece::PHARE, EnumPositionPiece::AVG, EnumTypePiece::PHARE);
            self::$pieces[3] = new Piece (3, EnumNomPiece::CALANDRE, EnumPositionPiece::NULL, EnumTypePiece::NULL);
            self::$pieces[4] = new Piece (4, EnumNomPiece::PHARE, EnumPositionPiece::AVD, EnumTypePiece::PHARE);
            self::$pieces[5] = new Piece (5, EnumNomPiece::JANTE, EnumPositionPiece::AVG, EnumTypePiece::JANTE);
            self::$pieces[6] = new Piece (6, EnumNomPiece::AILE, EnumPositionPiece::AVG, EnumTypePiece::RAYURE);
            self::$pieces[7] = new Piece (7, EnumNomPiece::RETRO, EnumPositionPiece::AVG, EnumTypePiece::RETRO);
            self::$pieces[8] = new Piece (8, EnumNomPiece::CAPOT, EnumPositionPiece::AV, EnumTypePiece::RAYURE);
            self::$pieces[9] = new Piece (9, EnumNomPiece::RETRO, EnumPositionPiece::AVD, EnumTypePiece::RETRO);
            self::$pieces[10] = new Piece (10, EnumNomPiece::AILE, EnumPositionPiece::AVD, EnumTypePiece::RAYURE);
            self::$pieces[11] = new Piece (11, EnumNomPiece::JANTE, EnumPositionPiece::AVD, EnumTypePiece::JANTE);
            self::$pieces[12] = new Piece (12, EnumNomPiece::BAS_DE_CAISSE, EnumPositionPiece::G, EnumTypePiece::RAYURE);
            self::$pieces[13] = new Piece (13, EnumNomPiece::PORTIERE, EnumPositionPiece::AVG, EnumTypePiece::RAYURE);
            self::$pieces[14] = new Piece (14, EnumNomPiece::PORTIERE, EnumPositionPiece::ARG, EnumTypePiece::RAYURE);
            self::$pieces[15] = new Piece (15, EnumNomPiece::JANTE, EnumPositionPiece::ARG, EnumTypePiece::JANTE);
            self::$pieces[16] = new Piece (16, EnumNomPiece::AILE, EnumPositionPiece::ARG, EnumTypePiece::RAYURE);
            self::$pieces[17] = new Piece (17, EnumNomPiece::MONTANT, EnumPositionPiece::G, EnumTypePiece::RAYURE);
            self::$pieces[18] = new Piece (18, EnumNomPiece::PARE_BRISE, EnumPositionPiece::AV, EnumTypePiece::PAREBRISE);
            self::$pieces[19] = new Piece (19, EnumNomPiece::PAVILLON, EnumPositionPiece::NULL, EnumTypePiece::RAYURE);
            self::$pieces[20] = new Piece (20, EnumNomPiece::LUNETTE, EnumPositionPiece::AR, EnumTypePiece::PAREBRISE);
            self::$pieces[21] = new Piece (21, EnumNomPiece::MONTANT, EnumPositionPiece::D, EnumTypePiece::RAYURE);
            self::$pieces[22] = new Piece (22, EnumNomPiece::PORTIERE, EnumPositionPiece::AVD, EnumTypePiece::RAYURE);
            self::$pieces[23] = new Piece (23, EnumNomPiece::PORTIERE, EnumPositionPiece::ARD, EnumTypePiece::RAYURE);
            self::$pieces[24] = new Piece (24, EnumNomPiece::AILE, EnumPositionPiece::ARD, EnumTypePiece::RAYURE);
            self::$pieces[25] = new Piece (25, EnumNomPiece::JANTE, EnumPositionPiece::ARD, EnumTypePiece::JANTE);
            self::$pieces[26] = new Piece (26, EnumNomPiece::BAS_DE_CAISSE, EnumPositionPiece::D, EnumTypePiece::RAYURE);
            self::$pieces[27] = new Piece (27, EnumNomPiece::PHARE, EnumPositionPiece::ARG, EnumTypePiece::PHARE);
            self::$pieces[28] = new Piece (28, EnumNomPiece::COFFRE, EnumPositionPiece::AR, EnumTypePiece::RAYURE);
            self::$pieces[29] = new Piece (29, EnumNomPiece::PHARE, EnumPositionPiece::ARD, EnumTypePiece::PHARE);
            self::$pieces[30] = new Piece (30, EnumNomPiece::PARE_CHOC, EnumPositionPiece::AR, EnumTypePiece::RAYURE);
        }

        public static function registerFlashBag($type, $message){
            self::$flashBags[] = new FlashBag($type, $message);
        }

        public static function registerMenu(){

            self::$menus[] = add_menu_page(
                self::$menu_page_title,
                self::$menu_title,
                self::$capabilities,
                self::$menu_slug,
                array(__CLASS__, self::$menu_slug),
                self::getImgUrl('menu.gif'),
                '5.21'
            );
            foreach( self::getMenuItems() as $DevisState => $lib ){

                if($DevisState == EnumDevisState::DRAFT){
                    $submenu_slug = self::$menu_slug;
                }else{
                    $submenu_slug = self::$menu_slug . '_' . $DevisState;
                }

                self::$menus[] = add_submenu_page(
                    self::$menu_slug,
                    $lib,
                    $lib,
                    self::$capabilities,
                    $submenu_slug,
                    array(__CLASS__, $submenu_slug)
                );
            }
        }

        public static function getQuestionnaireUrl(){
            return site_url() . '/questionnaire-devis-incomplet/';
        }



        public static function getMenuItems(){

            $counts = DevisRepository::getCountGroupByState();
            $menu = array(
                EnumDevisState::DRAFT => 'Non finalisés (%d)',
                EnumDevisState::FINALISED => 'Demandes à traiter (%d)',
                EnumDevisState::TREATED => 'Demandes traitées (%d)',
                //EnumDevisState::REFUSED => 'Devis refusés (%d)',
                //EnumDevisState::ACCEPTED => 'Devis acceptés (%d)'
            );
            foreach ($menu as $key => $lib){
                $nb = array_key_exists($key, $counts) ? $counts[$key] : 0;
                $menu[$key] = sprintf($lib, $nb);
            }
            return $menu;
        }

        public static function getRootDir(){
            //todo changer ça avec la fonction wordpress correspondante
            return dirname(__FILE__) . DIRECTORY_SEPARATOR;
        }
        public static function getIncludeDir(){
            return self::getRootDir() . 'includes' .DIRECTORY_SEPARATOR;
        }
        public static function getFrontDir(){
            return self::getRootDir() . 'front' .DIRECTORY_SEPARATOR;
        }
        public static function getBackDir(){
            return self::getRootDir() . 'back' .DIRECTORY_SEPARATOR;
        }
        public static function getImgDir(){
            return self::getRootDir() . 'img' .DIRECTORY_SEPARATOR;
        }
        public static function getUploadDir(){
            return self::getRootDir() . 'img' .DIRECTORY_SEPARATOR . 'uploads' .DIRECTORY_SEPARATOR;
        }
        public static function getImgUrl($img){
            return plugins_url('img/' . $img, __FILE__);
        }


        public static function install(){
            self::init();
            global $wpdb;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

            /* Create Devis Table */
            $sql_create_table = 'CREATE TABLE ' . Devis::getTableName() . ' (
                id int(10) unsigned NOT NULL AUTO_INCREMENT,
                utilisateur_id int(11) NOT NULL,
                vehicule_id int(11) NOT NULL,
                state tinyint(3) unsigned NOT NULL,
                creationDate datetime NOT NULL,
                updateDate datetime DEFAULT NULL,
                mailSent tinyint DEFAULT 0 NOT NULL,
                proposition_id int(11) NULL,
                PRIMARY KEY  (id),
                KEY state (state)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            /* Create Dommage Table */
            $sql_create_table = 'CREATE TABLE ' . Dommage::getTableName() . ' (
                id int(11) NOT NULL AUTO_INCREMENT,
                devis_id int(11) NOT NULL,
                piece int(11) NOT NULL,
                type varchar(30) DEFAULT NULL,
                taille varchar(30) DEFAULT NULL,
                peinture char(3) DEFAULT NULL,
                commentaire text,
                demi float NULL,
                complet float NULL,
                simple float NULL,
                complexe float NULL,
                t_mo float NULL,
                qt float NULL,
                tarif float NULL,
                PRIMARY KEY  (id),
                KEY devis_id (devis_id)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            /* Create Photo table */
            $sql_create_table = 'CREATE TABLE ' . Photo::getTableName() . ' (
                id int(11) NOT NULL AUTO_INCREMENT,
                dommage_id int(11) NOT NULL,
                name varchar(50) NOT NULL,
                PRIMARY KEY  (id),
                KEY dommage_id (dommage_id)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            /* Create Utilisateur Table */
            $sql_create_table = 'CREATE TABLE ' . Utilisateur::getTableName() . ' (
                id int(11) NOT NULL AUTO_INCREMENT,
                civilite varchar(5) NOT NULL,
                nom varchar(100) NOT NULL,
                prenom varchar(100) NOT NULL,
                societe varchar(100) DEFAULT NULL,
                code_client varchar(20) DEFAULT NULL,
                adresse varchar(255) NOT NULL,
                cmplt_adresse varchar(255) DEFAULT NULL,
                cp varchar(10) NOT NULL,
                ville varchar(100) NOT NULL,
                pays varchar(50) DEFAULT NULL,
                tel varchar(20) NOT NULL,
                mobile varchar(20) DEFAULT NULL,
                email varchar(100) NOT NULL,
                comment_connu tinyint(4) NOT NULL,
                PRIMARY KEY  (id)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            /* Create Vehicule Table */
            $sql_create_table = 'CREATE TABLE ' . Vehicule::getTableName() . ' (
                id int(11) NOT NULL AUTO_INCREMENT,
                immatriculation varchar(30) NOT NULL,
                marque varchar(50) NOT NULL,
                modele varchar(50) NOT NULL,
                kms int(11) DEFAULT NULL,
                numero_chassis varchar(100) DEFAULT NULL,
                PRIMARY KEY  (id)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            /* Create Devis Table */
            $sql_create_table = 'CREATE TABLE ' . Proposition::getTableName() . ' (
                id int(10) unsigned NOT NULL AUTO_INCREMENT,
                main_oeuvre float  NOT NULL,
                F_prise_charge int  NOT NULL,
                remise int  NOT NULL,
                ht float  NOT NULL,
                ht_r float  NOT NULL,
                tva float  NOT NULL,
                tot float  NOT NULL,
                comment text NULL,
                acompte int  NOT NULL,
                date1 datetime  NOT NULL,
                date2 datetime NOT NULL,
                date3 datetime NOT NULL,
                matin_midi1 tinyint NOT NULL,
                matin_midi2 tinyint NOT NULL,
                matin_midi3 tinyint NOT NULL,
                PRIMARY KEY  (id)
            )' . $charset_collate .';';
            if(dbDelta( $sql_create_table )){
            }else{
            }

            add_option( 'dw_devis_db_version', self::DB_VERSION );

            /* TODO : [création | modification] du répertoire upload avec les bons droits */
            return true;

        }

        public static function uninstall(){
            //todo drop tables ?
        }

        public function render_frontend(){
            require_once(self::getFrontDir() . 'index.php');
        }

        public function admin_devis_0(){ self::admin_devis(0);}
        public function admin_devis_1(){ self::admin_devis(1);}
        public function admin_devis_2(){ self::admin_devis(2);}
        public function admin_devis_3(){ self::admin_devis(3);}
        public function admin_devis_4(){ self::admin_devis(4);}

        public function admin_devis($state){
            define(DEVIS_FILTER_STATE, (int) $state);
            self::render_backend();
        }

        public function render_backend(){
            require_once(self::getBackDir() . 'index.php');
        }

    }

    add_action("init", array('DWDevisApplication', "init"));

    register_activation_hook( __FILE__, array( 'DWDevisApplication', 'install' ) );
    register_uninstall_hook( __FILE__, array( "DWDevisApplication", "uninstall" ) );

    add_shortcode('dwdevis', array('DWDevisApplication', 'render_frontend'));

    require_once (DWDevisApplication::getRootDir() . 'includes.php');

}
