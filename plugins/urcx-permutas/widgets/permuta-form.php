<?PHP

class Urcx_Permutas_Form extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
    $widget_ops = array(
			'classname' => 'urcx_permutas_form',
			'description' => 'Formulario de permutas do site.',
		);
		parent::__construct( 'urcx_permutas_form', 'Formulario de permutas', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
    global $wpdb;
    $orgaos_items = "<option>Selecione</option>";
    extract($args);

    $orgaosList = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}permutas_orgaos", OBJECT );
    foreach( $orgaosList as $orgao) {
      $orgaos_items .= "<option value='$orgao->id'>$orgao->nome</option>";
    }

    if(isset($_POST['form_permutas'])) {
      $this->saveForm($_POST);
      print_r($_POST);
    }

    echo $before_widget;
    echo <<<EOF
    <div class="urcx-permutas-form">
      <form name="urcx-permutas" method="POST">
        <input type="hidden" name="form_permutas" value="true">
        <fieldset>
          <legend>Cadastro</legend>
          <div class="field">
            <label for="nome">Nome*</label>
            <input type="text" name="nome" id="nome" required="true"/>
          </div>
          <div class="field">
            <label for="email">E-mail*</label>
            <input type="email" name="email" id="email" required="true"/>
          </div>
          <div class="field">
            <label for="telefone">Telefone*</label>
            <input type="number" name="telefone" id="telefone" required="true"/>
          </div>
          <div class="field">
            <label for="cpf">CPF</label>
            <input type="number" name="cpf" id="cpf"/>
          </div>
          <div class="field">
            <label for="id_funcional">ID funcional</label>
            <input type="text" name="id_funcional" id="id_funcional"/>
          </div>
          <div class="field">
            <label for="id_orgaos">Qual o Orgão que pertence?* </label>
            <select name="id_orgaos" id="id_orgaos" style="width:100%"  required="true">
              $orgaos_items
            </select>
          </div>
          <div class="field">
            <label for="cargo">Cargo / Patente </label>
            <input type="text" name="cargo" id="cargo"/>
          </div>
          <div class="field">
            <label for="lotacao_unidade">Lotação / Unidade </label>
            <input type="text" name="lotacao_unidade" id="lotacao_unidade"/>
          </div>
          <div class="field">
            <label for="municipio"> Município</label>
            <input type="text" name="municipio" id="municipio"/>
          </div>
        </fieldset>
        <fieldset>
          <legend>Pra qual unidade ou região que gostaria de ser designado?</legend>
          <div class="field">
            <label for="lotacao1">Lotação* </label>
            <input type="text" name="lotacao1" id="lotacao1" required="true"/>
          </div>
          <div class="field">
            <label for="unidade1">Unidade* </label>
            <input type="text" name="unidade1" id="unidade1" required="true"/>
          </div>
          <div class="field">
            <label for="municipio1">Município* </label>
            <input type="text" name="municipio1" id="municipio1" required="true"/>
          </div>
          <div class="field">
            <label for="regiao1">Região*</label>
            <input type="text" name="regiao1" id="regiao1" required="true"/>
          </div>
          <h3> OU </h3>
          <div class="field">
            <label for="lotacao2">Lotação </label>
            <input type="text" name="lotacao2" id="lotacao2"/>
          </div>
          <div class="field">
            <label for="unidade2">Unidade </label>
            <input type="text" name="unidade2" id="unidade2"/>
          </div>
          <div class="field">
            <label for="municipio2">Município </label>
            <input type="text" name="municipio2" id="municipio2"/>
          </div>
          <div class="field">
            <label for="regiao2">Região</label>
            <input type="text" name="regiao2" id="regiao2"/>
          </div>
        </fieldset>
        <input type="submit" value="Enviar"/>
      </form>
    </div>
EOF;
    echo $after_widget;

	}
  public function saveForm($post) {
    global $wpdb;
    $wpdb->insert(
      "{$wpdb->prefix}permutas_pessoas",
      array(
        'nome' => $post['nome'],
        'email' => $post['email'],
        'telefone' => $post['telefone'],
        'cpf' => $post['cpf'],
        'id_funcional' => $post['id_funcional'],
        'id_orgao' => $post['id_orgaos'],
        'cargo' => $post['cargo'],
        'lotacao_unidade' => $post['lotacao_unidade'],
        'municipio' => $post['municipio']
      )
    );
    $id = $wpdb->insert_id;
    $wpdb->insert(
      "{$wpdb->prefix}permutas_ir_para",
      array(
        'id_pessoa' => $id,
        'lotacao' => $post['lotacao1'],
        'unidade' => $post['unidade1'],
        'municipio' => $post['municipio1'],
        'regiao' => $post['regiao1'],
        )
    );

    if(isset($post['lotacao2']) && $post['lotacao2'] != ''){
      $wpdb->insert(
        "{$wpdb->prefix}permutas_ir_para",
        array(
          'id_pessoa' => $id,
          'lotacao' => $post['lotacao2'],
          'unidade' => $post['unidade2'],
          'municipio' => $post['municipio2'],
          'regiao' => $post['regiao2'],
          )
      );
    }
  }
	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
	}
}
