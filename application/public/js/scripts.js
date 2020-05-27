$(document).ready(function(){   
    if (Cookies.get('laravel_cookie_consent')) {
        $('#cookie-consent-container').remove();
        // load ads

        // load ga
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-167849652-1');

    } else {
        // remove ads
    }
});