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
        var imageInput = document.getElementById('article-edit-image');
        var categorySelect = document.getElementById('article-edit-categorie');

        openArticleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var id = button.getAttribute('data-id') || '';
                titleInput.value = button.getAttribute('data-titre') || '';
                contentInput.value = button.getAttribute('data-contenu') || '';
                dateInput.value = button.getAttribute('data-date') || '';
                imageInput.value = button.getAttribute('data-image') || '';
                categorySelect.value = button.getAttribute('data-categorie') || '';
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
