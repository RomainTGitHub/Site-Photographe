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

$date = get_terms(array(
	'taxonomy' => 'format',
	'hide_empty' => false,
));
?>

<section class="dropdowns-container">
	<div class="left-dropdowns">
		<!-- Menu déroulant des catégories -->
		<div id="categories-dropdown" class="dropdown">
			<div class="dropdown-selected">Catégories</div>
			<ul class="dropdown-menu">
				<li class="dropdown-item" data-value="all"></li> <!-- Option pour afficher toutes les catégories -->
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
				<li class="dropdown-item" data-value="all"></li>
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
				<li class="dropdown-item" data-value="recentes">À partir des plus récentes</li>
				<li class="dropdown-item" data-value="anciennes">À partir des plus anciennes</li>
			</ul>
		</div>
	</div>
</section>

<div id="gallery-grid" class="gallery-grid">
	<?php
	$args = array(
		'post_type' => 'photo',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$query = new WP_Query($args);

	$all_photos = array();

	if ($query->have_posts()) :
		$count = 0;
		while ($query->have_posts()) : $query->the_post();
			$count++;
			$post_id = get_the_ID();
			$image_url = get_the_post_thumbnail_url($post_id, 'medium_large');
			$image_full_url = get_the_post_thumbnail_url($post_id, 'full');
			$title = get_the_title($post_id);
			$reference = get_post_meta($post_id, 'reference', true);
			$categories = wp_get_post_terms($post_id, 'categorie', array("fields" => "names"));
			$categories_slugs = wp_get_post_terms($post_id, 'categorie', array("fields" => "slugs"));
			$format_slugs = wp_get_post_terms($post_id, 'format', array("fields" => "slugs"));
			$date = get_the_date('Y-m-d', $post_id);
			$all_photos[] = array(
				'id' => $post_id,
				'fullUrl' => $image_url,
				'title' => $title,
				'reference' => $reference,
				'category' => implode(', ', $categories)
			);
			$formats = wp_get_post_terms($post_id, 'format', array("fields" => "names"));
			$date = get_the_date('Y', $post_id);
	?>
			<div class="related-photo-card" data-date="<?php echo esc_attr($date); ?>" data-category="<?php echo esc_attr(implode(' ', $categories_slugs)); ?>" data-format="<?php echo esc_attr(implode(' ', $format_slugs)); ?>">
				<div class="related-photo-overlay">
					<div class="related-photo-fullscreen">
						<a href="#" class="open-lightbox" data-full-url="<?php echo esc_url($image_full_url); ?>" data-reference="<?php echo esc_html($reference); ?>" data-category="<?php echo esc_html(implode(', ', $categories)); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34" fill="none">
								<circle cx="17" cy="17" r="17" fill="black" />
								<line x1="15" y1="10.5" x2="10" y2="10.5" stroke="white" />
								<line y1="-0.5" x2="5" y2="-0.5" transform="matrix(-1 8.74227e-08 8.74227e-08 1 15 24)" stroke="white" />
								<line x1="9.5" y1="16" x2="9.5" y2="10" stroke="white" />
								<line y1="-0.5" x2="6" y2="-0.5" transform="matrix(4.37114e-08 1 1 -4.37114e-08 10 18)" stroke="white" />
								<line y1="-0.5" x2="5" y2="-0.5" transform="matrix(1 -8.74227e-08 -8.74227e-08 -1 19 10)" stroke="white" />
								<line y1="-0.5" x2="6" y2="-0.5" transform="matrix(-4.37114e-08 -1 -1 4.37114e-08 24 16)" stroke="white" />
								<line x1="19" y1="23.5" x2="24" y2="23.5" stroke="white" />
								<line x1="24.5" y1="18" x2="24.5" y2="24" stroke="white" />
							</svg></a>
					</div>
					<div class="related-photo-view">
						<a href="<?php echo esc_url(home_url('/info-photo/?id=' . $post_id)); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="46" height="32" viewBox="0 0 46 32" fill="none">
								<path d="M45.9081 15.5489C41.9937 6.34547 33.0015 0.398438 23 0.398438C12.9985 0.398438 4.00649 6.34529 0.0919102 15.5489C-0.0306367 15.8369 -0.0306367 16.1622 0.0919102 16.4503C4.00622 25.6548 12.9983 31.6023 23 31.6023C33.0019 31.6023 41.994 25.6548 45.9081 16.4503C46.0306 16.1622 46.0306 15.8369 45.9081 15.5489ZM23 29.2992C14.088 29.2992 6.05933 24.0953 2.40862 15.9997C6.05942 7.90497 14.0883 2.70158 23 2.70158C31.9119 2.70158 39.9407 7.90497 43.5914 15.9995C39.9407 24.0951 31.912 29.2992 23 29.2992Z" fill="white" />
								<path d="M23 7.17993C18.1364 7.17993 14.1797 11.1367 14.1797 16.0003C14.1797 20.8638 18.1365 24.8206 23 24.8206C27.8635 24.8206 31.8203 20.8639 31.8203 16.0003C31.8203 11.1366 27.8635 7.17993 23 7.17993ZM23 22.5177C19.4064 22.5177 16.4827 19.594 16.4827 16.0004C16.4827 12.4069 19.4064 9.48317 23 9.48317C26.5936 9.48317 29.5173 12.4069 29.5173 16.0004C29.5173 19.594 26.5936 22.5177 23 22.5177Z" fill="white" />
								<path d="M22.9999 11.3176C20.4179 11.3176 18.317 13.4184 18.317 16.0006C18.317 16.6365 18.8325 17.1521 19.4685 17.1521C20.1046 17.1521 20.6201 16.6365 20.6201 16.0006C20.6201 14.6883 21.6876 13.6207 22.9999 13.6207C23.636 13.6207 24.1515 13.1051 24.1515 12.4692C24.1515 11.8331 23.6359 11.3176 22.9999 11.3176Z" fill="white" />
							</svg></a>
					</div>
					<div class="related-photo-info">
						<span class="related-photo-reference"><?php echo esc_html($reference); ?></span>
						<span class="related-photo-category"><?php echo esc_html(implode(', ', $categories)); ?></span>
					</div>
				</div>
				<img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
			</div>
	<?php endwhile;
	else :
		echo '<p>Aucune photo trouvée.</p>';
	endif;
	wp_reset_postdata();
	?>
</div>


<div class="load-more-container">
	<button id="load-more" class="load-more-button">Charger plus</button>
</div>