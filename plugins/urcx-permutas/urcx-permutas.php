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

require_once(dirname(__FILE__).'/widgets/permuta-form.php');


class UrcxPermutas {
  private static $instance;

  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {
    add_action('admin_menu', array($this, 'set_custom_menu'));
    add_action('widgets_init',array($this, 'register_widgets'));
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
  }
  public function admin_tela() {
    echo '<h1>Foi</h1>';
  }
}


UrcxPermutas::getInstance();
