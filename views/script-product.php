<?php if(isset($id) && isset($name)): ?>
    <script class="widget-<?php echo md5($id); ?>" src="<?php echo DLM_URL; ?>/p/<?php echo $id; ?>/<?php echo $name; ?>/widget.js" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no ID or username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>