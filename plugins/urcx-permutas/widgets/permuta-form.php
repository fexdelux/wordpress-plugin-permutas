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
    extract($args);
    echo $before_widget;
    echo <<<EOF
    <div class="urcx-permutas-form">
      <form name="urcx-permutas">
        <div class="field">
          <label for=""> </label>
          <input type="text" name="" id=""/>
        </div>
      </form>
    </div>
EOF;
    echo $after_widget;

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
