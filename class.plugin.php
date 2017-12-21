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
        $this->saveSettingsPage();
        add_action('admin_menu', array($this, 'initSettingsPage'));

        add_action('wp_enqueue_scripts', array($this, 'enqueueStatic'));
        add_action('wp_ajax_dlm_check_api_action', array($this, 'checkApiSettings'));
        add_action('wp_ajax_dlm_json_action', array($this, 'getOutfitsFromApi'));
        add_action('wp_ajax_dlm_product_json_action', array($this, 'getProductsFromApi'));

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

    public function checkApiSettings()
    {
        $response = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/check');
        if (!is_array( $response ) || empty($response['body'])) {
            exit(null);
        }

        exit($response['body']);
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
        add_menu_page( 'DressLikeMe Settings', 'DLM', 'manage_options', 'dlm', array($this, 'getSettingsPage'), DLM_CALCULATOR_URL. 'images/dlm-wp-logo.png', null );
    }

    public function getSettingsPage() {
        if (!current_user_can('manage_options')) {
            wp_die( __('You do not have sufficient permissions to access this page.') );
        }

        $this->view('settings');
    }

    private function saveSettingsPage()
    {
        if (!isset($_POST['dlm_submit_hidden']) || $_POST['dlm_submit_hidden'] !== 'Y') {
            return;
        }

        update_option('dlm-name', $_POST['dlm-name']);
        update_option('dlm-api-key', $_POST['dlm-api-key']);

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