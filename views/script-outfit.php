<?php if(isset($sid) && isset($style)): ?>
    <script class="widget-<?php echo $sid; ?>" src="<?php echo DLM_URL ?>/e/<?php echo $sid ?>/widget.js?layout=<?php echo $style; ?><?php if($color):?>&color=<?php echo $color; ?><?php endif; ?><?php if($hidePrices):?>&hidePrices=1<?php endif;?>" async></script>
<?php else: ?>
    <pre>
        <?php _e('Unfortunately, no ID was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif;
?>