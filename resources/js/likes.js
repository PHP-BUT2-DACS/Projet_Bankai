document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const action = this.getAttribute('data-action');
            const url = action === 'like' ? `/posts/${postId}/like` : `/posts/${postId}/unlike`;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            button.disabled = true;

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
                        // ✅ Mettre à jour uniquement le chiffre
                        const likesCountElement = document.querySelector(`.likes-count[data-post-id="${postId}"]`);
                        likesCountElement.textContent = `${data.likes_count}`;

                        // ✅ Ne rien changer sauf les couleurs + data-action
                        button.setAttribute('data-action', data.liked ? 'unlike' : 'like');
                        button.classList.toggle('text-red-500', data.liked);
                        button.classList.toggle('text-gray-400', !data.liked);

                        // ✅ Le cœur reste le même
                        button.innerHTML = '❤️';
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
