<?php

require_once(dirname(__FILE__).'/../core/admin-page-view.php');

class Urcx_Permutas_Lista_Pessoas implements iAdminPageView{

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
      'Banco de Permutas - Lista de Pessoas',
      'Lista Pessoas',
      'manage_options',
      'banco_permutas_lista',
      array($this, 'render'),
      2

    );
  }
  public function getCadasroList($filter, $orgao) {
    global $wpdb;
    $qrypesquisa = "
      SELECT
      p.id,
      p.nome,
      p.cargo,
      p.email,
      p.telefone,
      p.municipio,
      og.nome as orgao
      FROM
        {$wpdb->prefix}permutas_orgaos as og
        join {$wpdb->prefix}permutas_pessoas as p on p.id_orgao = og.id
        where 1=1
    ";
    if(isset($filter)) {
      $qrypesquisa .= "  and p.nome like '$filter%'";
    }
    if(isset($orgao) && $orgao != '') {
      $qrypesquisa .= "  and p.id_orgao = $orgao";
    }
    $list = $wpdb->get_results( $qrypesquisa, OBJECT );

    return $list;
  }

  public function getCadasro($id) {
    global $wpdb;
  }

  public function deleteCadastro($lista) {
    global $wpdb;
    foreach($lista as $item) {
      $wpdb->query(
        $wpdb->prepare( "DELETE FROM {$wpdb->prefix}permutas_ir_para WHERE id_pessoa = %d", $item )
      );
      $wpdb->query(
        $wpdb->prepare( "DELETE FROM {$wpdb->prefix}permutas_pessoas WHERE id = %d", $item )
      );
    }
  }

  public function render(){
    global $wpdb;
    $pesquisa = array_key_exists('s',$_GET) ? $_GET['s']: null;
    $pesquisa_orgao = array_key_exists('pesquisa_orgao',$_GET) ? $_GET['pesquisa_orgao']: null;
    $action = array_key_exists('action',$_GET) ? $_GET['action']: null;

    if(isset($action) && $action == 'delete') {
      $this->deleteCadastro($_GET['cadastro']);
    }


    $lista = $this->getCadasroList($pesquisa, $pesquisa_orgao);
    $orgaos_items = "<option value=''>Todos os orgão</option>";
    $orgaosList = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}permutas_orgaos", OBJECT );
    foreach( $orgaosList as $orgao) {
      $orgaos_items .= "<option value='$orgao->id'>$orgao->nome</option>";
    }
    $listaView = '';
    foreach($lista as $data) {
      $listaView .= $this->renderLine($data);
    }


    echo <<<EOF

    <div class="wrap">
      <h1>Banco de permuta</h1>
      <h3>Lista de pessoas cadastradas</h3>

      <form method="get">
        <input type="hidden" name="page" value="banco_permutas_lista">
  	  	<p class="search-box">
	        <label class="screen-reader-text" for="user-search-input">Search Users:</label>
	        <input type="search" id="user-search-input" name="s" value="$pesquisa">
          <input type="submit" id="search-submit" class="button" value="Pesquisar">
        </p>
        <div class="tablenav top">
        	<div class="alignleft actions bulkactions">
            <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
            <select name="action" id="bulk-action-selector-top">
              <option value="-1">Ações</option>
	            <option value="delete">Apagar</option>
            </select>
            <input type="submit" id="doaction" class="button action" value="Aplica">
		      </div>
		  		<div class="alignleft actions">
		  		  <label class="screen-reader-text" for="pesquisa_orgao">Todos os orgãos</label>
		        <select name="pesquisa_orgao" id="pesquisa_orgao" value="$pesquisa_orgao">
		  	      <option value="">Todos os orgãos</option>
              $orgaos_items
            </select>
            <input type="submit" class="button" value="aplicar">
          </div>
		      <br class="clear">
	      </div>
        <h2 class="screen-reader-text">Users list</h2>
        <table class="wp-list-table widefat fixed striped users">
	        <thead>
	          <tr>
              <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                <input id="cb-select-all-1" type="checkbox">
              </td>
              <th scope="col" id="nome" class="manage-column column-primary sortable desc">Nome</th>
              <th scope="col" id="name" class="manage-column ">Orgão</th>
              <th scope="col" id="email" class="manage-column">E-mail</th>
              <th scope="col" id="telefone" class="manage-column">Telefone</th>
              <th scope="col" id="cargo" class="manage-column">Cargo</th>
              <th scope="col" id="municipio" class="manage-column">Município</th>
            </tr>
	        </thead>
          <tbody id="the-list" data-wp-lists="list:user">
            $listaView
          </tbody>
          <tfoot>
	          <tr>
              <td class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                <input id="cb-select-all-2" type="checkbox">
              </td>
              <th scope="col" id="nome" class="manage-column column-primary sortable desc">Nome</th>
              <th scope="col" id="name" class="manage-column ">Orgão</th>
              <th scope="col" id="email" class="manage-column">E-mail</th>
              <th scope="col" id="telefone" class="manage-column">Telefone</th>
              <th scope="col" id="cargo" class="manage-column">Cargo</th>
              <th scope="col" id="municipio" class="manage-column">Município</th>
            </tr>
	        </tfoot>
        </table>

		  </form>
    </div>
EOF;
  }
  private function renderLine($data) {

    $line = <<<EOF
    <tr id="user-$data->id">
    <th scope="row" class="check-column">
      <label class="screen-reader-text" for="user_1">Select administrator</label>
      <input type="checkbox" name="cadastro[]" id="user_$data->id" class="administrator" value="$data->id">
    </th>
    <td class="username column-username has-row-actions column-primary" data-colname="nome">
      $data->nome
      <br>
      <div class="row-actions">
        <span class="view">
          <a href="/wp-admin/admin.php?page=banco_permutas_info&id=$data->id" aria-label="View posts by administrator">Visializar</a>
        </span>
      </div>
      <button type="button" class="toggle-row">
        <span class="screen-reader-text">Show more details</span>
      </button>
    </td>
    <td class="name column-name" data-colname="Name">
      $data->orgao
    </td>
    <td class="email column-email" data-colname="Email">
    $data->email
    </td>
    <td class="role column-role" data-colname="Role">$data->telefone</td>
    <td class="posts column-posts num" data-colname="Posts">$data->cargo </td>
    <td class="role column-role" data-colname="Role">$data->municipio</td>
  </tr>
EOF;
    return $line;
  }

}
