// Écoute l'événement DOMContentLoaded pour exécuter la fonction une fois que le DOM est complètement chargé.
document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour configurer un menu déroulant spécifique identifié par dropdownId.
    function setupDropdown(dropdownId) {
        // Sélectionne le menu déroulant par son ID.
        const dropdown = document.getElementById(dropdownId);
        const dropdownSelected = dropdown.querySelector('.dropdown-selected');
        const dropdownMenu = dropdown.querySelector('.dropdown-menu');
        const dropdownItems = dropdown.querySelectorAll('.dropdown-item');

        // Ajoute un événement de clic sur l'élément sélectionné du menu déroulant.
        dropdownSelected.addEventListener('click', function () {
            const isOpen = dropdown.classList.contains('open');
            // Ferme tous les autres menus déroulants ouverts.
            document.querySelectorAll('.dropdown.open').forEach(function (otherDropdown) {
                otherDropdown.classList.remove('open');
            });
            // Ouvre ou ferme le menu déroulant actuel.
            if (!isOpen) {
                dropdown.classList.add('open');
            } else {
                dropdown.classList.remove('open');
            }
        });

        // Ajoute un événement de clic sur chaque élément du menu déroulant.
        dropdownItems.forEach(function (item) {
            item.addEventListener('click', function () {
                // Met à jour le texte de l'élément sélectionné et ferme le menu déroulant.
                dropdownSelected.textContent = this.textContent;
                dropdown.classList.remove('open');
                const value = this.getAttribute('data-value');
                dropdownSelected.setAttribute('data-value', value);
                console.log('Selected value:', value);

                // Supprime la classe 'selected' de tous les éléments et ajoute-la à l'élément cliqué.
                dropdownItems.forEach(function (dropdownItem) {
                    dropdownItem.classList.remove('selected');
                });
                this.classList.add('selected');
            });
        });

        // Ferme le menu déroulant si un clic se produit en dehors de celui-ci.
        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
            }
        });
    }

    // Configure les différents menus déroulants de la page.
    setupDropdown('categories-dropdown');
    setupDropdown('formats-dropdown');
    setupDropdown('order-by-dropdown');
});

// Écoute l'événement DOMContentLoaded pour mettre à jour la galerie lorsque les menus déroulants changent.
document.addEventListener('DOMContentLoaded', function () {
    const categoriesDropdown = document.getElementById('categories-dropdown');
    const formatsDropdown = document.getElementById('formats-dropdown');
    const orderByDropdown = document.getElementById('order-by-dropdown');

    // Fonction pour mettre à jour la galerie en fonction des sélections des menus déroulants.
    function updateGallery() {
        const category = categoriesDropdown.querySelector('.dropdown-selected').getAttribute('data-value');
        const format = formatsDropdown.querySelector('.dropdown-selected').getAttribute('data-value');
        const order = orderByDropdown.querySelector('.dropdown-selected').getAttribute('data-value');

        // Met à jour les paramètres de l'URL en fonction des sélections et recharge la page.
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

    // Ajoute un événement de clic sur chaque menu déroulant pour mettre à jour la galerie.
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

// Écoute l'événement DOMContentLoaded pour gérer le menu hamburger.
document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    const body = document.body;

    // Ajoute un événement de clic sur l'icône hamburger pour ouvrir ou fermer le menu de navigation.
    hamburger.addEventListener('click', function () {
        navMenu.classList.toggle('active');
        hamburger.classList.toggle('open');
        body.classList.toggle('no-scroll');

        // Alterne l'affichage des icônes hamburger et de fermeture.
        if (navMenu.classList.contains('active')) {
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        } else {
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    });
});

// Utilise jQuery pour gérer l'affichage du modal de contact et les événements de formulaire.
jQuery(document).ready(function ($) {
    var modal = $('#contactModal');
    var btn = $('#contactButton');

    // Ouvre le modal de contact et remplit une référence de photo si disponible.
    btn.on('click', function () {
        var photoReference = $(this).data('reference');
        if (photoReference) {
            $('#photo-ref').val(photoReference);
        }
        modal.addClass('show');
        modal.css('display', 'flex');
    });

    // Ferme le modal lorsque l'utilisateur clique en dehors de celui-ci.
    $(window).on('click', function (event) {
        if ($(event.target).is(modal)) {
            modal.removeClass('show');
            modal.css('display', 'none');
        }
    });

    // Gestion des événements du formulaire Contact Form 7.
    document.addEventListener('wpcf7mailsent', function (event) {
        modal.removeClass('show');
        modal.css('display', 'none');
        alert("Formulaire envoyé avec succès !");
    }, false);

    document.addEventListener('wpcf7invalid', function (event) {
        alert("Veuillez vérifier les champs du formulaire.");
    }, false);

    document.addEventListener('wpcf7spam', function (event) {
        alert("Le message a été identifié comme spam.");
    }, false);

    document.addEventListener('wpcf7mailfailed', function (event) {
        alert("Échec de l'envoi du message.");
    }, false);
});
