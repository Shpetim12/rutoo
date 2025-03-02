document.addEventListener('DOMContentLoaded', function() {
    const watchButton = document.querySelector('.watch-button'); // Adjust this to match your button's class

    if (watchButton) {
        watchButton.addEventListener('click', function() {
            const episodeId = watchButton.dataset.episodeId;

            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'save_last_watched_episode',
                    episode_id: episodeId
                })
            }).then(response => response.json())
              .then(data => {
                  console.log(data.message || 'Episode saved.');
              });
        });
    }
});
