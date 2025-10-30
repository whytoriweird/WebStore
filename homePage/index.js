
document.addEventListener('DOMContentLoaded', function() {
    // Simple search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchText = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.website-card');

            cards.forEach(card => {
                const title = card.querySelector('h2').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchText) || description.includes(searchText)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Add simple hover effects
    const cards = document.querySelectorAll('.website-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});