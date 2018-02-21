<?php if(isset($name)): ?>
    <script class="widget-<?php echo $name?>" src="<?php echo DLM_URL ?>/<?php echo $name?>/widget/wardrobe.js?limit=<?php echo intval($limit) ?>?color=<?php echo $color ?><?php if($hidePrices):?>?hidePrices=1<?php endif;?>" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>
