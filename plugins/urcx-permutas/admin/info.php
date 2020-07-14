<?php

require_once(dirname(__FILE__).'/../core/admin-page-view.php');

class Urcx_Permutas_Info implements iAdminPageView{

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
      'Banco de Permutas - Info',
      'Info',
      'manage_options',
      'banco_permutas_info',
      array($this, 'render'),
      4

    );
  }
  private function getCadastro($id) {
    global $wpdb;
    $qry = "
    SELECT
    p.id,
    p.nome,
    p.cargo,
    p.email,
    p.telefone,
    p.municipio,
    p.rg_matricula,
    p.cpf,
    p.id_funcional,
    p.lotacao_unidade,
    og.nome as orgao
    FROM
      {$wpdb->prefix}permutas_orgaos as og
      join {$wpdb->prefix}permutas_pessoas as p on p.id_orgao = og.id
      where p.id = $id
    ";
    $cadastro = $wpdb->get_row($qry);

    $qry = "
      SELECT
        lotacao,
        unidade,
        municipio,
        regiao
      FROM {$wpdb->prefix}permutas_ir_para
      WHERE id_pessoa = $id
    ";
    $lista = $wpdb->get_results($qry, OBJECT);

    $qry = "
      SELECT
        p.id,
        p.nome,
        p.cargo,
        p.email,
        p.telefone,
        p.municipio,
        p.lotacao_unidade,
        og.nome as orgao
      FROM
          {$wpdb->prefix}permutas_orgaos as og
          join {$wpdb->prefix}permutas_pessoas as p on p.id_orgao = og.id
          join {$wpdb->prefix}permutas_ir_para pip on pip.id_pessoa = p.id
          join {$wpdb->prefix}permutas_pessoas as pp on
                pp.municipio = pip.municipio
                and p.id_orgao = pp.id_orgao
                and  pp.id = $id
    ";

    $listaPermuta = $wpdb->get_results($qry, OBJECT);

    return array('cadastro' => $cadastro, 'ir' => $lista, 'permuta' => $listaPermuta);
  }
  public function render() {
    $id = array_key_exists('id',$_GET) ? $_GET['id']: null;
    if(!$id) {
      echo <<<EOF
      <div class="wrap">
      <h1>Banco de permuta</h1>
      <h3>Acesso a lista de pessoas e selecione uma cadastro!</h3>
      </div>
EOF;
      return;
    }
    extract($this->getCadastro($id));
    $opcoes = '';
    foreach($ir as $index => $item) {
      $index++;
      $opcoes .= "
      <h3>Para onde que ir Opção $index</h3>
      <table class=\"cadastro_info\">
        <tr>
          <td>Lotação</td>
          <td>$item->lotacao</td>
        </tr>
        <tr>
          <td>Unidade</td>
          <td>$item->unidade</td>
        </tr>
        <tr>
          <td>Região</td>
          <td>$item->regiao</td>
        </tr>
        <tr>
          <td>Município</td>
          <td>$item->municipio</td>
        </tr>
      </table>
      ";
    }
    $permutaView = "
    <h3>Pessoas para permuta</h3>
      <table class=\"cadastro_permuta\">
        <tr>
          <th>Nome</th>
          <th>cargo</th>
          <th>Municipio</th>
        </tr>
      ";

    foreach ($permuta as $key => $item) {
      $permutaView .= "
      <tr>
        <td><a href=\"/wp-admin/admin.php?page=banco_permutas_info&id=$item->id\">$item->nome</a></td>
        <td>$item->cargo</td>
        <td>$item->municipio</td>
      </tr>

      ";
    }
    $permutaView.= "</table>";


    echo <<<EOF

    <style>
      .cadastro_permuta {
        width: 100%;
        margin-left: 10px;
        margin-right: 10px;
      }

      .cadastro_permuta th{
        text-align : left;
      }

      .cadastro_permuta td{
        padding: 5px;
        background-color: #FFFFFF;
      }

      .cadastro_info {
        margin-top: 30px;
      }
      .cadastro_info  tr {
        padding: 5px;

      }
      .cadastro_info  tr > td {
        background-color: #FFFFFF;
        width: 300px;
        padding: 5px;

      }
      .cadastro_info  tr > td:first-child {
        font-weight: bold;
        background-color: transparent;
        width: 150px;
      }
    </style>
    <div class="wrap">
      <h1>Banco de permuta</h1>
      <h3>Informações do $cadastro->nome</h3>
      <table class="cadastro_info">
        <tr>
          <td>Cargo</td>
          <td>$cadastro->cargo</td>
        </tr>
        <tr>
          <td>Orgão</td>
          <td>$cadastro->orgao</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>$cadastro->email</td>
        </tr>
        <tr>
          <td>Telefone</td>
          <td>$cadastro->telefone</td>
        </tr>
        <tr>
          <td>CPF</td>
          <td>$cadastro->cpf</td>
        </tr>
        <tr>
          <td>RG/matícula</td>
          <td>$cadastro->rg_matricula</td>
        </tr>
        <tr>
          <td>ID Funcional</td>
          <td>$cadastro->id_funcional</td>
        </tr>
        <tr>
          <td>Lotação/Unidade</td>
          <td>$cadastro->lotacao_unidade</td>
        </tr>
        <tr>
          <td>Município</td>
          <td>$cadastro->municipio</td>
        </tr>
      </table>
      $opcoes
      $permutaView

    </div>
EOF;

  }
}
