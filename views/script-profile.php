<?php if($name): ?>
    <script class="profilewidget-<?php echo $name?>" src="<?php echo DLM_URL ?>/<?php echo $name?>/widget/profile.js"></script>
<?php else: ?>
    <pre>
        <?php echo __('Unfortunately, no username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>