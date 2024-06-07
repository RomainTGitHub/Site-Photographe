jQuery(document).ready(function ($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var page = 2;

    $('#load-more-button').on('click', function () {
        var data = {
            'action': 'load_more_images',
            'page': page,
        };

        $.post(ajaxurl, data, function (response) {
            if (response) {
                $('.gallery-grid').append(response);
                page++;
            } else {
                $('#load-more-button').text('No more images');
                $('#load-more-button').prop('disabled', true);
            }
        });
    });
});
