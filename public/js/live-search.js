document.addEventListener('DOMContentLoaded', function() {
    // Fonction générique pour la recherche en temps réel
    function initializeLiveSearch(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return;

        const inputs = form.querySelectorAll('input[type="text"]');
        const loadingIndicator = createLoadingIndicator();
        form.appendChild(loadingIndicator);

        let debounceTimer;

        inputs.forEach(input => {
            // Ajout des tooltips
            input.setAttribute('data-toggle', 'tooltip');
            input.setAttribute('data-placement', 'top');
            input.setAttribute('title', 'Commencez à taper pour rechercher');

            input.addEventListener('input', function() {
                loadingIndicator.style.display = 'inline-block';
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    performSearch(form, loadingIndicator);
                }, 500);
            });
        });
    }

    // Création de l'indicateur de chargement
    function createLoadingIndicator() {
        const spinner = document.createElement('div');
        spinner.className = 'search-spinner';
        spinner.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        spinner.style.display = 'none';
        return spinner;
    }

    // Fonction pour effectuer la recherche AJAX
    function performSearch(form, loadingIndicator) {
        const formData = new FormData(form);
        const searchParams = new URLSearchParams(formData);
        const url = `${form.action}?${searchParams.toString()}`;

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                const tableContainer = document.querySelector('.table-responsive');
                tableContainer.innerHTML = html;
                loadingIndicator.style.display = 'none';
                initializeTooltips();
            })
            .catch(error => {
                console.error('Erreur lors de la recherche:', error);
                loadingIndicator.style.display = 'none';
            });
    }

    // Initialisation des tooltips
    function initializeTooltips() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Initialisation pour chaque module
    initializeLiveSearch('#users-search-form');
    initializeLiveSearch('#schools-search-form');
    initializeLiveSearch('#options-search-form');
    initializeLiveSearch('#classes-search-form');
    initializeLiveSearch('#promotions-search-form');
});
