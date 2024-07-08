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

// Script pour le menu hamburger //

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

// Script pour la lightbox //

let currentSlideIndex = 0;
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const lightboxReference = document.getElementById('lightbox-reference');
const lightboxCategory = document.getElementById('lightbox-category');

let visiblePhotos = [];

function openLightbox(index) {
    currentSlideIndex = index;
    const photo = visiblePhotos[currentSlideIndex];
    lightboxImg.src = photo.fullUrl;
    lightboxReference.textContent = photo.reference;
    lightboxCategory.textContent = photo.category;
    lightbox.style.display = 'flex';
}

function closeLightbox() {
    lightbox.style.display = 'none';
}

function changeSlide(n) {
    currentSlideIndex += n;
    if (currentSlideIndex < 0) {
        currentSlideIndex = visiblePhotos.length - 1;
    } else if (currentSlideIndex >= visiblePhotos.length) {
        currentSlideIndex = 0;
    }
    openLightbox(currentSlideIndex);
}

function attachLightboxEvents() {
    document.querySelectorAll('.open-lightbox').forEach((button, index) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openLightbox(parseInt(button.dataset.index));
        });
    });
}


// Script pour la navigation dans la lightbox //
jQuery(document).ready(function ($) {
    var currentPhotoIndex = 0;

    // Fonction pour ouvrir la lightbox
    function openLightbox(index) {
        var photo = allPhotos[index];
        $('#lightbox-img').attr('src', photo.fullUrl);
        $('#lightbox-reference').text(photo.reference);
        $('#lightbox-category').text(photo.category);
        $('#lightbox').fadeIn();
        currentPhotoIndex = index;
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        $('#lightbox').fadeOut();
    }

    // Fonction pour changer la photo dans la lightbox
    function changePhoto(direction) {
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

    // Attache des événements de clic aux boutons de navigation de la lightbox
    $('.lightbox-prev').on('click', function () {
        changePhoto(-1);
    });

    $('.lightbox-next').on('click', function () {
        changePhoto(1);
    });

    // Attache un événement de clic au bouton de fermeture de la lightbox
    $('.lightbox-close').on('click', function () {
        closeLightbox();
    });

    // Initialise les photos
    function initializePhotos() {
        allPhotos.forEach(function (photo, index) {
            $('.open-lightbox').eq(index).data('index', index); // Assigne l'index de chaque photo
        });
    }
    initializePhotos(); // Appel initial pour les photos chargées au départ

    // Script pour le bouton charger plus de la galerie photo
    var loadMoreButton = document.getElementById('load-more');
    var galleryGrid = document.getElementById('gallery-grid');
    var page = 1;

    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', function () {
            page++;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/wp-admin/admin-ajax.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var response = xhr.responseText;
                    var tempDiv = document.createElement('div');
                    tempDiv.innerHTML = response;
                    var newItems = tempDiv.querySelectorAll('.related-photo-card');
                    newItems.forEach(function (item) {
                        galleryGrid.appendChild(item);
                    });
                    if (newItems.length < 8) {
                        loadMoreButton.style.display = 'none';
                    }
                    // Reattach lightbox events to new items
                    initializePhotos(); // Réinitialise les photos pour inclure les nouveaux éléments
                } else {
                    console.error(xhr.statusText);
                }
            };

            xhr.onerror = function () {
                console.error(xhr.statusText);
            };

            xhr.send('action=load_more_photos&page=' + page);
        });
    }
});

// Initialisation des photos et des événements de la lightbox
function initializePhotos() {
    visiblePhotos = allPhotos;
    document.querySelectorAll('.open-lightbox').forEach((button, index) => {
        button.dataset.index = index;
    });
    attachLightboxEvents(); // Réattacher les événements de la lightbox aux nouvelles photos
}
initializePhotos(); // Initialiser les photos visibles

// Fonction pour attacher les événements de la lightbox
function attachLightboxEvents() {
    document.querySelectorAll('.open-lightbox').forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            openLightbox(parseInt(button.getAttribute('data-index')));
        });
    });
}

attachLightboxEvents();