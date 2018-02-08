<?php
class dlm_outfit_widget extends dlm_widgets {

    // Main constructor
    public function __construct() {
        parent::__construct('dlm_outfit_widget', __('DLM Outfit Products', DLM_TD),
            [
                'description' => __( 'All products from one of your DressLikeMe outfits.', DLM_TD )
            ],
            [
                'customize_selective_refresh' => true,
            ]
        );
    }

    // The widget form (for the backend )
    public function form( $instance ) {
        if(!$this->checkCredentials()) {
            return true;
        }

        $defaults = [
            'title' => '',
            'sid' => '',
            'style' => 'horizontal',
        ];

        extract( wp_parse_args( ( array ) $instance, $defaults ) );
        ?>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', DLM_TD ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'sid' ) ); ?>"><?php _e( 'Outfit ID:', DLM_TD ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sid' ) ); ?>" type="text" value="<?php echo esc_attr( $sid ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php _e( 'Style:', DLM_TD ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
                <option value="horizontal" <?php selected( $instance['style'], 'horizontal'); ?>><?php _e('Horizontal', DLM_TD) ?></option>
                <option value="vertical" <?php selected( $instance['style'], 'vertical'); ?>><?php _e('Vertical', DLM_TD) ?></option>
            </select>
        </p>

        <?php
    }

    // Update widget settings
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
        $instance['sid']    = isset( $new_instance['sid'] ) ? wp_strip_all_tags( $new_instance['sid'] ) : '';
        $instance['style']    = isset( $new_instance['style'] ) ? wp_strip_all_tags( $new_instance['style'] ) : '';
        return $instance;
    }

    // Display the widget
    public function widget( $args, $instance ) {
        extract($args);

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $sid = isset( $instance['sid'] ) ? $instance['sid'] : '';
        $style = isset( $instance['style'] ) ? $instance['style'] : '';
        ?>

        <?= $before_widget; ?>

        <div class="widget-text wp_widget_plugin_box">

            <?php if($sid): ?>
                <?php if($title): ?>
                    <?= $before_title; ?>
                    <a href="<?php echo DLM_URL ?>/<?= get_option('dlm-name'); ?>/e/<?= $sid ?>" target="_blank">
                        <?= $title; ?>
                    </a>
                    <?= $after_title; ?>

                    <?= do_shortcode('[outfit id='.$sid.' style='.$style.']'); ?>
                <?php else: ?>
                    <a href="<?php echo DLM_URL ?>/<?= get_option('dlm-name'); ?>" target="_blank">
                        <?= do_shortcode('[outfit id='.$sid.' style='.$style.']'); ?>
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <?php if($title): ?>
                    <?= $before_title; ?>
                    <a href="<?php echo DLM_URL ?>/<?= get_option('dlm-name'); ?>" target="_blank">
                        <?= $title; ?>
                    </a>
                    <?= $after_title; ?>
                <?php endif; ?>
            <?php endif; ?>
            
        </div>

        <?= $after_widget; ?>

        <?php
    }

}