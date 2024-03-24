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

    // // Fonction pour afficher la carte
    // function showMap() {
    //     var geocoder = new google.maps.Geocoder();
    //     var address = '{{booking.property.address}}, {{booking.property.zip}}, {{booking.property.city}}, {{booking.property.country}}';

    //     geocoder.geocode({ 'address': address }, function(results, status) {
    //         if (status === 'OK') {
    //             var map = new google.maps.Map(document.getElementById('map'), {
    //                 zoom: 15,
    //                 center: results[0].geometry.location
    //             });

    //             var marker = new google.maps.Marker({
    //                 map: map,
    //                 position: results[0].geometry.location
    //             });
    //         } else {
    //             alert('La géolocalisation de cette adresse a échoué : ' + status);
    //         }
    //     });
    // }

    // // Appel de la fonction showMap lors du clic sur le lien "Voir sur la carte"
    // function showMap() {
    //     initMap();
    // }


});
