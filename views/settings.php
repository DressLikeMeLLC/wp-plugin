<div class="wrap">
    <h2>DLM Settings</h2>

    <?php if(!empty($_GET['saved'])): ?>
        <div class="notice notice-success is-dismissible">
            <p>Thank you very much! Your changes have been saved successfully!</p>
        </div>
    <?php endif; ?>

    <h3>1.) Get your access data</h3>
    <p>
        Click on the following button to be redirected to your DressLikeMe profile.
        You will receive your access data there, which you can copy and enter below.
    </p>
    <a href="https://dresslikeme.com/member/profile/credentials" target="_blank" class="button-primary">To the access data</a>

    <br /><br />

    <h3>2.) Enter your access data</h3>
    <form name="dlm-settings-form" method="post" action="">
        <input type="hidden" name="dlm_submit_hidden" value="Y">

        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label for="dlm-name">Username:</label>
                </th>
                <td>
                    <input name="dlm-name" required type="text" id="dlm-name" value="<?php echo get_option('dlm-name'); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dlm-api-key">Access Key:</label>
                </th>
                <td>
                    <input name="dlm-api-key" required type="text" id="dlm-api-key" value="<?php echo get_option('dlm-api-key'); ?>" class="regular-text">
                </td>
            </tr>
            </tbody>
        </table>

        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Changes"/>
        </p>
    </form>


</div>
