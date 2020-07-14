<?php
/*
Plugin Name: Banco de permutas
Plugin URI: http://www.urcx.com.br
Description: Plugin desenvolvido para gerenciar o banco de permutas
Version: 1.0
Author: Fernando Henrique Souza
Author URI: http://www.
Text Domain: urcx-permutas
License: GPL2
*/
if(!defined('ABSPATH')) exit;

require_once(dirname(__FILE__).'/widgets/permuta-form.php');
require_once(dirname(__FILE__).'/core/database.php');
require_once(dirname(__FILE__).'/admin/dashboard.php');
require_once(dirname(__FILE__).'/admin/lista-pessoas.php');
require_once(dirname(__FILE__).'/admin/match.php');
require_once(dirname(__FILE__).'/admin/info.php');

class UrcxPermutas {
  private static $instance;
  private $database;
  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {
    $this->database = new Urcx_Permutas_Database();
    add_action('admin_menu', array($this, 'set_custom_menu'));
    add_action('widgets_init',array($this, 'register_widgets'));
    register_activation_hook(__FILE__, array($this, 'register_database'));
    register_deactivation_hook(__FILE__, array($this, 'remove_database'));
  }

  public function register_database() {
    $this->database->createDatabase();
  }

  public function remove_database() {
    $this->database->removeDatabase();
  }

  public function register_widgets(){
    register_widget('urcx_permutas_form');
  }

  public function set_custom_menu() {
    add_menu_page(
      'Banco de Permutas',
      'Permutas',
      'manage_options',
      'banco_permutas',
      array($this, 'admin_tela'),
      'dashicons-admin-site-alt3',
      2
    );
    Urcx_Permutas_Lista_Pessoas::getInstance()->registerMenu();
    Urcx_Permutas_Match::getInstance()->registerMenu();
    Urcx_Permutas_Info::getInstance()->registerMenu();
    # Urcx_Permutas_DashBoard::getInstance()->registerMenu();

  }
  public function admin_tela() {
    Urcx_Permutas_Lista_Pessoas::getInstance()->render();
  }
}


UrcxPermutas::getInstance();
