<?php if(isset($name)): ?>
    <script class="profilewidget-<?php echo $name; ?>" src="<?php echo DLM_URL; ?>/<?php echo $name; ?>/widget/profile.js?temp=1<?php if($color):?>&color=<?php echo $color; ?><?php endif; ?><?php if($hidePrices):?>&hidePrices=1<?php endif;?>" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no username was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>