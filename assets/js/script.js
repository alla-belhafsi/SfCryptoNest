// Attend que le DOM soit chargé avant d'exécuter le script
document.addEventListener('DOMContentLoaded', function () {
    
    // Gestion des menus déroulants
    var menuToggles = document.querySelectorAll('.menu-toggle');

    // Ajoute un écouteur d'événements à chaque bouton de menu déroulant
    menuToggles.forEach(function (toggle) {
        toggle.addEventListener('change', function () {
            // Ferme tous les autres menus déroulants lorsque l'un est activé
            menuToggles.forEach(function (otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.checked = false;
                }
            });
        });
    });

    // Gestion des rôles
    var roles = document.querySelectorAll('.user-role-box');
    roles.forEach(function (role) {
        let roleType = role.getAttribute('data-role').toLowerCase();
        switch (roleType) {
            case 'role_admin':
                role.style.backgroundColor = '#000';
                role.style.color = '#AD8D29';
                role.style.border = '3px groove #AD8D29';
                break;
            case 'role_user':
                role.style.backgroundColor = '#252525';
                role.style.color = '#7B83EB';
                role.style.border = '3px groove #5059C9';
                break;
            case 'role_host':
                role.style.backgroundColor = '#252525';
                role.style.color = '#FF9370';
                role.style.border = '3px groove #FF9370';
                break;
        }
    });

    // Gestion de l'icône des utilisateurs
    // var usersIcon = document.querySelector('.fa-users');
    // var userTable = document.querySelector('.user-container');

    // Ajoute un écouteur d'événements au clic sur l'icône des utilisateurs
    // usersIcon.addEventListener('click', function () {
    //     // Bascule la classe 'hidden' pour afficher ou masquer la table des utilisateurs
    //     userTable.classList.toggle('hidden');
    // });
});       