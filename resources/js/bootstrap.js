import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import Pusher from 'pusher-js';

var pusher = new Pusher('13540e8ba13a368c04f6', {
    cluster: 'us3',
    encrypted: true,
});

var channel = pusher.subscribe('maintenance-channel');

channel.bind('App\\Events\\MaintenanceModeUpdated', function(data) {
    if (data.maintenanceMode) {
        setTimeout(() => {
            location.reload();
        }, 10000);
    }
});
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// resources/js/bootstrap.js


