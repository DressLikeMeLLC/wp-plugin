<div class="wrap">

<h2>DLM Settings</h2>

<form name="dlm-settings-form" method="post" action="">
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
