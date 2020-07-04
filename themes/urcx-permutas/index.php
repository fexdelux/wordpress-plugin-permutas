<?PHP

/*
Plugin Name: Minhas Redes Sociais
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para exibir as minhas redes sociais
Version: 1.0
Author: Elton Oliveira
Author URI: http://meusite.com.br
Text Domain: minhas-redes-sociais
License: GPL2
*/

class Minhas_Redes {
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

Minhas_Redes::getInstance();
