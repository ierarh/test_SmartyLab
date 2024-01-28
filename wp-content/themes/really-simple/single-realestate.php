<?php

use RealEstate\Components\Registered;

get_header(); ?>
<?php if (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(['post-card']); ?>>
        <div class="card-body">
            <header class="entry-header">
                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
            </header><!-- .entry-header -->
            <div class="entry-meta">
                <?php
                $districts = wp_get_post_terms(get_the_ID(), Registered::$taxonomy_id, ['fields' => 'names']);
                if($districts):
                    echo implode(', ', $districts);
                endif;
                ?>
            </div>
            <div class="entry-content">
                <div>
                    <strong><?php esc_html_e('Building Name'); ?>:</strong>&nbsp; <?php the_field('estate_name'); ?>
                </div>
                <div>
                    <strong><?php esc_html_e('Coordinates '); ?></strong>&nbsp; <?php the_field('estate_coordinate'); ?>
                </div>
                <div>
                    <strong><?php esc_html_e('Count of floors '); ?></strong>&nbsp; <?php the_field('estate_floor'); ?>
                </div>
                <div>
                    <strong><?php esc_html_e('Type of Building'); ?>:</strong>&nbsp; <?php the_field('estate_type'); ?>
                </div>
            </div>
        </div>
    </article>
<?php endif; ?>
    </main><!-- #main -->
    <aside class="widget-area">
        <?php get_sidebar(); ?>
    </aside>
    </div><!-- #primary -->

<?php
get_footer();
