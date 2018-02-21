<?php
class DressLikeMe extends TlView {

    public function __construct() {
        $this->setViewPath(DLM_CALCULATOR_PATH . 'views/');
        $this->init();
        $this->initTranslations();
    }

    private function init()
    {
        add_action('init', array($this, 'initTranslations'));
        add_action('after_setup_theme', array($this, 'afterSetupTheme'));
    }

    public function afterSetupTheme() {
        $this->saveSettingsPage();
        add_action('admin_menu', array($this, 'initSettingsPage'));

        add_action('wp_enqueue_scripts', array($this, 'enqueueStatic'));
        add_action('wp_ajax_dlm_check_api_action', array($this, 'checkApiSettings'));
        add_action('wp_ajax_dlm_json_action', array($this, 'getOutfitsFromApi'));
        add_action('wp_ajax_dlm_product_json_action', array($this, 'getProductsFromApi'));

        add_action('widgets_init', array($this, 'initWidgets'));

        add_action('admin_head', array($this, 'adminHead'));

        add_filter('mce_external_plugins', array($this, 'enqueuePluginScripts'));
        add_filter('mce_buttons', array($this, 'registerButtonsEditor'));
        add_filter('admin_enqueue_scripts', array($this, 'buttonCss'));

        add_shortcode('outfit', array($this, 'outputOutfit'));
        add_shortcode('wardrobe', array($this, 'outputWardrobe'));
        add_shortcode('product', array($this, 'outputProduct'));
        add_shortcode('profile', array($this, 'outputProfile'));
        add_shortcode('outfits', array($this, 'outputOutfits'));
    }

    public function initTranslations() {
        load_plugin_textdomain( DLM_TD, false, 'dresslikeme/languages' );
    }

    public function initWidgets() {
        register_widget( 'dlm_wardrobe_widget' );
        register_widget( 'dlm_profile_widget' );
        register_widget( 'dlm_outfit_widget' );
        register_widget( 'dlm_outfits_widget' );
    }

    public function adminHead() {
        $this->view('admin-head');
    }

    public function outputOutfit($attr) {
        return $this->view('script-outfit', array(
            'sid' => trim($attr['id']),
            'style' => trim($attr['style']),
            'color' => get_option('dlm-color'),
            'hidePrices' => get_option('dlm-hide-prices')
        ), true);
    }

    public function outputOutfits($attr) {
        return $this->view('script-outfits', array(
            'limit' => (!empty($attr['limit'])?intval($attr['limit']):0),
            'name' => get_option('dlm-name'),
            'color' => get_option('dlm-color'),
            'hidePrices' => get_option('dlm-hide-prices')
        ), true);
    }

    public function outputWardrobe($attr) {
        return $this->view('script-wardrobe', array(
            'limit' => (!empty($attr['limit'])?intval($attr['limit']):0),
            'name' => get_option('dlm-name'),
            'color' => get_option('dlm-color'),
            'hidePrices' => get_option('dlm-hide-prices')
        ), true);
    }

    public function outputProfile() {
        return $this->view('script-profile', array(
            'name' => get_option('dlm-name'),
            'color' => get_option('dlm-color'),
            'hidePrices' => get_option('dlm-hide-prices')
        ), true);
    }

    public function outputProduct($attr) {
        return $this->view('script-product', array(
            'id' => trim($attr['id']),
            'name' => get_option('dlm-name'),
            'color' => get_option('dlm-color'),
            'hidePrices' => get_option('dlm-hide-prices')
        ), true);
    }

    public function enqueuePluginScripts($plugin_array) {
        $plugin_array['dlm_outfit'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_wardrobe'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_product'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_outfits'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_profile'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
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
        array_push($buttons, 'dlm_outfits_button');
        array_push($buttons, 'dlm_profile_button');
        return $buttons;
    }

    public function buttonCss() {
        wp_enqueue_style('dresslikeme-button', DLM_CALCULATOR_URL.'css/tinymce.css');
    }

    public function checkApiSettings()
    {
        $response = wp_remote_get(DLM_URL .'/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/check');
        if (!is_array( $response ) || empty($response['body'])) {
            exit(null);
        }

        exit($response['body']);
    }

    public function getOutfitsFromApi()
    {
        $response = wp_remote_get(DLM_URL .'/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/entries');
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
        $response = wp_remote_get(DLM_URL .'/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/products/' .$this->getWpCountry(). '?q=' .urlencode($search));
        if (!is_array( $response ) || empty($response['body'])) {
            exit(json_encode([]));
        }

        exit($response['body']);
    }

    public function initSettingsPage() {
        add_menu_page( 'DressLikeMe Settings', 'DLM', 'manage_options', 'dlm', array($this, 'getSettingsPage'), DLM_CALCULATOR_URL. 'images/dlm-wp-logo.png', null );
    }

    public function getSettingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die( __('You do not have sufficient permissions to access this page.', DLM_TD) );
        }

        $this->view('settings');
    }

    private function saveSettingsPage()
    {
        if (!isset($_POST['dlm_submit_hidden']) || sanitize_text_field($_POST['dlm_submit_hidden']) !== 'Y') {
            return;
        }

        $name = sanitize_text_field($_POST['dlm-name']);
        $key = sanitize_text_field($_POST['dlm-api-key']);
        $color = sanitize_text_field($_POST['dlm-color']);
        if($_POST['dlm-hide-prices']) {
            $hidePrices = 1;
        } else {
            $hidePrices = 0;
        }

        if(!$response = wp_remote_get(DLM_URL .'/api/v1/'. $name .'/'. $key .'/check')) {
	        header('Location: '.admin_url('admin.php?page=dlm&saved=false'));
	        exit();
        }

        $arr = json_decode($response['body'], true);
        if (empty($arr) || !$arr['success']) {
            header('Location: '.admin_url('admin.php?page=dlm&saved=false'));
            exit();
        }

        update_option('dlm-name', $name);
        update_option('dlm-api-key', $key);
        update_option('dlm-color', $color);
        update_option('dlm-hideprices', $hidePrices);

        header('Location: '.admin_url('admin.php?page=dlm&saved=true'));
        exit();
    }

    private function getWpCountry() {
        if (!$locales = get_user_locale() ) {
            return 'us';
        }

        $localesA = explode( '_', $locales );
        return strtolower( $localesA[ ( count( $localesA ) - 1 ) ] );
    }
}