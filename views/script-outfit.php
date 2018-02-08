<?php if(isset($sid) && isset($style)): ?>
    <script class="widget-<?php echo $sid; ?>" src="<?php echo DLM_URL ?>/e/<?php echo $sid ?>/widget.js?style=<?php echo $style ?>" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no ID was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>