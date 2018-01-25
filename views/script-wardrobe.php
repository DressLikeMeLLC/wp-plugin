<?php if(isset($name)): ?>
    <script class="widget-<?php echo $name?>" src="<?php echo DLM_URL ?>/<?php echo $name?>/widget/wardrobe.js?limit=<?php echo intval($limit) ?>" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>
