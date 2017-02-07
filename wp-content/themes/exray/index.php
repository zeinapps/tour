<?php get_header(); ?>
<!-- Main Content -->

<!-- Below header -->
<?php get_sidebar('below-header'); ?>
<!-- End below header -->

<div class="container" id="main-container">

    <div class="row">

        <?php get_exray_primary_sidebar(); ?>

        <?php get_exray_content_html_opening(); ?>

            <div class="content" role="main">
                <!-- The Loop of Post -->
                <?php if (have_posts()) : while (have_posts()): the_post(); ?>		

                        <!-- If template part content exist, show post format content items -->
                        <?php get_template_part('content', get_post_format()); ?>				

                    <?php endwhile;
                else : ?>
                    <!-- If no Post Found -->
                    <h1><?php _e("No post were Found", "exray") ?></h1>

                <?php endif; ?>
                
                <?php 
                if(!array_key_exists('pagination_options', $exray_general_options) ){
                    $exray_general_options['pagination_options'] = 'default';
                    $pagination_options = 'default';
                } else {
                    $pagination_options = $exray_general_options['pagination_options'] ;
                }
                ?>

                <?php if ($pagination_options == 'default') : ?>

                    <div class="exray-page-navi">
                    <?php
                        global $wp_query;

                        $big = 999999999; // need an unlikely integer

                        echo paginate_links( array(
                            'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format'    => '?paged=%#%',
                            'prev_text' =>__('&laquo; Older Post', 'exray'),
                            'next_text' => __('Newer Post &raquo;', 'exray'),
                            'current'   => max( 1, get_query_var('paged') ),
                            'total'     => $wp_query->max_num_pages,
                        ) );
                    ?>
                    </div>
            
                <?php else : ?>
                    <!-- Pagination for older / newer post -->
                    <nav class="pagination clearfix"  id="nav-below" role="navigation">

                        <p class="article-nav-prev"><?php next_posts_link(__('&larr; Older Post', 'exray')); ?></p>
                        <p class="article-nav-next"><?php previous_posts_link(__('Newer Post &rarr; ', 'exray')); ?></p>

                    </nav>	
                    <!-- End nav-below -->
                <?php endif; ?>
            </div> 
            <!-- end content -->
        </div> 
        <!-- end span6 main -->	 
    
        <?php get_exray_secondary_sidebar(); ?>   

    </div> 
    <!--End row -->

</div>	
<!-- End Container  -->
<!-- End Main Content -->

<?php get_footer(); ?>