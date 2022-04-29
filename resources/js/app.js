/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import router from './router'
import store from './store'


// window.Vue = Vue;



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const ProjectComponent = require('./components/ProjectComponent.vue').default;
 const SearchProjectComponent = require('./components/SearchProjectComponent.vue').default;
 const PublicMessageComponent = require('./components/PublicMessageComponent.vue').default;
 const ModalComponent = require('./components/ModalComponent.vue').default;
 const DirectMessageComponent = require('./components/DirectMessageComponent.vue').default;
 const AppliedUserComponent = require('./components/AppliedUserComponent.vue').default;
 const LikeComponent = require('./components/LikeComponent.vue').default;


const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
        'project-component': ProjectComponent,
        'searchproject-component': SearchProjectComponent,
        'p_message-component': PublicMessageComponent,
        'modal-component' : ModalComponent,
        'd_message-component' : DirectMessageComponent,
        'applieduser-component' : AppliedUserComponent,
        'like-component' : LikeComponent
    }
});
