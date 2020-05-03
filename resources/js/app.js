/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.directive('number_format', {
    bind: function (el, binding, vnode) {
        el.innerHTML = new Intl.NumberFormat('ja-JP').format(binding.value)
    },
    update: function (el, binding, vnode) {
        el.innerHTML = new Intl.NumberFormat('ja-JP').format(binding.value)
    }
})

import clickOutside from "./directives/click-ouside"
Vue.directive("click-outside", clickOutside);

import ToggleButton from 'vue-js-toggle-button'
Vue.use(ToggleButton)

import { store } from './store/store.js';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
});
