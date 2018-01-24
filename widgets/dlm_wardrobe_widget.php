<?php
class dlm_wardrobe_widget extends dlm_widgets {

    // Main constructor
    public function __construct() {
        parent::__construct('dlm_wardrobe_widget', __('DLM Wardrobe', DLM_TD),
            [
                'description' => __( 'Displays your DressLikeMe wardrobe.', DLM_TD )
            ],
            [
                'customize_selective_refresh' => true,
            ]);
    }

    // The widget form (for the backend )
    public function form( $instance ) {
        if(!$this->checkCredentials()) {
            return true;
        }

        $defaults = [
            'title' => '',
            'limit' => '24',
        ];

        extract( wp_parse_args( ( array ) $instance, $defaults ) );
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', DLM_TD ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', DLM_TD ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
        </p>

        <?php
    }

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
        $limit = intval(isset( $instance['limit'] ) ? $instance['limit'] : 0);
        ?>

        <?= $before_widget; ?>

        <div class="widget-text wp_widget_plugin_box">

            <?php if($title): ?>
                <?= $before_title; ?>
                <a href="https://dresslikeme.com/<?= get_option('dlm-name'); ?>" target="_blank">
                    <?= $title; ?>
                </a>
                <?= $after_title; ?>

                <?= do_shortcode('[wardrobe limit='.$limit.']'); ?>
            <?php else: ?>
                <a href="https://dresslikeme.com/<?= get_option('dlm-name'); ?>" target="_blank">
                    <?= do_shortcode('[wardrobe limit='.$limit.']'); ?>
                </a>
            <?php endif; ?>
            
        </div>

        <?= $after_widget; ?>

        <?php
    }

}