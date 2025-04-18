document.addEventListener('DOMContentLoaded', function () {
    // Sélectionner tous les boutons de like/unlike
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const action = this.getAttribute('data-action');
            const url = action === 'like' ? `/posts/${postId}/like` : `/posts/${postId}/unlike`;

            // Récupérer le token CSRF depuis le meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Désactiver le bouton pendant la requête
            button.disabled = true;

            // Envoyer la requête AJAX
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    button.disabled = false;

                    if (data.success) {
                        // Mettre à jour le nombre de likes
                        const likesCountElement = document.querySelector(`.likes-count[data-post-id="${postId}"]`);
                        likesCountElement.textContent = `❤️ ${data.likes_count} likes`;

                        // Mettre à jour le bouton
                        if (data.liked) {
                            button.textContent = 'Unlike';
                            button.classList.remove('text-blue-500');
                            button.classList.add('text-red-500');
                            button.setAttribute('data-action', 'unlike');
                        } else {
                            button.textContent = 'Like';
                            button.classList.remove('text-red-500');
                            button.classList.add('text-blue-500');
                            button.setAttribute('data-action', 'like');
                        }

                        // Afficher un message temporaire
                        const message = document.createElement('div');
                        message.textContent = data.message;
                        message.className = 'fixed top-4 right-4 bg-green-500 text-white p-2 rounded';
                        document.body.appendChild(message);
                        setTimeout(() => message.remove(), 2000);
                    } else {
                        alert(data.error || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    button.disabled = false;
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la requête.');
                });
        });
    });
});
