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
				<li class="dropdown-item" data-value="recentes">À partir des plus récentes</li>
				<li class="dropdown-item" data-value="anciennes">À partir des plus anciennes</li>
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
			$formats = wp_get_post_terms($post_id, 'format', array("fields" => "names"));
			$date = get_the_date('Y', $post_id);
	?>
			<div class="related-photo-card" data-date="<?php echo esc_attr($date); ?>">
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
						<span class="related-photo-format"><?php echo esc_html(implode(', ', $formats)); ?></span>
						<span class="related-photo-date"><?php echo esc_html($date); ?> </span>
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

<script>
	jQuery(document).ready(function($) {
		var offset = 8;
		var category = '';
		var format = '';
		var order = '';

		function filterPhotos() {
			var filteredCards = $('.related-photo-card').hide(); // Masquer toutes les cartes

			filteredCards = filteredCards.filter(function() {
				var categoryMatch = true;
				var formatMatch = true;

				if (category) {
					categoryMatch = $(this).find('.related-photo-category').text().toLowerCase().indexOf(category.toLowerCase()) !== -1;
				}
				if (format) {
					formatMatch = $(this).find('.related-photo-format').text().toLowerCase().indexOf(format.toLowerCase()) !== -1;
				}

				return categoryMatch && formatMatch;
			});

			if (order === 'recentes') {
				filteredCards.sort(function(a, b) {
					return new Date($(b).data('date')) - new Date($(a).data('date'));
				});
			} else if (order === 'anciennes') {
				filteredCards.sort(function(a, b) {
					return new Date($(a).data('date')) - new Date($(b).data('date'));
				});
			}

			filteredCards.slice(0, offset).show(); // Afficher uniquement le nombre de cartes spécifié par offset

			if (filteredCards.length > offset) {
				$('#load-more').show();
			} else {
				$('#load-more').hide();
			}
		}

		$('.dropdown-item').click(function() {
			var dropdown = $(this).closest('.dropdown');
			var value = $(this).data('value');
			dropdown.find('.dropdown-selected').text($(this).text());

			if (dropdown.attr('id') === 'categories-dropdown') {
				category = value;
			} else if (dropdown.attr('id') === 'formats-dropdown') {
				format = value;
			} else if (dropdown.attr('id') === 'order-by-dropdown') {
				order = value;
			}

			offset = 8; // Réinitialiser l'offset lors du tri
			filterPhotos();
		});

		$('#load-more').click(function() {
			offset += 8; // Augmenter l'offset pour afficher plus de cartes
			filterPhotos();
		});

		// Filtrer les photos au chargement initial
		filterPhotos();
	});
</script>

</div> <!-- Ferme la div main-container -->

</div> <!-- Ferme la div main-container -->