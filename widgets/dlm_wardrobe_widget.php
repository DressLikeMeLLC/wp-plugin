<?php
class dlm_wardrobe_widget extends WP_Widget {

    // Main constructor
    public function __construct() {
        parent::__construct(
                'dlm_wardrobe_widget',
                __('DLM Wardrobe Widget', 'text_domain'),
                [
                        'customize_selective_refresh' => true,
                ]
        );
    }

    // The widget form (for the backend )
    public function form( $instance ) {
        $defaults = [
            'limit' => '24',
        ];

    extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
        </p>

    <?php }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['limit']    = isset( $new_instance['limit'] ) ? wp_strip_all_tags( $new_instance['limit'] ) : '';
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {
        extract($args);

        $limit     = isset( $instance['limit'] ) ? $instance['limit'] : '';

        echo $before_widget;

        echo '<div class="widget-text wp_widget_plugin_box">';

        if ( $limit ) {
            echo '[wardrobe limit=' . $limit . ']';
        }

        echo '</div>';

        echo $after_widget;
    }

}