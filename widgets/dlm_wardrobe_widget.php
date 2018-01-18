<?php
class dlm_wardrobe_widget extends dlm_widgets {

    // Main constructor
    public function __construct() {
        parent::__construct('dlm_wardrobe_widget', 'DLM Wardrobe Widget', [
            'customize_selective_refresh' => true,
        ]);
    }

    // The widget form (for the backend )
    public function form( $instance ) {
        if(!$this->checkCredentials()) {
            echo 'Please update the settings of your DressLikeMe Plugin.';
        } else {
            $defaults = [
                'title' => '',
                'limit' => '24',
            ];

            extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'text_domain' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'text_domain' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
            </p>

        <?php }}

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
            $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
            $instance['limit']    = isset( $new_instance['limit'] ) ? wp_strip_all_tags( $new_instance['limit'] ) : '';
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {
        extract($args);

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $limit = isset( $instance['limit'] ) ? $instance['limit'] : '';

        echo $before_widget;

        echo '<div class="widget-text wp_widget_plugin_box">';

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        if ( $limit ) {
            echo '<script class="widget-'. get_option('dlm-name') .'" src="https://dresslikeme.com/'. get_option('dlm-name') .'/widget/wardrobe.js?limit='. $limit .'" async></script>';
        }

        echo '</div>';

        echo $after_widget;
    }

}