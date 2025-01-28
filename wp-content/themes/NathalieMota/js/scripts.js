document.addEventListener('DOMContentLoaded', function () {
    // BURGER MENU
    $('#open-fullscreen-menu-button').on('click', function (e) {
        e.stopPropagation();
        $('header').toggleClass('mobile-menu-opened');
    });

    $('#close-fullscreen-menu-button').on('click', function () {
        $('header').removeClass('mobile-menu-opened');
    });

    $(document).on('click', function (event) {
        if (!$('header').has(event.target).length && !$('header').is(event.target)) {
            $('header').removeClass('mobile-menu-opened');
        }
    });

    // HEADER MODAL
    const headerModal = document.getElementById('myModal');
    const headerBtn = document.querySelector('.menu-item-27');
    if (headerModal && headerBtn) {
        headerBtn.addEventListener('click', function (event) {
            event.preventDefault();
            headerModal.style.display = 'block';
        });

        window.addEventListener('click', function (event) {
            if (event.target === headerModal) {
                headerModal.style.display = 'none';
            }
        });
    }

    // PHOTO MODAL
    const photoModal = document.getElementById('myModal-photo');
    const photoBtn = document.getElementById('myBtn-photo');
    if (photoModal && photoBtn) {
        const referenceInput = photoModal.querySelector('input[name="your-subject"]');
        photoBtn.addEventListener('click', function () {
            photoModal.style.display = 'block';
            const referenceText = this.getAttribute('data-reference');
            if (referenceInput) {
                referenceInput.value = referenceText;
            }
        });

        window.addEventListener('click', function (event) {
            if (event.target === photoModal) {
                photoModal.style.display = 'none';
            }
        });
    }

    // LOAD MORE POSTS
    jQuery(function ($) {
        let page = 1;
        $('#load-more-posts').on('click', function () {
            page++;
            loadMorePhotos(page);
        });

        function loadMorePhotos(pageNumber) {
            const ajaxurl = $('#load-more-posts').data('ajaxurl');
            const nonce = $('#load-more-posts').data('nonce');

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_more_photos',
                    page: pageNumber,
                    security: nonce,
                },
                success: function (response) {
                    if (response.success) {
                        $('.thumbnail-container-accueil').append(response.data);
                    } else {
                        $('#load-more-posts').text('No more photos to load').prop('disabled', true);
                    }
                },
                error: function () {
                    alert('Error loading photos.');
                },
            });
        }
    });

    // LIGHTBOX
    let images = [];
    let currentIndex = 0;

    function refreshImagesArray() {
        images = $('.fullscreen-icon').map(function () {
            return {
                src: $(this).data('src'),
                reference: $(this).siblings('.photo-info').find('.photo-info-left p').text(),
                category: $(this).siblings('.photo-info').find('.photo-info-right p').text(),
            };
        }).get();
    }

    function updateLightbox(index) {
        const totalImages = images.length;
        currentIndex = (index + totalImages) % totalImages;
        const imageData = images[currentIndex];

        $('#myLightbox .lightbox__container').html(`<img src="${imageData.src}" alt="Lightbox Image">`);
        $('#myLightbox .photo-info-left-lightbox').html(`<p>${imageData.reference}</p>`);
        $('#myLightbox .photo-info-right-lightbox').html(`<p>${imageData.category}</p>`);
    }

    $(document).on('click', '.fullscreen-icon', function (event) {
        event.preventDefault();
        refreshImagesArray();
        currentIndex = $('.fullscreen-icon').index(this);
        updateLightbox(currentIndex);
        $('#myLightbox').css('display', 'block');
    });

    $('.lightbox__close').on('click', function () {
        $('#myLightbox').css('display', 'none');
    });

    $('.lightbox__prev').on('click', function (event) {
        event.preventDefault();
        updateLightbox(currentIndex - 1);
    });

    $('.lightbox__next').on('click', function (event) {
        event.preventDefault();
        updateLightbox(currentIndex + 1);
    });

    // FILTER POSTS
    jQuery(function ($) {
        function loadFilteredPosts() {
            const category = $('#category-filter-list').val();
            const format = $('#format-filter-list').val(); // Optional format filter
            const sort = $('#date-sort-list').val(); // Optional sorting option
            const ajaxurl = ajax_object.ajax_url; // Use the localized AJAX URL
            const nonce = ajax_object.nonce; // Use the localized nonce for security

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_filtered_posts',
                    categorie: category,
                    format: format,
                    sort: sort,
                },
                success: function (response) {
                    if (response.success) {
                        $('.thumbnail-container-accueil').html(response.data); // Update the photo container with filtered photos
                    } else {
                        $('.thumbnail-container-accueil').html('<p>No photos found.</p>');
                    }
                },
                error: function () {
                    alert('Error loading filtered photos.');
                },
            });
        }

        $('.filter-list select').on('change', function () {
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
