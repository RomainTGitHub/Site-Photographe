<!-- /templates_part/contact_modal.html -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/medias/Contact header.png">
                <button type=" button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="contactForm">
                    <?php echo do_shortcode('[contact-form-7 id="497eaeb" title="Formulaire de contact 1"]'); ?>
                </form>
            </div>
        </div>
    </div>
</div>