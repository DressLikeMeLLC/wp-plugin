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

        add_filter('mce_external_plugins', array($this, 'enqueuePluginScripts'));
        add_filter('mce_buttons', array($this, 'registerButtonsEditor'));
        add_filter('admin_enqueue_scripts', array($this, 'buttonCss'));

        add_shortcode('outfit', array($this, 'outputOutfit'));
        add_shortcode('wardrobe', array($this, 'outputWardrobe'));
    }

    public function outputOutfit($attr) {
        return $this->view('outfit', array(
            'sid' => trim($attr['id'])
        ), true);
    }

    public function outputWardrobe($attr) {
        return $this->view('wardrobe', array(
            'limit' => (!empty($attr['limit'])?intval($attr['limit']):0),
            'name' => get_option('dlm-name')
        ), true);
    }

    public function enqueuePluginScripts($plugin_array) {
        $plugin_array['dlm_outfit'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        $plugin_array['dlm_wardrobe'] =  DLM_CALCULATOR_URL.'js/tinymce.js';
        return $plugin_array;
    }

    public function enqueueStatic() {
        wp_enqueue_script('jquery');
    }

    public function registerButtonsEditor($buttons)
    {
        array_push($buttons, 'dlm_outfit_button');
        array_push($buttons, 'dlm_wardrobe_button');
        return $buttons;
    }

    public function buttonCss() {
        wp_enqueue_style('dresslikeme-button', DLM_CALCULATOR_URL.'css/tinymce.css');
    }

    public function getOutfitsFromApi()
    {
        $response = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/entries');
        if (!is_array( $response ) || empty($response['body'])) {
            return json_encode([]);
        }

        exit($response['body']);
    }
}