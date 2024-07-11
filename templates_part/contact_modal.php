<!-- /templates_part/contact_modal.html -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/Contact header.png">
            </div>
            <div class="modal-body">
                <form id="contactForm" class="wpcf7-form" data-config='{"ajax":true}'>
                    <?php echo do_shortcode('[contact-form-7 id="497eaeb" html_id="contactForm" title="Formulaire de contact 1"]'); ?>
                    <input type="hidden" id="photo-ref" name="photo-ref">
                    <div id="form-message"></div> <!-- Pour les messages de validation -->
                </form>
            </div>
        </div>
    </div>
</div>

<div id="overlay"></div> <!-- Overlay ajouté ici -->