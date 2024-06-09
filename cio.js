

function placeholderIsSupported() {
    test = document.createElement('input');
    return ('placeholder' in test);
}

$(document).ready(function(){
placeholderSupport = placeholderIsSupported() ? 'placeholder' : 'no-placeholder';
$('html').addClass(placeholderSupport);  
});
$(document).ready(function() {
    // Afficher le formulaire d'inscription au chargement de la page
    $('#registration-form').addClass('active');

    // Lorsque vous cliquez sur le lien pour passer au formulaire de connexion
    $('#show-sign-in').click(function() {
        $('#registration-form').removeClass('active');
        $('#sign-in-form').addClass('active');
    });

    // Lorsque vous cliquez sur le lien pour revenir au formulaire d'inscription
    $('#show-registration').click(function() {
        $('#sign-in-form').removeClass('active');
        $('#registration-form').addClass('active');
    });
});
