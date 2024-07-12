<?php get_header(); ?>

<div class="single-post-container">
    <div class="back-to-blog">
        <a href="http://nathalie-mota.local/blog-listes-des-articles/" class="back-button">← Retour à la liste des articles</a>
    </div>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="post-content">
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <span class="post-author">par <?php the_author(); ?></span>
                    </div>
                    <div class="post-text">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>

    <?php
        endwhile;
    else :
        echo '<p>Aucun article trouvé.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>