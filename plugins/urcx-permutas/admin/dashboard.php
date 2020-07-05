<?php

require_once(dirname(__FILE__).'/../core/admin-page-view.php');

class Urcx_Permutas_DashBoard implements iAdminPageView{

  private static $instance;
  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function registerMenu(){
    add_submenu_page(
      'banco_permutas',
      'Banco de Permutas',
      'Geral',
      'manage_options',
      'banco_permutas_dash',
      array($this, 'render'),
      1

    );
  }
  public function render(){

    $coluna1 = $this->quantidadePostBox();
    $coluna2 = $this->quantidadePostBox();

    echo <<<EOF
    <div class="wrap">
      <h1>Banco de permuta</h1>
      <h3>Resumo</h3>
      <div id="dashboard-widgets" class="metabox-holder">
        <div id="col1" class="postbox-container">
          <div class="meta-box-sortables ui-sortable">
          $coluna1
          </div>
        </div>
        <div id="col2" class="postbox-container">
          <div class="meta-box-sortables ui-sortable">
            $coluna2
          </div>
        </div>
      </div>
    </div>
EOF;
  }
  private function renderPostBox($titulo, $content) {
    return <<<EOF
      <div id="" class="postbox">
        <h2 class="hndle ui-sortable-handle">
          <span>$titulo</span>
        </h2>
        <div class="inside">
          $content
        </div>
      </div>
EOF;

  }

  private function quantidadePostBox() {
    $content = <<<EOF
      <table>

      </table>
EOF;
    return $this->renderPostBox('Quantidade de cadastros', $content);
  }
}
