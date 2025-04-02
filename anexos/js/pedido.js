function cambiarEstado(id, estadoActual) {
    const nuevoEstado = estadoActual == 1 ? 0 : 1;
    fetch('actualizar_estado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `pedido_id=${id}&estado=${nuevoEstado}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        }
    });
}
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
