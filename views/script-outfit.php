<?php if($sid): ?>
    <script class="widget-<?php echo $sid; ?>" src="https://dresslikeme.com/e/<?php echo $sid ?>/widget.js" async></script>
<?php else: ?>
    <pre>
        <?php echo __('Unfortunately, no ID was passed. Please check the settings of your DressLikeMe plugin.', DLM_TD); ?>
    </pre>
<?php endif; ?>