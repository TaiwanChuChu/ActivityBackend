import Vue from 'vue';

Vue.component('about-us', require('./components/AboutComponent.vue').default);
Vue.component('form-test', require('./components/FormTestComponent').default);

const app = new Vue({
   el: '#app',
});
