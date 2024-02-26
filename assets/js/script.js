document.addEventListener('DOMContentLoaded', function () {
    // Récupérez tous les éléments de type checkbox (les boutons de menu)
    var menuToggles = document.querySelectorAll('.menu-toggle');
    // Ajoutez un écouteur d'événements à chaque bouton
    menuToggles.forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            // Fermez tous les autres menus déroulants
            menuToggles.forEach(function (otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.checked = false;
                }
            });
        });
    });
});