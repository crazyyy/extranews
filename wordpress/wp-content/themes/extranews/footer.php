</div>
</div>
<div id="footer" class="clearfix">
    <div class="container clearfix">
        <div class="footerwidgetwrap clearfix">
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Left') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Center') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Right') ) ?></div>
        </div>
    </div>
</div>
<!-- Theme Hook -->
<?php wp_footer(); ?>
</body>
</html>
