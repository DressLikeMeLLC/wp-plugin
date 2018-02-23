<?php
/*
Plugin Name: DressLikeMe
Plugin URI: https://dresslikeme.com
Description: Get inspired by the worldwide most popular fashion trends and publish your favourite outfit.
Author: DressLikeMe LLC
Version: 1.2
Text Domain: dresslikeme
Domain Path: /languages
*/

define('DLM_CALCULATOR_PATH', plugin_dir_path(__FILE__) );
define('DLM_CALCULATOR_URL', trailingslashit( plugin_dir_url( __FILE__ ) ));
define('DLM_TD', 'dresslikeme');
define('DLM_URL', 'https://dresslikeme.com');

require_once(DLM_CALCULATOR_PATH.'widgets/dlm_widgets.php');
require_once(DLM_CALCULATOR_PATH.'widgets/dlm_wardrobe_widget.php');
require_once(DLM_CALCULATOR_PATH.'widgets/dlm_profile_widget.php');
require_once(DLM_CALCULATOR_PATH.'widgets/dlm_outfit_widget.php');
require_once(DLM_CALCULATOR_PATH.'widgets/dlm_outfits_widget.php');

require_once(DLM_CALCULATOR_PATH.'class.tl-view.php');
require_once(DLM_CALCULATOR_PATH.'class.plugin.php');

new DressLikeMe();