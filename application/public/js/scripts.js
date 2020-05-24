$(document).ready(function(){   
    if (Cookies.get('laravel_cookie_consent')) {
        $('#cookie-consent-container').remove();
        // load ads
    } else {
        // remove ads
    }
});