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

    // UNIFIED MODAL HANDLING
    function setupModal(modalId, buttonSelector) {
        let modal = document.getElementById(modalId);
        let button = document.querySelector(buttonSelector);

        if (modal && button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                modal.classList.add('show');
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.remove('show');
                }
            });
        }
    }

    // Apply unified modal function to both modals
    setupModal('myModal', '.menu-item-27'); // Header modal
    setupModal('myModal-photo', '#myBtn-photo'); // Photo modal

    // Ensure "your-subject" input is populated correctly in photo modal
    const photoModal = document.getElementById('myModal-photo');
    const photoBtn = document.getElementById('myBtn-photo');
    if (photoModal && photoBtn) {
        const referenceInput = photoModal.querySelector('input[name="your-subject"]');
        photoBtn.addEventListener('click', function () {
            const referenceText = this.getAttribute('data-reference');
            if (referenceInput) {
                referenceInput.value = referenceText;
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
            const format = $('#format-filter-list').val();
            const sort = $('#date-sort').val();
            const ajaxurl = ajax_object.ajax_url;
            const nonce = ajax_object.nonce;

            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'load_filtered_posts',
                    categorie: category,
                    format: format,
                    sort: sort,
                    nonce: nonce,
                },
                success: function (response) {
                    if (response.success) {
                        $('.thumbnail-container-accueil').html(response.data);
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
