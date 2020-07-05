<?php
global $permutas_db_version;
$permutas_db_version = '1.0.0';

class Urcx_Permutas_Database {
  public function __construct() {

  }


  public function validateVersion() {
    global $permutas_db_version;
    $version = get_option('permutas_db_version');
    return $version == $permutas_db_version;
  }

  public function createDatabase() {
    global $wpdb;
    if($this->validateVersion()) return;

    $tblPessoas = $wpdb->prefix . "permutas_pessoas";
    $tblOrgaos = $wpdb->prefix . "permutas_orgaos";
    $tblIrPara = $wpdb->prefix . "permutas_ir_para";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "
      CREATE TABLE $tblOrgaos (
        id int(9) NOT NULL AUTO_INCREMENT,
        nome varchar(50) not null,
        PRIMARY KEY (id)
      ) $charset_collate;

      CREATE TABLE $tblPessoas (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nome varchar(200) NOT NULL,
        email varchar(250) NOT NULL,
        telefone varchar(14),
        rg_matricula varchar(30),
        cpf varchar(11),
        id_funcional varchar(20),
        id_orgao int(9) NOT NULL,
        cargo varchar(50) NOT NULL,
        lotacao_unidade varchar(100) NOT NULL,
        municipio varchar(60) NOT NULL,
        PRIMARY KEY (id)
      ) $charset_collate;

      CREATE TABLE $tblIrPara (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_pessoa mediumint(9) NOT NULL,
        lotacao varchar(100) NOT NULL,
        unidade varchar(100) NOT NULL,
        municipio varchar(100) NOT NULL,
        regiao varchar(100) NOT NULL,
        PRIMARY KEY (id)
      ) $charset_collate;
    ";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    add_option('permutas_db_version', '1.0.0');
    // TODO: Criar uma tela cadastro de Orgãos
    $this->install_data();
  }

  public function removeDatabase() {
    global $wpdb;
    $tblPessoas = $wpdb->prefix . "permutas_pessoas";
    $tblOrgaos = $wpdb->prefix . "permutas_orgaos";
    $tblIrPara = $wpdb->prefix . "permutas_ir_para";
    $sql = "
    DROP TABLE $tblOrgaos ;
    DROP TABLE $tblPessoas ;
    DROP TABLE $tblIrPara ;
  ";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
  delete_option('permutas_db_version');
  }
  public function install_data() {
    global $wpdb;
    $table_name = $wpdb->prefix . "permutas_orgaos";

    $wpdb->insert( $table_name, array( 'nome' => 'PMERJ' ));
    $wpdb->insert( $table_name, array( 'nome' => 'CBMERJ' ));
    $wpdb->insert( $table_name, array( 'nome' => 'POLICIA PENITENCIARIA' ));
    $wpdb->insert( $table_name, array( 'nome' => 'POLICIA CIVIL' ));
    $wpdb->insert( $table_name, array( 'nome' => 'DEGASE' ));
  }
}
