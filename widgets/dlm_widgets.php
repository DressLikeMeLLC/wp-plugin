<?php
class dlm_widgets extends WP_Widget
{
    protected function checkCredentials()
    {
        $success = true;

        if (!$response = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/check')) {
            $success = false;
        } elseif (!is_array( $response ) || empty($response['body'])) {
            $success = false;
        }

        $json = json_decode($response['body'], true);
        if(!$json['success']) {
            $success = false;
        }

        if($success) {
            return true;
        }

        ?>
        <p>Please update the settings of your DressLikeMe Plugin.</p>
        <p>
            <a href="/wp-admin/admin.php?page=dlm" target="_blank" class="button-primary">Your Settings</a>
        </p>
        <?php

        return false;
    }
}