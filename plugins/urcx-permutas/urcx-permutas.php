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

class UrcxPermutas {
  private static $instance;

  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {

  }
}

UrcxPermutas::getInstance();
