/**
 * AJAX Blog/Archive filtering
 * Replaces the query grid without a full page reload.
 */
document.addEventListener("DOMContentLoaded", () => {
  const attachFilterEvents = () => {
    document.body.addEventListener("click", (e) => {
      const catLink = e.target.closest(".vitalisite-blog-categories a");
      const pageLink = e.target.closest(".wp-block-query-pagination a");

      // Si on ne clique ni sur une catégorie ni sur une pagination de blog, on sort
      if (!catLink && !pageLink) return;

      // Vérifier qu'on est bien sur un template de listing blog
      const gridContainer = document.querySelector(".vitalisite-blog-grid");
      if (!gridContainer) return;

      e.preventDefault();
      const link = catLink || pageLink;
      const url = link.href;

      // Ajouter un état de chargement visuel
      gridContainer.style.opacity = "0.5";
      gridContainer.style.pointerEvents = "none";

      fetch(url)
        .then((response) => response.text())
        .then((html) => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, "text/html");

          const newGrid = doc.querySelector(".vitalisite-blog-grid");
          const newHeader = doc.querySelector(".vitalisite-blog-header");

          if (newGrid) {
            // Remplacer uniquement la grille de résultats
            gridContainer.innerHTML = newGrid.innerHTML;
            gridContainer.style.opacity = "1";
            gridContainer.style.pointerEvents = "auto";

            // Remplacer l'en-tête (Titre dynamique Category: XYZ, liste catégories avec classe active)
            const currentHeader = document.querySelector(
              ".vitalisite-blog-header",
            );
            if (currentHeader && newHeader) {
              currentHeader.innerHTML = newHeader.innerHTML;
            }

            // Mettre à jour l'URL sans recharger
            history.pushState(null, "", url);

            // Scroll to top of the grid smoothly
            window.scrollTo({
              top:
                document.querySelector(".vitalisite-blog-listing").offsetTop -
                100,
              behavior: "smooth",
            });
          } else {
            throw new Error("Grille introuvable dans la réponse");
          }
        })
        .catch((err) => {
          console.error("Erreur AJAX filter:", err);
          gridContainer.style.opacity = "1";
          gridContainer.style.pointerEvents = "auto";
          window.location.href = url; // Fallback classique
        });
    });
  };

  attachFilterEvents();
});
