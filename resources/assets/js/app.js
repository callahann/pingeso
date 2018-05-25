/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App';
import Inicio from './components/Inicio';
import ListaInformes from './components/informe/Lista';
import FormDeclaracion from './components/informe/declaracion/Formulario';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'inicio',
            component: Inicio,
        },
        {
            path: '/informes',
            name: 'informes',
            component: ListaInformes,
            props: true,
        },
        {
            path: '/informes/declarar',
            name: 'nuevo-informe',
            component: FormDeclaracion,
        },
        {
            path: '/informes/:id',
            name: 'editar-informe',
            component: FormDeclaracion,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
}).$mount('#app');
