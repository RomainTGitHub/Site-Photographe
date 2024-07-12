<?php /* Template Name: Blog list */
get_header();
?>
<div class="blog-list-container">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <div class="blog-posts-grid">
        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 9,
            'paged' => $paged
        ));
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>
                <div class="blog-post-item">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata(); // Reset the post data
        else :
            echo '<p>Aucun article trouvé.</p>'; // Message pour débogage
        endif;
        ?>
    </div>

    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => __('« Précédent'),
            'next_text' => __('Suivant »')
        ));
        ?>
    </div>
</div>
<?php get_footer(); ?>