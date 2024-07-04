<?php
// Récupère les termes de la taxonomie 'categorie'.
$categories = get_terms(array(
	'taxonomy' => 'categorie',
	'hide_empty' => false,
));

// Récupère les termes de la taxonomie 'format'.
$formats = get_terms(array(
	'taxonomy' => 'format',
	'hide_empty' => false,
));
?>

<div class="dropdowns-container">
	<div class="left-dropdowns">
		<!-- Menu déroulant des catégories -->
		<div id="categories-dropdown" class="dropdown">
			<div class="dropdown-selected">Catégories</div>
			<ul class="dropdown-menu">
				<?php foreach ($categories as $category) : ?>
					<li class="dropdown-item" data-value="<?php echo esc_attr($category->slug); ?>">
						<?php echo esc_html($category->name); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<!-- Menu déroulant des formats -->
		<div id="formats-dropdown" class="dropdown">
			<div class="dropdown-selected">Formats</div>
			<ul class="dropdown-menu">
				<?php foreach ($formats as $format) : ?>
					<li class="dropdown-item" data-value="<?php echo esc_attr($format->slug); ?>">
						<?php echo esc_html($format->name); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="right-dropdown">
		<!-- Menu déroulant de tri -->
		<div id="order-by-dropdown" class="dropdown">
			<div class="dropdown-selected">Trier par</div>
			<ul class="dropdown-menu">
				<li class="dropdown-item" data-value="recentes">A partir des plus récentes</li>
				<li class="dropdown-item" data-value="anciennes">A partir des plus anciennes</li>
			</ul>
		</div>
	</div>
</div>

<div id="gallery-grid" class="gallery-grid">
	<?php
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) :
		$count = 0;
		while ($query->have_posts()) : $query->the_post();
			if ($count >= 8) break; // Afficher seulement les 8 premières images
			$count++;
			$post_id = get_the_ID();
			$image_url = get_the_post_thumbnail_url($post_id, 'full');
			$image_full_url = get_the_post_thumbnail_url($post_id, 'full');
			$title = get_the_title($post_id);
			$reference = get_post_meta($post_id, 'reference', true);
			$categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "names"));
	?>
			<div class="related-photo-card">
				<div class="related-photo-overlay">
					<div class="related-photo-fullscreen">
						<a href="#" class="open-lightbox" data-full-url="<?php echo esc_url($image_full_url); ?>" data-reference="<?php echo esc_html($reference); ?>" data-category="<?php echo esc_html(implode(', ', $categories)); ?>"><i class="fas fa-expand"></i></a>
					</div>
					<div class="related-photo-view">
						<a href="<?php echo esc_url(home_url('/info-photo/?id=' . $post_id)); ?>"><i class="fas fa-eye"></i></a>
					</div>
					<div class="related-photo-info">
						<span class="related-photo-reference"><?php echo esc_html($reference); ?></span>
						<span class="related-photo-category"><?php echo esc_html(implode(', ', $categories)); ?></span>
					</div>
				</div>
				<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
			</div>
		<?php endwhile; ?>
</div>

<?php if ($query->post_count > 8) : ?>
	<div class="load-more-container">
		<button id="load-more" class="load-more-button">Charger plus</button>
	</div>
<?php endif; ?>

<?php
	else :
		echo '<p>Aucune photo trouvée.</p>';
	endif;
	wp_reset_postdata();
?>

</div> <!-- Ferme la div main-container -->