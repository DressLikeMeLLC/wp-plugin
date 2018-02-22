<?php if(isset($name)): ?>
    <script class="profileentrieswidget-<?php echo $name?>" src="<?php echo DLM_URL ?>/<?php echo $name?>/widget/entries-<?php echo $limit; ?>.js" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>