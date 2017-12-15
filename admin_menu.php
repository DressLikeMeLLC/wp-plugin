<?php

add_action('admin_menu', 'dlm_menu');

function dlm_menu() {
    add_menu_page( 'Dlm-Options', 'DressLikeMe', 'manage_options', 'dlm', 'dlm_toplevel_page', 'https://dresslikeme.com/img/logo.svg', null );
}

function dlm_toplevel_page() {
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

        <p><?php echo ucfirst($opt_name) ?>:
            <input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
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
    </h3>
    <h3>
        <a href="https://dresslikeme.com/member/profile/credentials">Link</a>
    </h3>

    </div>

    <?php
}


