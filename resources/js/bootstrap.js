window._ = require('lodash');
window.axios = require('axios');
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
};

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.Laravel.websocketKey,
    cluster: window.Laravel.websocketCluster,
    forceTLS: false,
    wsHost: window.location.hostname,
    wsPath: window.Laravel.websocketPath,
    wsPort: window.Laravel.websocketPort,
    disabledTransports: ['sockjs'],
    enabledTransports: ['ws']
});
