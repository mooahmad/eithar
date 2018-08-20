require('./../bootstrap');

import translations from './../vue-translations.js';

var lang = new Lang();

let currentLang = document.head.querySelector('meta[name="lang"]').content;

lang.setLocale(currentLang);

lang.setMessages(translations);

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

import app from './components/app.vue';

new Vue({
    el: '#app',
    render: h => h(app)
});