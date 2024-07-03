// Écoute l'événement DOMContentLoaded pour exécuter la fonction une fois que le DOM est complètement chargé.
document.addEventListener('DOMContentLoaded', function () {
    // Fonction pour configurer un menu déroulant spécifique identifié par dropdownId.
    function setupDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        if (!dropdown) return; // Vérifie si l'élément existe
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

                dropdownItems.forEach(function (dropdownItem) {
                    dropdownItem.classList.remove('selected');
                });
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
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    const body = document.body;

    if (!hamburger || !navMenu || !hamburgerIcon || !closeIcon) return;

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

// Utilise jQuery pour gérer l'affichage du modal de contact et les événements de formulaire.
jQuery(document).ready(function ($) {
    var modal = $('#contactModal');
    var btn = $('#contactBtn'); // Bouton existant avec ID
    var boutons = $('.open-modal'); // Boutons avec la classe open-modal
    var overlay = $('#overlay');
    var formMessage = $('#form-message');

    // Fonction pour ouvrir la modale
    function openModal(button) {
        var photoReference = button.data('reference');
        if (photoReference) {
            $('#photo-ref').val(photoReference);
        }
        modal.addClass('show');
        modal.css('display', 'flex');
        overlay.css('display', 'block'); // Affiche l'overlay
    }

    // Ouvre la modale lorsque le bouton est cliqué
    btn.on('click', function (event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        openModal($(this));
    });

    boutons.on('click', function (event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        openModal($(this));
    });

    // Ferme la modale et l'overlay lorsque l'utilisateur clique en dehors de la modale
    $(window).on('click', function (event) {
        if ($(event.target).is(modal) || $(event.target).is(overlay)) {
            modal.removeClass('show');
            modal.css('display', 'none');
            overlay.css('display', 'none'); // Cache l'overlay
        }
    });

    // Gestion des événements du formulaire Contact Form 7 avec AJAX
    document.addEventListener('wpcf7mailsent', function (event) {
        formMessage.html('<p class="success">Formulaire envoyé avec succès !</p>');
    }, false);

    document.addEventListener('wpcf7invalid', function (event) {
        formMessage.html('<p class="error">Veuillez vérifier les champs du formulaire.</p>');
    }, false);

    document.addEventListener('wpcf7spam', function (event) {
        formMessage.html('<p class="error">Le message a été identifié comme spam.</p>');
    }, false);

    document.addEventListener('wpcf7mailfailed', function (event) {
        formMessage.html('<p class="error">Échec de l\'envoi du message.</p>');
    }, false);

    // Empêche le rafraîchissement de la page à la soumission du formulaire
    $(document).on('submit', '.wpcf7-form', function (e) {
        e.preventDefault();
    });
});

// Script pour la lightbox //

let currentSlideIndex = 0;
const slides = document.querySelectorAll('.related-photo-card');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const lightboxReference = document.getElementById('lightbox-reference');
const lightboxCategory = document.getElementById('lightbox-category');

function openLightbox(index) {
    currentSlideIndex = index;
    const slide = slides[currentSlideIndex];
    const imgSrc = slide.querySelector('.related-photo-fullscreen a').getAttribute('data-full-url');
    const reference = slide.querySelector('.related-photo-reference').textContent;
    const category = slide.querySelector('.related-photo-category').textContent;

    lightboxImg.src = imgSrc;
    lightboxReference.textContent = reference;
    lightboxCategory.textContent = category;

    lightbox.style.display = 'flex';
}

function closeLightbox() {
    lightbox.style.display = 'none';
}

function changeSlide(n) {
    currentSlideIndex += n;
    if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    } else if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    }
    openLightbox(currentSlideIndex);
}

document.querySelectorAll('.related-photo-fullscreen a').forEach((button, index) => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        openLightbox(index);
    });
});

