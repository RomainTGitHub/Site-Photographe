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

document.addEventListener('DOMContentLoaded', function () {
    function setupDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        const dropdownSelected = dropdown.querySelector('.dropdown-selected');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        const dropdownItems = dropdown.querySelectorAll('.dropdown-item');

        dropdownSelected.addEventListener('click', function () {
            const isOpen = dropdown.classList.contains('open');
            document.querySelectorAll('.dropdown.open').forEach(function (otherDropdown) {
                otherDropdown.classList.remove('open');
            });
            if (!isOpen) {
                dropdown.classList.add('open');
            } else {
                dropdown.classList.remove('open');
            }
        });

        dropdownItems.forEach(function (item) {
            item.addEventListener('click', function () {
                dropdownSelected.textContent = this.textContent;
                dropdown.classList.remove('open');
                const value = this.getAttribute('data-value');
                console.log('Selected value:', value);
                // Vous pouvez ajouter ici du code pour gérer les changements de sélection

                // Retirer la classe 'selected' de tous les items de ce menu déroulant spécifique
                dropdownItems.forEach(function (dropdownItem) {
                    dropdownItem.classList.remove('selected');
                });

                // Ajouter la classe 'selected' à l'élément cliqué
                this.classList.add('selected');
            });
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
            }
        });
    }

    setupDropdown('categories-dropdown');
    setupDropdown('formats-dropdown');
    setupDropdown('sort-by-dropdown');
});
