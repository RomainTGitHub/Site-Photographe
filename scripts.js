document.addEventListener('DOMContentLoaded', function () {
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

                // Appliquer le filtrage et tri des photos après chaque sélection
                filterPhotos();
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

    // Fonction pour déterminer le nombre de cartes visibles en fonction de la taille de l'écran
    function getMaxVisibleCards() {
        return window.innerWidth <= 800 ? 4 : 8;
    }

    // Script pour le tri et filtrage des photos de la galerie
    function filterPhotos() {
        const selectedCategory = document.querySelector('#categories-dropdown .dropdown-selected').getAttribute('data-value');
        const selectedFormat = document.querySelector('#formats-dropdown .dropdown-selected').getAttribute('data-value');
        const orderBy = document.querySelector('#order-by-dropdown .dropdown-selected').getAttribute('data-value');
        console.log('Filtering photos by category:', selectedCategory, 'format:', selectedFormat, 'and order by:', orderBy);

        const photoCards = Array.from(document.querySelectorAll('.related-photo-card'));

        // Filtrer les photos par catégorie et format
        photoCards.forEach(card => {
            const cardCategories = card.getAttribute('data-category').split(' ');
            const cardFormats = card.getAttribute('data-format').split(' ');

            const categoryMatch = (selectedCategory === 'all' || cardCategories.includes(selectedCategory));
            const formatMatch = (selectedFormat === 'all' || cardFormats.includes(selectedFormat));

            if (categoryMatch && formatMatch) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });

        // Trier les photos par date
        const visibleCards = photoCards.filter(card => !card.classList.contains('hidden'));
        visibleCards.sort((a, b) => {
            const dateA = new Date(a.getAttribute('data-date'));
            const dateB = new Date(b.getAttribute('data-date'));
            return orderBy === 'recentes' ? dateB - dateA : dateA - dateB;
        });

        // Réordonner les éléments du DOM en fonction de l'ordre trié
        const container = document.getElementById('gallery-grid');
        visibleCards.forEach(card => container.appendChild(card));

        // Gérer l'affichage des cartes (max 8 visibles) et du bouton "Charger plus"
        const maxVisible = getMaxVisibleCards();
        if (visibleCards.length > maxVisible) {
            for (let i = maxVisible; i < visibleCards.length; i++) {
                visibleCards[i].classList.add('hidden');
            }
            document.querySelector('.load-more-container').style.display = 'block';
        } else {
            document.querySelector('.load-more-container').style.display = 'none';
        }
    }

    // Gestion du bouton "Charger plus"
    document.getElementById('load-more').addEventListener('click', function () {
        document.querySelectorAll('.related-photo-card.hidden').forEach(card => {
            card.classList.remove('hidden');
        });
        this.style.display = 'none'; // Cacher le bouton après avoir affiché toutes les cartes
    });

    // Refiltrer les photos lorsque la taille de l'écran change
    window.addEventListener('resize', filterPhotos);

    // Appel initial pour afficher toutes les cartes au chargement de la page
    document.querySelector('#categories-dropdown .dropdown-selected').setAttribute('data-value', 'all');
    document.querySelector('#formats-dropdown .dropdown-selected').setAttribute('data-value', 'all');
    document.querySelector('#order-by-dropdown .dropdown-selected').setAttribute('data-value', 'recentes');
    filterPhotos();
});

// Script pour le menu hamburger
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const hamburgerIcon = document.querySelector('.hamburger-icon');
const closeIcon = document.querySelector('.close-icon');
const body = document.body;

if (hamburger && navMenu && hamburgerIcon && closeIcon) {
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
}

// jQuery pour gérer l'affichage du modal de contact et les événements de formulaire.
jQuery(document).ready(function ($) {
    var modal = $('#contactModal');
    var btn = $('#contactBtn'); // Bouton existant avec ID
    var boutons = $('.open-modal'); // Boutons avec la classe open-modal
    var overlay = $('#overlay');
    var formMessage = $('#form-message');
    var form = $('#contactForm'); // Sélectionne le formulaire par ID

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

    // Empêche le rafraîchissement de la page à la soumission du formulaire
    form.on('submit', function (e) {
        e.preventDefault();
    });
});

// Script pour la lightbox
jQuery(document).ready(function ($) {
    var currentPhotoIndex = 0;
    var allPhotos = [];

    // Fonction pour ouvrir la lightbox
    function openLightbox(index) {
        if (index >= 0 && index < allPhotos.length) {
            var photo = allPhotos[index];
            $('#lightbox-img').attr('src', photo.fullUrl);
            $('#lightbox-reference').text(photo.reference);
            $('#lightbox-category').text(photo.category);
            $('#lightbox').fadeIn();
            currentPhotoIndex = index;
        }
    }

    // Fonction pour fermer la lightbox
    window.closeLightbox = function () {
        $('#lightbox').fadeOut();
    }

    // Fonction pour changer la photo dans la lightbox
    window.changeSlide = function (direction) {
        currentPhotoIndex += direction;
        if (currentPhotoIndex < 0) {
            currentPhotoIndex = allPhotos.length - 1;
        } else if (currentPhotoIndex >= allPhotos.length) {
            currentPhotoIndex = 0;
        }
        openLightbox(currentPhotoIndex);
    }

    // Attache un événement de clic aux boutons d'ouverture de la lightbox
    $(document).on('click', '.open-lightbox', function (e) {
        e.preventDefault();
        var index = $(this).data('index');
        openLightbox(index);
    });

    // Fonction pour mettre à jour les photos visibles et attacher les événements de la lightbox
    function updateVisiblePhotos() {
        allPhotos = [];
        $('.related-photo-card, .infophoto-card').each(function (index) {
            var photo = {
                fullUrl: $(this).find('.open-lightbox').data('full-url'),
                reference: $(this).find('.related-photo-reference').text(),
                category: $(this).find('.related-photo-category').text()
            };
            allPhotos.push(photo);
            $(this).find('.open-lightbox').data('index', index); // Assigne l'index de chaque photo
        });

        // Réattacher les événements de clic aux nouveaux éléments
        $('.open-lightbox').off('click').on('click', function (e) {
            e.preventDefault();
            var index = $(this).data('index');
            openLightbox(index);
        });
    }

    updateVisiblePhotos(); // Initialiser les photos visibles

    // Script pour l'apercu des images au survol des fléches dans la page infophoto.php
    var navPreviewContainer = document.getElementById('nav-preview-container');

    function showPreview(imageUrl) {
        if (imageUrl) {
            navPreviewContainer.innerHTML = '<img src="' + imageUrl + '" alt="Preview" style="max-width: 100%; max-height: 100%;">';
            navPreviewContainer.style.display = 'block';
        }
    }

    function hidePreview() {
        navPreviewContainer.style.display = 'none';
    }

    var prevArrow = document.querySelector('.nav-arrow.prev');
    var nextArrow = document.querySelector('.nav-arrow.next');

    if (prevArrow) {
        prevArrow.addEventListener('mouseover', function () {
            showPreview(this.getAttribute('data-prev-image'));
        });
    }

    if (nextArrow) {
        nextArrow.addEventListener('mouseover', function () {
            showPreview(this.getAttribute('data-next-image'));
        });
    }

    // Par défaut, afficher l'image suivante
    if (nextArrow) {
        var nextImageUrl = nextArrow.getAttribute('data-next-image');
        showPreview(nextImageUrl);
    }
});
