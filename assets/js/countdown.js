// document.addEventListener("DOMContentLoaded", function() {
//     // Vérifier si l'élément countdown existe
//     var countdownElement = document.getElementById("countdown");
//     if (countdownElement) {
//         // Obtenez la date de début à partir de l'attribut de données
//         var startDateStr = countdownElement.getAttribute("data-start-date");
            
//         // Convertissez la chaîne de date en un objet Date JavaScript
//         var startDateParts = startDateStr.split('/');
//         var startDate = new Date(startDateParts[2], startDateParts[1] - 1, startDateParts[0]);
            
//         // Obtenez l'heure de check-in à partir de l'attribut de données
//         var checkinTime = countdownElement.getAttribute("data-checkin-time");
//         var checkinHours = parseInt(checkinTime.split(':')[0]);
//         var checkinMinutes = parseInt(checkinTime.split(':')[1]);
            
//         // Ajoutez l'heure de check-in à la date de début
//         startDate.setHours(checkinHours);
//         startDate.setMinutes(checkinMinutes);
//         startDate.setSeconds(0); // Assurez-vous de régler les secondes à zéro pour éviter les imprécisions
            
//         // Mettez à jour le compte à rebours chaque seconde
//         var x = setInterval(function() {
        
//             // Obtenez la date et l'heure actuelles
//             var now = new Date().getTime();
        
//             // Trouvez la distance entre maintenant et la date de début
//             var distance = startDate - now;
        
//             // Calculs de temps pour jours, heures, minutes et secondes
//             var days = Math.floor(distance / (1000 * 60 * 60 * 24));
//             var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//             var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//             var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
//             // Affichez le résultat dans l'élément avec id="countdownText"
//             var countdownTextElement = document.getElementById("countdownText");
//             if (countdownTextElement) {
//                 countdownTextElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
//             }
        
//             // Si le compte à rebours est terminé, écrivez un texte
//             if (distance < 0) {
//                 clearInterval(x);
//                 if (countdownTextElement) {
//                     countdownTextElement.innerHTML = "ENJOY YOUR STAY !";
//                 }
//             }
//         }, 1000);
//     }
// });
document.addEventListener("DOMContentLoaded", function() {
    // Sélectionnez tous les éléments avec la classe property-card-header
    var countdownElements = document.querySelectorAll(".property-card-header[data-start-date], .booking-cover-property[data-start-date]");

    countdownElements.forEach(function(countdownElement) {
        // Obtenez la date de début à partir de l'attribut de données de l'élément actuel
        var startDateStr = countdownElement.getAttribute("data-start-date");

        // Convertissez la chaîne de date en un objet Date JavaScript
        var startDateParts = startDateStr.split('/');
        var startDate = new Date(startDateParts[2], startDateParts[1] - 1, startDateParts[0]);

        // Obtenez l'heure de check-in à partir de l'attribut de données de l'élément actuel
        var checkinTime = countdownElement.getAttribute("data-checkin-time");
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

            // Trouvez l'élément countdownText associé à cet élément countdownElement
            var countdownTextElement = countdownElement.querySelector(".cd-text");

            // Si le compte à rebours est terminé, écrivez un texte
            if (distance < 0) {
                clearInterval(x);
                if (countdownTextElement) {
                    countdownTextElement.innerHTML = "ENJOY YOUR STAY !";
                    // Changez la couleur du texte lorsque le compte à rebours est terminé
                    countdownTextElement.style.color = "#49BD00";
                }
                return;
            }

            // Calculs de temps pour jours, heures, minutes et secondes
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Affichez le résultat dans l'élément countdownText associé à cet élément countdownElement
            if (countdownTextElement) {
                countdownTextElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
            }
        }, 1000);
    });
});