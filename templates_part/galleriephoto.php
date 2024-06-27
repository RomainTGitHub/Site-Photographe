<div class="gallery-container">
	<div class="filters">
		<!-- Premier menu déroulant -->
		<div id="categories-dropdown" class="dropdown">
			<div class="dropdown-selected">Catégories</div>
			<ul class="dropdown-menu">
				<li class="dropdown-item" data-value="reception">Réception</li>
				<li class="dropdown-item" data-value="television">Télévision</li>
				<li class="dropdown-item" data-value="concert">Concert</li>
				<li class="dropdown-item" data-value="mariage">Mariage</li>
			</ul>
		</div>
		<!-- Deuxième menu déroulant -->
		<div id="formats-dropdown" class="dropdown">
			<div class="dropdown-selected">Formats</div>
			<ul class="dropdown-menu">
				<li class="dropdown-item" data-value="portrait">Portrait</li>
				<li class="dropdown-item" data-value="paysage">Paysage</li>
			</ul>
		</div>
		<!-- Troisiéme menu déroulant -->
		<div id="order-by-dropdown" class="dropdown">
			<div class="dropdown-selected">Trier par</div>
			<ul class="dropdown-menu">
				<li class="dropdown-item" data-value="recentes">A partir des plus récentes</li>
				<li class="dropdown-item" data-value="anciennes">A partir des plus anciennes</li>
			</ul>
		</div>
	</div>

	<div class="gallery-grid">
		<?php
		// Récupérer les filtres et les utiliser dans la requête WP
		$category_filter = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
		$format_filter = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
		$order_by = isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'desc';

		// Configurer les arguments de la requête
		$args = array(
			'post_type' => 'photo',
			'posts_per_page' => 8,
			'orderby' => 'date',
			'order' => ($order_by === 'anciennes') ? 'ASC' : 'DESC',
			'tax_query' => array('relation' => 'AND'),
			'meta_query' => array()
		);

		// Ajouter le filtre de catégorie à la requête
		if (!empty($category_filter)) {
			$args['tax_query'][] = array(
				'taxonomy' => 'categorie',
				'field' => 'slug',
				'terms' => $category_filter,
			);
		}

		// Ajouter le filtre de format à la requête
		if (!empty($format_filter)) {
			$args['tax_query'][] = array(
				'taxonomy' => 'format',
				'field' => 'slug',
				'terms' => $format_filter,
			);
		}

		$query = new WP_Query($args);
		if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
				// Obtenir l'ID du post actuel
				$post_id = get_the_ID();
				// Créer le lien vers infophoto.php avec l'ID du post
				$info_photo_link = get_template_directory_uri() . "/infophoto.php?id=" . $post_id;
		?>
				<div class="gallery-item">
					<a href="<?php echo esc_url($info_photo_link); ?>">
						<?php the_post_thumbnail('large'); ?>
					</a>
				</div>
			<?php endwhile;
			wp_reset_postdata();
		else : ?>
			<p>Aucune photo trouvée.</p>
		<?php endif; ?>
	</div>

	<div class="load-more">
		<button id="load-more-button">Charger plus</button>
	</div>
</div>
</div> <!-- Ferme la div main-container -->