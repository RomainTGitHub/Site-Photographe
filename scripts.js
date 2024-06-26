jQuery(document).ready(function ($) {
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var page = 2;

    $('#load-more-button').on('click', function () {
        var category = $('#categories-dropdown .dropdown-selected').attr('data-value');
        var format = $('#formats-dropdown .dropdown-selected').attr('data-value');
        var type = $('#sort-by-dropdown .dropdown-selected').attr('data-value');
        var order = $('#order-by-dropdown .dropdown-selected').attr('data-value');

        var data = {
            'action': 'load_more_images',
            'page': page,
            'category': category,
            'format': format,
            'type': type,
            'order': order,
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
                dropdownSelected.setAttribute('data-value', value);
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
    setupDropdown('order-by-dropdown');
});

document.addEventListener('DOMContentLoaded', function () {
    const categoriesDropdown = document.getElementById('categories-dropdown');
    const formatsDropdown = document.getElementById('formats-dropdown');
    const orderByDropdown = document.getElementById('order-by-dropdown');

    function updateGallery() {
        const category = categoriesDropdown.querySelector('.dropdown-selected').getAttribute('data-value');
        const format = formatsDropdown.querySelector('.dropdown-selected').getAttribute('data-value');
        const order = orderByDropdown.querySelector('.dropdown-selected').getAttribute('data-value');

        let url = new URL(window.location.href);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }

        if (format) {
            url.searchParams.set('format', format);
        } else {
            url.searchParams.delete('format');
        }

        if (order) {
            url.searchParams.set('order', order);
        } else {
            url.searchParams.delete('order');
        }

        window.location.href = url.toString();
    }

    [categoriesDropdown, formatsDropdown, orderByDropdown].forEach(dropdown => {
        dropdown.addEventListener('click', function (e) {
            if (e.target.classList.contains('dropdown-item')) {
                const selected = dropdown.querySelector('.dropdown-selected');
                selected.textContent = e.target.textContent;
                selected.setAttribute('data-value', e.target.getAttribute('data-value'));
                updateGallery();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    const body = document.body;

    hamburger.addEventListener('click', function () {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('open');
        body.classList.toggle('no-scroll');

        if (navMenu.classList.contains('active')) {
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        } else {
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    });
});