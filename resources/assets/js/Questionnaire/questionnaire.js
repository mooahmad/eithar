require('./../bootstrap');

import translations from './../vue-translations.js';

var lang = new Lang();

lang.setLocale('en');

lang.setMessages(translations);

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

import app from './components/app.vue';

new Vue({
    el: '#app',
    render: h => h(app)
});