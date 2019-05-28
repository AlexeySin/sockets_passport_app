require('./bootstrap');

window.Vue = require('vue');
Vue.component('chat-component', require('./components/ChatComponent.vue').default);
Vue.component('guest-component', require('./components/GuestComponent.vue').default);
Vue.component('check-component', require('./components/CheckComponent.vue').default);

const app = new Vue({
    el: '#app',
});
