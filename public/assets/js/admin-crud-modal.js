document.addEventListener('DOMContentLoaded', function () {
    var pathParts = window.location.pathname.split('/admin/');
    var appBaseUrl = window.location.origin + (pathParts[0] || '');

    var articleModal = document.getElementById('article-edit-modal');
    var articleForm = document.getElementById('article-edit-form');

    function openModal(modal) {
        if (!modal) {
            return;
        }
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal(modal) {
        if (!modal) {
            return;
        }
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');

        if (modal.id === 'image-lightbox-modal') {
            var img = document.getElementById('lightbox-image');
            if (img) {
                img.setAttribute('src', '');
            }
        }
    }

    document.querySelectorAll('.js-open-modal').forEach(function (button) {
        button.addEventListener('click', function () {
            var targetId = button.getAttribute('data-target-modal');
            if (!targetId) {
                return;
            }
            var modal = document.getElementById(targetId);
            if (!modal) {
                return;
            }

            var createForm = modal.querySelector('form');
            if (createForm) {
                createForm.reset();
            }

            openModal(modal);
        });
    });

    if (articleModal && articleForm) {
        var openArticleButtons = document.querySelectorAll('.js-open-article-modal');
        var titleInput = document.getElementById('article-edit-titre');
        var contentInput = document.getElementById('article-edit-contenu');
        var dateInput = document.getElementById('article-edit-date');
        var categorySelect = document.getElementById('article-edit-categorie');
        var primaryPreview = document.getElementById('article-edit-primary-preview');
        var secondaryPreview = document.getElementById('article-edit-secondary-preview');

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        openArticleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = button.getAttribute('data-id') || '';
                articleForm.reset();
                titleInput.value = button.getAttribute('data-titre') || '';
                contentInput.value = button.getAttribute('data-contenu') || '';
                dateInput.value = button.getAttribute('data-date') || '';
                categorySelect.value = button.getAttribute('data-categorie') || '';

                var primaryImage = button.getAttribute('data-primary-image') || '';
                if (primaryPreview) {
                    if (primaryImage) {
                        primaryPreview.classList.remove('text-muted');
                        primaryPreview.innerHTML = '<img src="' + escapeHtml(primaryImage) + '" alt="Image primaire actuelle" class="existing-image-thumb">';
                    } else {
                        primaryPreview.classList.add('text-muted');
                        primaryPreview.textContent = 'Aucune image primaire';
                    }
                }

                if (secondaryPreview) {
                    var secondaryRaw = button.getAttribute('data-secondary-images') || '[]';
                    var secondaryImages = [];

                    try {
                        secondaryImages = JSON.parse(secondaryRaw);
                    } catch (e) {
                        secondaryImages = [];
                    }

                    if (Array.isArray(secondaryImages) && secondaryImages.length > 0) {
                        secondaryPreview.classList.remove('text-muted');
                        secondaryPreview.innerHTML = secondaryImages.map(function (src) {
                            return '<img src="' + escapeHtml(src) + '" alt="Image secondaire actuelle" class="existing-image-thumb">';
                        }).join('');
                    } else {
                        secondaryPreview.classList.add('text-muted');
                        secondaryPreview.textContent = 'Aucune image secondaire';
                    }
                }

                articleForm.setAttribute('action', appBaseUrl + '/admin/articles/update/' + id);
                openModal(articleModal);
            });
        });
    }

    var categoryModal = document.getElementById('category-edit-modal');
    var categoryForm = document.getElementById('category-edit-form');

    if (categoryModal && categoryForm) {
        var openCategoryButtons = document.querySelectorAll('.js-open-category-modal');
        var labelInput = document.getElementById('category-edit-libelle');

        openCategoryButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = button.getAttribute('data-id') || '';
                labelInput.value = button.getAttribute('data-libelle') || '';
                categoryForm.setAttribute('action', appBaseUrl + '/admin/categories/update/' + id);
                openModal(categoryModal);
            });
        });
    }

    var lightboxModal = document.getElementById('image-lightbox-modal');
    var lightboxImage = document.getElementById('lightbox-image');

    if (lightboxModal && lightboxImage) {
        document.querySelectorAll('.js-open-lightbox').forEach(function (button) {
            button.addEventListener('click', function () {
                var src = button.getAttribute('data-image-src') || '';
                if (!src) {
                    return;
                }
                lightboxImage.setAttribute('src', src);
                openModal(lightboxModal);
            });
        });
    }

    document.querySelectorAll('[data-close-modal]').forEach(function (button) {
        button.addEventListener('click', function () {
            closeModal(button.closest('.modal-overlay'));
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeModal(overlay);
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }
        document.querySelectorAll('.modal-overlay.is-open').forEach(function (modal) {
            closeModal(modal);
        });
    });
});
