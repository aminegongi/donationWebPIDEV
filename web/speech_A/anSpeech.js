if (annyang) {

    annyang.debug(true);
    annyang.setLanguage('fr-FR');//ar-TN
    // Add our commands to annyang
    annyang.addCommands({
        'ouvrir la cagnotte': function() {
            console.log('-----------Cagnotte-----------');
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/Cagnotte/'
        },
        'ouvrir la plateforme d\'aide': function() {
            console.log('-----------Aide-----------');
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/aide/demandeaide/'
        },
        'ouvrir resto organisation': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/RestoOrg/'
        },
        'ouvrir resto dent': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/RestoDon/'
        },
        'ouvrir mon profil': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/user/profil'
        },
        'ouvrir profil': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/user/profil'
        },
        'page d\'accueil': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/'
        },
        'emine descends un peu': function() {
            window.scrollBy(0,300);
        },
        'emine monte un peu': function() {
            window.scrollBy(0,-300);
        },
        'descends': function() {
            window.scrollBy(0,300);
        },
        'monte': function() {
            window.scrollBy(0,-300);
        },
        'retour' :function() {
            window.history.go(-1);
        },
        'déconnexion': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/logout'
        },
        'connexion': function() {
            window.location.href = 'http://localhost/donationLastTry/web/app_dev.php/login'
        }
    });

    // Tell KITT to use annyang
    SpeechKITT.annyang();

    // Define a stylesheet for KITT to use
    SpeechKITT.setStylesheet('https://cdnjs.cloudflare.com/ajax/libs/SpeechKITT/0.3.0/themes/flat.css');

    SpeechKITT.setInstructionsText('DoNation vous entend');
    SpeechKITT.setSampleCommands(['au revoir ', 'bonjour']);

    SpeechKITT.rememberStatus(0.2);
    // Render KITT's interface
    SpeechKITT.vroom();
}