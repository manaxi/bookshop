require('./bootstrap');

//indow.Vue = require('vue').default;
import Vue from 'vue';
const app = new Vue({
    el: '#app',
    data: {
        message: 'Hello'
    }
});
