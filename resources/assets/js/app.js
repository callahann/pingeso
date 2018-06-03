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
import Formulario from './components/informe/formulario';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const EtapasEnum = Object.freeze({
    declarando: 1,
    aprobando: 2,
    realizado: 3,
    evaluando: 4
});

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
            component: Formulario,
            props: { etapa: EtapasEnum.declarando }
        },
        {
            path: '/informes/:id',
            name: 'editar-informe',
            component: Formulario,
            props: { etapa: EtapasEnum.declarando }
        },
        {
            path: '/informes/:id/realizado',
            name: 'declarar-realizado',
            component: Formulario,
            props: { etapa: EtapasEnum.realizado }
        },
        {
            path: '/informes/:id/evaluar',
            name: 'evaluar-informe',
            component: Formulario,
            props: { etapa: EtapasEnum.evaluando }
        },
    ],
});

Vue.mixin({
    data: function() {
        return {
            datosPersonales: {
                apellido_paterno: 'Álvarez',
                apellido_materno: 'Molina',
                nombres: 'Mario Francisco',
                facultad: 'Ingeniería',
                departamento: 'Informática',
                jerarquia: 'Cargo',
                jornada: 'Jornada'
            },
            titulos_item: Object.freeze({
                item_docencia: 'Docencia',
                item_investigacion: 'Investigación y desarrollo',
                item_asistencia: 'Asistencia técnica',
                item_perfeccionamiento: 'Perfeccionamiento',
                item_administracion: 'Administración académica',
                item_extension: 'Extensión',
                item_educacion_continua: 'Educación continua'
            }),
            etapas: EtapasEnum
        }
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
}).$mount('#app');