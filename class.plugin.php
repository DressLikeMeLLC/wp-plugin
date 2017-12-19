<?php
class DressLikeMe extends TlView {

    public function __construct() {
        $this->setViewPath(DLM_CALCULATOR_PATH . 'views/');
        $this->init();
    }

    private function init()
    {
        add_action('after_setup_theme', array($this, 'afterSetupTheme'));
    }

    public function afterSetupTheme() {
        add_action('wp_enqueue_scripts', array($this, 'enqueueStatic'));
        add_action('wp_ajax_dlm_json_action', array($this, 'getOutfitsFromApi'));
        add_action('wp_ajax_dlm_product_json_action', array($this, 'getProductsFromApi'));
        add_action('admin_menu', array($this, 'initSettingsPage'));

        add_filter('mce_external_plugins', array($this, 'enqueuePluginScripts'));
        add_filter('mce_buttons', array($this, 'registerButtonsEditor'));
        add_filter('admin_enqueue_scripts', array($this, 'buttonCss'));

        add_shortcode('outfit', array($this, 'outputOutfit'));
        add_shortcode('wardrobe', array($this, 'outputWardrobe'));
        add_shortcode('product', array($this, 'outputProduct'));
    }

    public function outputOutfit($attr) {
        return $this->view('script-outfit', array(
            'sid' => trim($attr['id'])
        ), true);
    }

    public function outputWardrobe($attr) {
        return $this->view('script-wardrobe', array(
            'limit' => (!empty($attr['limit'])?intval($attr['limit']):0),
            'name' => get_option('dlm-name')
        ), true);
    }

    public function outputProduct($attr) {
        return $this->view('script-product', array(
            'id' => trim($attr['id']),
            'name' => get_option('dlm-name')
        ), true);
    }

    public function enqueuePluginScripts($plugin_array) {
        $plugin_array['dlm_outfit'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_wardrobe'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_product'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        return $plugin_array;
    }

    public function enqueueStatic() {
        wp_enqueue_script('jquery');
    }

    public function registerButtonsEditor($buttons)
    {
        array_push($buttons, 'dlm_outfit_button');
        array_push($buttons, 'dlm_wardrobe_button');
        array_push($buttons, 'dlm_product_button');
        return $buttons;
    }

    public function buttonCss() {
        wp_enqueue_style('dresslikeme-button', DLM_CALCULATOR_URL.'css/tinymce.css');
    }

    public function getOutfitsFromApi()
    {
        $response = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/entries');
        if (!is_array( $response ) || empty($response['body'])) {
            exit(json_encode([]));
        }

        exit($response['body']);
    }

    public function getProductsFromApi()
    {
        if(!$search = sanitize_text_field($_POST['search'])) {
            exit(json_encode([]));
        }
        $response = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/products/' .$this->getWpCountry(). '?q=' .urlencode($search));
        if (!is_array( $response ) || empty($response['body'])) {
            exit(json_encode([]));
        }

        exit($response['body']);
    }

    public function initSettingsPage() {
        add_menu_page( 'DressLikeMe Settings', 'DLM', 'manage_options', 'dlm', array($this, 'getSettingsPage'), 'https://dresslikeme.com/img/logo.svg', null );
    }

    public function getSettingsPage() {
        if (!current_user_can('manage_options'))
        {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }

        echo '<div class="wrap">';

        echo "<h2>" . __('DressLikeMe Plugin Settings', 'menu-test') . "</h2>";

        ?>  <form name="dlm-settings-form" method="post" action="">
            <input type="hidden" name="mt_submit_hidden" value="Y">
            <?php

            $options = ['name', 'api-key'];
            foreach($options as $opt_name) {

                $data_field_name = $opt_name . 'mt_val';

                $opt_val = get_option('dlm-'.$opt_name);

                if (isset($_POST['mt_submit_hidden']) && $_POST['mt_submit_hidden'] == 'Y') {
                    $opt_val = $_POST[$data_field_name];

                    update_option('dlm-'.$opt_name, $opt_val);
                }

                ?>

                <p>
                    <label>
                        <?php
                        if($opt_name == 'api-key') {
                            echo 'Access key';
                        }
                        if($opt_name == 'name') {
                            echo 'Username';
                        }
                        ?>
                    </label>
                </p>
                <p>
                    <input type="text" name="<?php echo $data_field_name; ?>" style="width: 70%; height: 40px" value="<?php echo $opt_val; ?>">
                </p>

                <?php
            }
            ?>

            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>"/>
            </p>
        </form>
        <hr>
        <h3>
            Get your access codes here:<br>
            <a href="https://dresslikeme.com/member/profile/credentials">Link</a>
        </h3>

        </div>

        <?php
    }

    private function getWpCountry() {
        if (!$locales = get_user_locale() ) {
            return 'us';
        }

        $localesA = explode( '_', $locales );
        return strtolower( $localesA[ ( count( $localesA ) - 1 ) ] );
    }
}