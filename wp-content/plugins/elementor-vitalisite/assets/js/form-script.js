document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".vitalisite-form");

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new URLSearchParams({
                action: form.querySelector('[name="action"]').value,
                nonce: ajax_object.nonce,
                email: form.querySelector('[name="email"]').value,
                message: form.querySelector('[name="message"]').value,
            });

            console.log([...formData])

            fetch(ajax_object.ajaxurl, {
                method: "POST",
                body: formData
            })
                .then(response => response.text()) // Change `json()` en `text()` pour voir tout
                .then(data => console.log("🔍 Réponse brute AJAX :", data))
                .catch(error => console.error("Erreur AJAX :", error));
        });
    }
});
