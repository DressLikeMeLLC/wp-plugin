<div class="wrap">
    <h2><?php _e('DLM Settings', DLM_TD) ?></h2>

    <?php if(!empty($_GET['saved'])):
        if($_GET['saved'] == 'true'): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php _e('Thank you very much! Your changes have been saved successfully!', DLM_TD) ?></p>
            </div>
        <?php endif;

        if($_GET['saved'] == 'false'): ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e('Unfortunately, the entered login data are not correct!', DLM_TD) ?></p>
            </div>
        <?php endif;
    endif; ?>

    <h3><?php _e('1.) Get your access data', DLM_TD) ?></h3>
    <p>
        <?php _e('Click on the following button to be redirected to your DressLikeMe profile.
        You will receive your access data there, which you can copy and enter below.', DLM_TD) ?>
    </p>
    <a href="<?php echo DLM_URL ?>/member/profile/credentials" target="_blank" class="button-primary"><?php _e('Open access settings', DLM_TD) ?></a>

    <br /><br />

    <h3><?php _e('2.) Enter your access data', DLM_TD) ?></h3>
    <form name="dlm-settings-form" method="post" action="">
        <input type="hidden" name="dlm_submit_hidden" value="Y">

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="dlm-name"><?php _e('Username:', DLM_TD) ?></label>
                </th>
                <td>
                    <input name="dlm-name" required type="text" id="dlm-name" value="<?php echo get_option('dlm-name'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dlm-api-key"><?php _e('Access Key:', DLM_TD) ?></label>
                </th>
                <td>
                    <input name="dlm-api-key" required type="text" id="dlm-api-key" value="<?php echo get_option('dlm-api-key'); ?>" class="regular-text">
                </td>
            </tr>
            </tbody>
        </table>

        <?php if(!empty(get_option('dlm-name'))):
            if(!empty(get_option('dlm-api-key'))): ?>
                <h3><?php _e('3.) Customize the look', DLM_TD) ?></h3>
                <input type="hidden" name="dlm_submit_custom_hidden" value="Y">

                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label for="dlm-color"><?php _e('Color:', DLM_TD) ?></label>
                        </th>
                        <td>
                            <input name="dlm-color" required type="color" id="dlm-color" value="<?php if(get_option('dlm-color')) {
                                echo get_option('dlm-color');
                            } else {
                                echo '#FF7765';
                            }  ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="dlm-hide-prices"><?php _e('Hide Prices:', DLM_TD) ?></label>
                        </th>
                        <td>
                            <input name="dlm-hide-prices" type="checkbox" id="dlm-hide-prices" value="dlm-hide-prices" class="regular-checkbox" <?php if(get_option('dlm-hideprices') == 1) {
                                echo 'checked';
                            } ?>>
                        </td>
                    </tr>
                    </tbody>
                </table>
            <?php endif;
        endif; ?>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Changes', DLM_TD) ?>"/>
        </p>
    </form>
</div>
