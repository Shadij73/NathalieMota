document.addEventListener('DOMContentLoaded', function () {

    // MENU BURGER
    $('#open-fullscreen-menu-button').on('click', function (e) {
        e.stopPropagation(); // Empêcher la propagation de l'événement
        $('header').toggleClass('mobile-menu-opened'); // Basculer l'ouverture/fermeture du menu
        console.log('Bouton cliqué!'); // Journal pour débogage
    });

    $('#close-fullscreen-menu-button').on('click', function () {
        $('header').removeClass('mobile-menu-opened'); // Fermer le menu
        console.log('Menu fermé!'); // Journal pour débogage
    });

    $(document).on('click', function (event) {
        if (!$('header').has(event.target).length && !$('header').is(event.target)) {
            $('header').removeClass('mobile-menu-opened'); // Fermer le menu si un clic est détecté en dehors
        }
    });

    // MODAL HEADER
    const headerModal = document.getElementById('myModal');
    const headerBtn = document.getElementById('open-modal-button-header');

    if (headerModal && headerBtn) {
        headerBtn.addEventListener('click', function () {
            headerModal.style.display = 'block'; // Afficher le modal
        });

        window.addEventListener('click', function (event) {
            if (event.target === headerModal) {
                headerModal.style.display = 'none'; // Masquer le modal si un clic est détecté en dehors
            }
        });
    }

    // MODAL UNIQUE
    const photoModal = document.getElementById('myModal-photo');
    const photoBtn = document.getElementById('myBtn-photo');
    if (photoModal && photoBtn) {
        const referenceInput = photoModal.querySelector('input[name="your-subject"]');
        photoBtn.addEventListener('click', function () {
            photoModal.style.display = 'block'; // Afficher le modal photo
            const referenceText = this.getAttribute('data-reference');
            if (referenceInput) {
                referenceInput.value = referenceText; // Définir la valeur de l'entrée de référence
            }
        });

        window.addEventListener('click', function (event) {
            if (event.target === photoModal) {
                photoModal.style.display = 'none'; // Masquer le modal si un clic est détecté en dehors
            }
        });
    }

    // NAVIGATION PHOTO
    const rightContainer = document.querySelector('.right-container');
    if (rightContainer) {
        const wrapper = document.querySelector('.thumbnail-wrapper');
        const prevArrowLink = document.getElementById('prev-arrow-link');
        const nextArrowLink = document.getElementById('next-arrow-link');
        const currentThumbnailURL = document.querySelector('.right-container a.photo img').getAttribute('src');
        const currentThumbnailPreloader = new Image();

        currentThumbnailPreloader.src = currentThumbnailURL;
        currentThumbnailPreloader.onload = () => preloadCurrentThumbnail(currentThumbnailURL);

        function loadThumbnail(thumbnailURL) {
            wrapper.innerHTML = ''; // Effacer les vignettes existantes
            const thumbnail = document.createElement('img');
            thumbnail.src = thumbnailURL;
            wrapper.appendChild(thumbnail);
        }

        function preloadCurrentThumbnail(thumbnailURL) {
            loadThumbnail(thumbnailURL);
        }

        function handleMouseover(direction) {
            const arrowLink = direction === 'prev' ? prevArrowLink : nextArrowLink;
            const thumbnailURL = arrowLink.getAttribute('data-thumbnail');
            loadThumbnail(thumbnailURL);
        }

        function handleMouseout() {
            preloadCurrentThumbnail(currentThumbnailURL);
        }

        prevArrowLink.addEventListener('mouseover', () => handleMouseover('prev'));
        nextArrowLink.addEventListener('mouseover', () => handleMouseover('next'));
        prevArrowLink.addEventListener('mouseout', handleMouseout);
        nextArrowLink.addEventListener('mouseout', handleMouseout);
    }

    // CHARGER PLUS DE POSTS
    jQuery(function ($) {
        let page = 1;

        $('#load-more-posts').on('click', function () {
            page++;
            loadMorePosts(page);
        });

        function loadMorePosts(pageNumber) {
            const ajaxurl = $('#load-more-posts').data('ajaxurl');
            const nonce = $('#load-more-posts').data('nonce');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: pageNumber,
                    security: nonce,
                },
                success: function (data) {
                    if (data) {
                        $('.thumbnail-container-accueil').append(data);
                    } else {
                        $('#load-more-posts').text('Aucune photo supplémentaire à charger');
                    }
                },
            });
        }
    });

    // LIGHTBOX
    $(document).on('click', '.fullscreen-icon', function (event) {
        event.preventDefault();
        event.stopPropagation();

        refreshImagesArray(); // Rafraîchir le tableau d'images
        currentIndex = $('.fullscreen-icon').index(this); // Définir l'index actuel en fonction de l'icône cliquée
        updateLightbox(currentIndex); // Mettre à jour le lightbox pour afficher l'image cliquée
        $('#myLightbox').css('display', 'block'); // Afficher le lightbox
    });

    let images = []; // Tableau pour stocker les images
    let currentIndex = 0; // Index actuel du lightbox

    // Fonction pour rafraîchir le tableau d'images
    function refreshImagesArray() {
        images = $('.fullscreen-icon').map(function () {
            return {
                src: $(this).data('src'), // Source de l'image
                reference: $(this).siblings('.photo-info').find('.photo-info-left p').text(), // Référence de l'image
                category: $(this).siblings('.photo-info').find('.photo-info-right p').text(), // Catégorie de l'image
            };
        }).get();
    }

    // Fonction pour mettre à jour le lightbox avec l'image actuelle
    function updateLightbox(index) {
        const totalImages = images.length; // Nombre total d'images
        currentIndex = (index + totalImages) % totalImages; // Assurer que l'index tourne en boucle
        const imageData = images[currentIndex]; // Obtenir les données de l'image actuelle

        // Mettre à jour le contenu du lightbox
        $('#myLightbox .lightbox__container').html(`<img src="${imageData.src}" alt="Lightbox Image">`);
        $('#myLightbox .photo-info-left-lightbox').html(`<p>${imageData.reference}</p>`);
        $('#myLightbox .photo-info-right-lightbox').html(`<p>${imageData.category}</p>`);
    }

    // Écouteur pour fermer le lightbox
    $('.lightbox__close').on('click', function () {
        $('#myLightbox').css('display', 'none'); // Masquer le lightbox
    });

    // Écouteur pour naviguer vers l'image précédente
    $('.lightbox__prev').on('click', function (event) {
        event.preventDefault();
        updateLightbox(currentIndex - 1); // Passer à l'image précédente
    });

    // Écouteur pour naviguer vers l'image suivante
    $('.lightbox__next').on('click', function (event) {
        event.preventDefault();
        updateLightbox(currentIndex + 1); // Passer à l'image suivante
    });

    // FILTRER LES POSTS
    jQuery(function ($) {
        function loadFilteredPosts() {
            const category = $('#category-filter-list .selected').data('value');
            const format = $('#format-filter-list .selected').data('value');
            const sort = $('#date-sort-list .selected').data('value');
            const ajaxurl = $('#load-more-posts').data('ajaxurl');
            const nonce = $('#load-more-posts').data('nonce');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_filtered_posts',
                    category,
                    format,
                    sort,
                    security: nonce,
                },
                success: function (data) {
                    $('.thumbnail-container-accueil').html(data);
                },
            });
        }

        $('.filter-list select').on('change', function () {
            $(this).siblings().removeClass('selected');
            $(this).addClass('selected');
            loadFilteredPosts();
        });

        $('.filter-container, .chevron-icon').on('click', function (event) {
            const $filterList = $(this).closest('.filter-list');
            $filterList.toggleClass('open');
            event.stopPropagation();
        });

        $(document).on('click', function () {
            $('.filter-list').removeClass('open');
        });
    });
});

// Modal
document.addEventListener('DOMContentLoaded', function () {
    const headerModal = document.getElementById('myModal');
    if (!headerModal) {
        console.error('Élément modal introuvable.');
        return;
    }

    const contactMenuItem = document.querySelector('.menu-item-27');

    if (contactMenuItem) {
        contactMenuItem.addEventListener('click', function (event) {
            event.preventDefault(); // Empêcher la navigation
            headerModal.style.display = 'block'; // Afficher le modal
        });
    }

    window.addEventListener('click', function (event) {
        if (event.target === headerModal) {
            headerModal.style.display = 'none'; // Masquer le modal
        }
    });
});
