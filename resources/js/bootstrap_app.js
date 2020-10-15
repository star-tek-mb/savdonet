try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
} catch (e) {
    console.log(e);
}

$(document).ready(function() {
    $('body').removeClass('preload');
    $('#sidebar-wrapper').on('toggled', function() {
        console.log('toggled');
        $('#app').toggleClass('toggled');
        $('html').css('overflow-y', $('#app').hasClass('toggled') ? 'hidden' : 'scroll');
    });
});