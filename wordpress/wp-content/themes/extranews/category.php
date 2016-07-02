<?php get_header(); ?>

<?php
    if ( !($columns = of_get_option('of_column_number') ) ) { $reviewnum = 'twocol'; } else { $columns = of_get_option('of_column_number'); }
    $thisCat = get_category(get_query_var('cat'),false);
    $cur_cat_id = $thisCat->cat_ID;
    ?>

<div class="blogindex">

    <div class="container clearfix titlecontainer">
        <div class="pagetitlewrap">
            <h1 class="pagetitle">
                <?php wp_title("",true);
    			if(!wp_title("",false)) { echo bloginfo( 'title');} ?>
            </h1>
            <div class="mobileclear"></div>
            <span class="description">
                <?php echo category_description(); ?>
            </span>
        </div>
    </div>

    <div class="clear"></div>


    <div class="container clearfix">
        <div class="articlecontainer nonfeatured maincontent"><div class="clear"></div>

                <?php
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $postsperpage = get_option('posts_per_page');

                    query_posts(
                        array(
                            'ignore_sticky_posts' => 1,
                            'posts_per_page' => $postsperpage,
                            'paged' => $paged,
                            'cat' => $cur_cat_id
                        )
                    ); ?>

            <?php get_template_part('functions/onecol');  ?>

            <div class="cat-description">
              <?php
                $queried_object = get_queried_object();
                $taxonomy = $queried_object->taxonomy;
                $term_id = $queried_object->term_id;

                // load thumbnail for this taxonomy term (term string)
                $description = get_field('description', $taxonomy . '_' . $term_id);
                echo $description;
              ?>
            </div><!-- /.cat-description -->

            <div class="pagination">
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

        <div class="sidebar">
            <?php	/* Widget Area */	if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Blog Sidebar') ) ?>
        </div>
        <div class="clear"></div>

    </div><!-- End Container -->
</div><!-- End Blogwrap -->
<?php get_footer(); ?>
