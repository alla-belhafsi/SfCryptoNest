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

    // Obtenez la date de début à partir de l'attribut de données
    var startDateStr = document.getElementById("countdown").getAttribute("data-start-date");

    // Convertissez la chaîne de date en un objet Date JavaScript
    var startDateParts = startDateStr.split('/');
    var startDate = new Date(startDateParts[2], startDateParts[1] - 1, startDateParts[0]);

    // Obtenez l'heure de check-in à partir de l'attribut de données
    var checkinTime = document.getElementById("countdown").getAttribute("data-checkin-time");
    var checkinHours = parseInt(checkinTime.split(':')[0]);
    var checkinMinutes = parseInt(checkinTime.split(':')[1]);

    // Ajoutez l'heure de check-in à la date de début
    startDate.setHours(checkinHours);
    startDate.setMinutes(checkinMinutes);
    startDate.setSeconds(0); // Assurez-vous de régler les secondes à zéro pour éviter les imprécisions

    // Mettez à jour le compte à rebours chaque seconde
    var x = setInterval(function() {

      // Obtenez la date et l'heure actuelles
      var now = new Date().getTime();

      // Trouvez la distance entre maintenant et la date de début
      var distance = startDate - now;

      // Calculs de temps pour jours, heures, minutes et secondes
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Affichez le résultat dans l'élément avec id="countdownText"
      document.getElementById("countdownText").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

      // Si le compte à rebours est terminé, écrivez un texte
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdownText").innerHTML = "EXPIRED";
      }
    }, 1000);

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