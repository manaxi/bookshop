require('./bootstrap');

//indow.Vue = require('vue').default;
import Vue from 'vue';
Vue.use(require('bootstrap-vue'));

Vue.component('Rating', require('./components/Rating.vue').default);
const app = new Vue({
    el: '#app',
});
