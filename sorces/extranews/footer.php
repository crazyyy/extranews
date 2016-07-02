</div>
</div>
<!-- Close Mainbody and Sitecontainer and start footer
  ================================================== -->
<div class="clear"></div>
<div id="footer">
    <div class="container clearfix">
        <div class="footerwidgetwrap">
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Left') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Center') ) ?></div>
            <div class="footerwidget"><?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Right') ) ?></div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<!-- Theme Hook -->
<?php wp_footer(); ?>
<?php echo of_get_option('of_google_analytics'); ?>
<!-- Close Site Container
  ================================================== -->
</body>
</html>