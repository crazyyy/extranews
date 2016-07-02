<?php
/*
Template Name: Homepage - Slider
*/
get_header(); ?>

<?php
    // Declare initial vars
    $counter = 1;

    // Get Sticky Posts, Number, Slideshow Declared in Options Panel
    $sticky = get_option('sticky_posts');
    if ( !($stickyoption = of_get_option('of_sticky_posts') ) ) { $stickyoption = '2'; }
    if ( $thumbnum = of_get_option('of_thumbnail_number') ) { $thumbnum = ($thumbnum + 1); } else { $thumbnum = 7;}
	if ( !($homeslideshow = of_get_option('of_home_autoplay'))) { $homeslideshow = 'true';}
	if ( !($columns = of_get_option('of_home_column_number') ) ) { $columns = 'twocol'; } else { $columns = of_get_option('of_home_column_number'); }

    // Get News Category Name, ID and number to display
    $newscat = of_get_option('of_news_category'); //Cat ID.
    $newscatname = get_cat_name( $newscat ); //Cat Name
    if ( !($homeposts = of_get_option('of_home_posts') ) ) { $homeposts = '6'; }

    // Get Review Style and Review Number
    if ( !($reviewstyle = of_get_option('of_review_style') ) ) { $reviewstyle = 'percentage'; } else { $reviewstyle = of_get_option('of_review_style'); }
    if ( !($reviewnum = of_get_option('of_review_number') ) ) { $reviewnum = '5'; } else { $reviewnum = of_get_option('of_review_number'); }
?>

<div class="blogindex">
    <div class="container clearfix">
        <div class="maincontent slidercontent clearfix">
            <div class="homepageslideshow featuredimage">
                <div class="slider-wrapper theme-default">
                  <?php putRevSlider("homeslider") ?>
                </div><!-- End slider-wrapper -->
            </div><!-- End homepageslideshow -->

            <div class="maincontent noborder">
              <?php the_content(); ?>
            </div>

            <div class="ajax-select clearfix">
                <ul class="sf-menu">
                    <li id="news_list">
                        <a id="news_select" href="#"><?php echo ($newscatname) ? $newscatname : __('Latest Posts', 'framework'); ?></a>
                        <div class="tooltip">&larr; <?php _e('More Headlines', 'framework'); ?></div>
                        <ul>
                            <li class="segment-2"><a href="#" data-value="all" title="<?php _e('Latest Posts', 'framework'); ?>"><?php _e('Latest Posts', 'framework'); ?></a></li>
                            <?php wp_list_categories(array('title_li' => '', 'walker' => new Walker_Cat_Filter())); ?>
                        </ul>
                    </li>
                </ul>
            </div><!-- End ajax-select -->

            <div class="articlecontainer nonfeatured homepage maincontent">

                <span class="smallloading"></span>

            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $postsperpage = get_option('posts_per_page');

            query_posts(
                array(
                    'ignore_sticky_posts' => 1,
                    'posts_per_page' => $postsperpage,
                    'cat' => $newscat, 'posts_per_page' => $homeposts, 'paged' => $paged, 'post__not_in' => $postids
                )
            );
            ?>
                    <?php
                        get_template_part('functions/onecol');
                    ?>

                     <div class="pagination clearfix">
                <?php
                    global $wp_query;

                    $big = 999999999; // need an unlikely integer

                    echo paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $wp_query->max_num_pages
                    ) );
                ?>
                <div class="clear"></div>
            </div> <!-- End pagination -->



            </div><!-- End articlecontainer -->
        </div><!-- End maincontent -->

        <div class="sidebar">
            <?php   /* Widget Area */   if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Home Sidebar') ) ?>
        </div>
    </div><!-- End Container -->
</div><!-- End Blogwrap -->
<?php get_footer(); ?>
