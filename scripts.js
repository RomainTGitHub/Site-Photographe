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
jQuery(document).ready(function ($) {
    var currentPhotoIndex = 0;
    var allPhotos = [];

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
    $(document).on('click', '.lightbox-prev', function () {
        changePhoto(-1);
    });

    $(document).on('click', '.lightbox-next', function () {
        changePhoto(1);
    });

    // Attache un événement de clic au bouton de fermeture de la lightbox
    $('.lightbox-close').on('click', function () {
        closeLightbox();
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
                    // Réinitialiser les photos pour inclure les nouveaux éléments
                    updateVisiblePhotos();
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

// Script pour l'apercu des images au survol des fléches dans la page infophoto.php //

document.addEventListener("DOMContentLoaded", function () {
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