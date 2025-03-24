document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPedidos');
    const pedidoCards = document.querySelectorAll('.pedido-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        pedidoCards.forEach(card => {
            const pedidoNumero = card.querySelector('h2').textContent.toLowerCase();
            if (pedidoNumero.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});