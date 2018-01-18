<?php
class dlm_widgets extends WP_Widget
{
    protected function checkCredentials()
    {
        if (!$json = wp_remote_get('https://dresslikeme.com/api/v1/'. get_option('dlm-name') .'/'. get_option('dlm-api-key') .'/check')) {
            return false;
        }

        return true;
    }
}