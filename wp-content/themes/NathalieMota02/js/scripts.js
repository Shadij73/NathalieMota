// Attente que le document soit chargé
document.addEventListener('DOMContentLoaded', function() {

    // BURGER MENU

    // Ouvrir le menu en plein écran
    $('#open-fullscreen-menu-button').click(function(e) {
        e.stopPropagation(); // Empêcher la propagation de l'événement
        $('header').toggleClass('mobile-menu-opened');// Classe pour ouvrir/fermer le menu
        console.log('BOUTON CLIQUÉ!');// Log pour débogage
    });

    // Fermer le menu en plein écran
    $('#close-fullscreen-menu-button').click(function() {
        $('header').removeClass('mobile-menu-opened');// Retirer la classe pour fermer le menu
        console.log('MENU FERMÉ!');// Log pour débogage
    });

    // Fermer le menu si un clic est détecté en dehors de l'élément 'header'    
    $(document).click(function(event) {
        if (!$('header').has(event.target).length && !$('header').is(event.target)) {
            $('header').removeClass('mobile-menu-opened');
        }
    });

    // MODAL HEADER

        var headerModal = document.getElementById('myModal');// Obtenir l'élément modal
        var headerBtn = document.getElementById("open-modal-button-header");// Obtenir le bouton pour ouvrir le modal

        // Ouvrir le modal lorsque le bouton est cliqué
        headerBtn.onclick = function() {
            headerModal.style.display = "block";
        }

        // Fermer le modal si un clic est détecté en dehors de l'élément modal
        window.addEventListener('click', function(event) {
            if (event.target == headerModal) {
                headerModal.style.display = "none";
            }
        });

    // MODAL SINGLE
    if (jQuery('#myBtn-photo').length) {

        var photoModal = document.getElementById('myModal-photo');// Obtenir l'élément modal pour les photos
        var photoBtn = document.getElementById("myBtn-photo");// Obtenir le bouton pour ouvrir le modal photo
        var referenceInput = photoModal.querySelector('input[name="your-subject"]');// Obtenir l'input de référence dans le modal

        // Ouvrir le modal photo et définir la valeur de l'input de référence
        photoBtn.onclick = function() {
            photoModal.style.display = "block";
        
        var referenceText = this.getAttribute('data-reference');
        if (referenceInput) {
            referenceInput.value = referenceText;
            }   
        }

        // Fermer le modal photo si un clic est détecté en dehors de l'élément modal
        window.addEventListener('click', function(event) {
            if (event.target == photoModal) {
                photoModal.style.display = "none";
            }
        });
    }

    // PHOTO NAV SINGLE

        if ($('.right-container').length) {
            const wrapper = document.querySelector('.thumbnail-wrapper');// Obtenir le conteneur des vignettes
            const prevArrowLink = document.getElementById('prev-arrow-link');// Obtenir le lien de la flèche précédente
            const nextArrowLink = document.getElementById('next-arrow-link');// Obtenir le lien de la flèche suivante

            const currentThumbnailURL = document.querySelector('.right-container a.photo img').getAttribute('src');// URL de la vignette actuelle
            const currentThumbnailPreloader = new Image();

            currentThumbnailPreloader.src = currentThumbnailURL;// Préchargement de la vignette actuelle
            currentThumbnailPreloader.onload = function () {
                preloadCurrentThumbnail(currentThumbnailURL);
            };

            // Fonctions pour charger et précharger les vignettes
            function loadThumbnail(thumbnailURL) {
                const thumbnail = document.createElement('img');
                thumbnail.src = thumbnailURL;

                while (wrapper.firstChild) {
                    wrapper.removeChild(wrapper.firstChild);
                }

                wrapper.appendChild(thumbnail);
            }

            function preloadCurrentThumbnail(thumbnailURL) {
                loadThumbnail(thumbnailURL);
            }

            // Gestion des événements de survol pour prévisualiser les vignettes
            function handleMouseover(direction) {
                const arrowLink = (direction === 'prev') ? prevArrowLink : nextArrowLink;
                const thumbnailURL = arrowLink.getAttribute('data-thumbnail');
                loadThumbnail(thumbnailURL);
            }

            function handleMouseout() {
                preloadCurrentThumbnail(currentThumbnailURL);
            }

            window.addEventListener('load', () => preloadCurrentThumbnail(currentThumbnailURL));

            prevArrowLink.addEventListener('mouseover', () => handleMouseover('prev'));
            nextArrowLink.addEventListener('mouseover', () => handleMouseover('next'));
            prevArrowLink.addEventListener('mouseout', handleMouseout);
            nextArrowLink.addEventListener('mouseout', handleMouseout);
        }    
    
    // LOAD MORE 
    jQuery(document).ready(function($) {
        var page = 1;// Initialiser le numéro de page

        // Gérer le clic sur le bouton pour charger plus de contenus
        $('#load-more-posts').on('click', function() {
            page++;// Incrémenter le numéro de page
            loadMorePosts(page);// Charger plus de contenus
        });

        // Fonction pour charger plus de contenus
        function loadMorePosts(pageNumber) {
            var ajaxurl = $('#load-more-posts').data('ajaxurl'); // URL pour la requête AJAX              
            var nonce = $('#load-more-posts').data('nonce');// Nonce pour la sécurité

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: pageNumber,
                    security: nonce
                },
                success: function(data) {
                    if (data) {
                        $('.thumbnail-container-accueil').append(data);// Ajouter les contenus chargés
                    } else {
                        $('#load-more-posts').text('Aucune photo supplémentaire à charger');// Modifier le texte si aucun contenu supplémentaire
                    }
                }
            });
        }
    });

    // LIGHTBOX

    $(document).ready(function() {

        // Ouvrir le lightbox au clic sur l'icône de plein écran
        $(document).on('click', '.fullscreen-icon', function(event) {
            event.preventDefault(); 
            event.stopPropagation();
    
            refreshImagesArray(); // Rafraîchir le tableau d'images
    
            currentIndex = $('.fullscreen-icon').index(this);// Obtenir l'index de l'image cliquée
            updateLightbox(currentIndex); // Mettre à jour le lightbox avec l'image correspondante
    
            $('#myLightbox').css('display', 'block'); // Afficher le lightbox
        });
    
        var currentIndex = 0; // Index de l'image actuelle
        var images = []; // Tableau des images 
    
        // Rafraîchir le tableau d'images
        function refreshImagesArray() {
            images = $('.fullscreen-icon').map(function() {
                return {
                    src: $(this).data('src'),// Source de l'image
                    reference: $(this).siblings('.photo-info').find('.photo-info-left p').text(),// Référence de l'image
                    category: $(this).siblings('.photo-info').find('.photo-info-right p').text()// Catégorie de l'image
                };
            }).get();
        }
    
        // Mettre à jour le lightbox avec l'image, la référence et la catégorie correspondantes
        function updateLightbox(index) {
            currentIndex = ((index % images.length) + images.length) % images.length; // Calculer l'index actuel
            var imageData = images[currentIndex]; // Obtenir les données de l'image
    
            $('#myLightbox .lightbox__container').html('<img src="' + imageData.src + '">');// Mettre à jour l'image dans le lightbox
            $('#myLightbox .photo-info-left-lightbox').html('<p>' + imageData.reference + '</p>');// Mettre à jour la référence
            $('#myLightbox .photo-info-right-lightbox').html('<p>' + imageData.category + '</p>');// Mettre à jour la catégorie
        }
    
        // Fermer le lightbox
        $('.lightbox__close').click(function() {
            $('#myLightbox').css('display', 'none'); 
        });
    
         // Naviguer vers l'image précédente
        $('.lightbox__prev').click(function(event) {
            event.preventDefault();
            updateLightbox(currentIndex - 1); 
        });
    
        // Naviguer vers l'image suivante
        $('.lightbox__next').click(function(event) {
            event.preventDefault();
            updateLightbox(currentIndex + 1); 
        });
    });
            
    // FILTRE

    jQuery(document).ready(function($) {

        // Fonction pour charger les contenus filtrés
        function loadFilteredPosts() {

            var category = $('#category-filter-list .selected').data('value');// Obtenir la catégorie sélectionnée
            var format = $('#format-filter-list .selected').data('value');// Obtenir le format sélectionné
            var sort = $('#date-sort-list .selected').data('value');// Obtenir le tri sélectionné
            var page = 1;// Initialiser le numéro de page
            var ajaxurl = $('#load-more-posts').data('ajaxurl');// URL pour la requête AJAX
            var nonce = $('#load-more-posts').data('nonce');// Nonce pour la sécurité
    
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_filtered_posts',// Action pour filtrer les contenus
                    category: category,// Catégorie sélectionnée
                    format: format,// Format sélectionné
                    sort: sort,// Tri sélectionné
                    page: page,// Numéro de page
                    security: nonce// Nonce pour la sécurité
                },
                success: function(data) {
                    $('.thumbnail-container-accueil').html(data); // Mettre à jour les contenus affichés
                    $('#load-more-posts').data('page', 1); // Réinitialiser le numéro de page
                }
            });
        }

        // Gérer le clic sur un élément de la liste des filtres
        $('.filter-list li').on('click', function() {

            $(this).siblings().removeClass('selected'); // Désélectionner les autres éléments
            $(this).addClass('selected'); // Sélectionner l'élément cliqué
    
            loadFilteredPosts(); // Charger les contenus filtrés

            var selectedText = $(this).text(); // Obtenir le texte de l'élément sélectionné
            var $filterContainer = $(this).closest('.filter-list').find('.filter-container p'); // Obtenir le conteneur du filtre

            // Mettre à jour le texte du conteneur du filtre en fonction de la sélection
            if ($(this).data('value') === 'ALL') {
                if($(this).closest('.filter-list').attr('id') === 'category-filter-list') {
                    $filterContainer.text('Catégories');
                } else if($(this).closest('.filter-list').attr('id') === 'format-filter-list') {
                    $filterContainer.text('Formats'); 
                }
            } else {
                $filterContainer.text(selectedText);
            }
        });
    });

        // Gérer le clic sur le conteneur du filtre ou l'icône du chevron
        $('.filter-container, .chevron-icon').click(function(event) {
            var $filterList = $(this).closest('.filter-list'); // Obtenir la liste des filtres
            $filterList.toggleClass('open'); // Basculer l'ouverture de la liste
            event.stopPropagation();
    
            var $chevron = $filterList.find('.chevron-icon'); // Obtenir l'icône du chevron
            // Basculer la rotation de l'icône du chevron en fonction de l'ouverture de la liste
            $chevron.css('transform', $filterList.hasClass('open') ? 'rotate(180deg)' : 'rotate(0deg)');
        });
    
        // Fermer les listes des filtres si un clic est détecté en dehors
        $(document).click(function() {
            $('.filter-list').removeClass('open');
            $('.chevron-icon').css('transform', '');
        });
});   
        
//Modal 
document.addEventListener('DOMContentLoaded', function () {
    // Get the modal element
    var headerModal = document.getElementById('myModal');
    if (!headerModal) {
        console.error('Modal element not found.');
        return;
    }

    // Select the Contact menu item
    var contactMenuItem = document.querySelector('.menu-item-27');

    if (contactMenuItem) {
        // Add a click event listener to the menu item
        contactMenuItem.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent navigation
            headerModal.style.display = 'block'; // Show the modal
        });
    }

    // Close the modal when clicking outside the modal content
    window.addEventListener('click', function (event) {
        if (event.target === headerModal) {
            headerModal.style.display = 'none'; // Hide the modal
        }
    });
});
