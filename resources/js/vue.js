import Vue from 'vue';

Vue.component('about-us', require('./components/AboutComponent.vue').default);
Vue.component('form-test', require('./components/FormTestComponent').default);
Vue.component('merge', require('./components/MergeComponent').default);

const app = new Vue({
   el: '#app',
});
