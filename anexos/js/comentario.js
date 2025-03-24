function deleteComment(commentId) {
    if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
        fetch('auth_comen/eliminar_comentario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + commentId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar el comentario');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el comentario');
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.comments-form');

    if (form) {
        form.addEventListener('submit', function (e) {
            const comentario = form.querySelector('#comentario')?.value.trim();
            const tipo = form.querySelector('#tipo_comentario')?.value;

            if (!comentario || !tipo) {
                e.preventDefault();
                alert('Por favor completa los campos requeridos');
            }
        });
    }
});

function toggleFaq(index) {
    const answer = document.getElementById(`faq-answer-${index}`);
    const questions = document.querySelectorAll('.faq-question');
    const answers = document.querySelectorAll('.faq-answer');

    if (!answer || !questions[index]) return;

    // Cerrar todas las respuestas excepto la actual
    answers.forEach((ans, i) => {
        if (i !== index) {
            ans.classList.remove('active');
            questions[i]?.classList.remove('active');
        }
    });

    // Alternar la visibilidad de la respuesta actual
    answer.classList.toggle('active');
    questions[index].classList.toggle('active');
}