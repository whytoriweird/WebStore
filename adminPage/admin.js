document.addEventListener('DOMContentLoaded', function() {
    // Handle website form submission
    const addWebsiteForm = document.querySelector('.add-website form');
    if (addWebsiteForm) {
        addWebsiteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!confirm('Додати новий сайт?')) return;
            this.submit();
        });
    }

    // Handle website status toggle
    const toggleButtons = document.querySelectorAll('.btn-toggle');
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const websiteId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            
            if (confirm(`${currentStatus === '1' ? 'Деактивувати' : 'Активувати'} сайт?`)) {
                window.location.href = this.href;
            }
        });
    });

    // Simple search functionality
    const searchInput = document.querySelector('#searchWebsites');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('table tr:not(:first-child)');

            rows.forEach(row => {
                const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                row.style.display = name.includes(searchText) ? '' : 'none';
            });
        });
    }
});