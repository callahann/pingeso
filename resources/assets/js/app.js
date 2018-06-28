/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

window.Vue = require('vue');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'

Vue.use(VueRouter)

import App from './components/App';
import Inicio from './components/Inicio';
import ListaInformes from './components/informe/Lista';
import Formulario from './components/informe/formulario/Formulario';
import ListaUsuarios from './components/usuario/Lista'
import Usuario from './components/usuario/Usuario'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const EtapasEnum = Object.freeze({
    declarando: 1,
    aprobando: 2,
    realizado: 3,
    evaluando: 4,
    apelando: 5
});

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/inicio',
            name: 'inicio',
            component: Inicio,
        },
        {
            path: '/usuarios',
            name: 'usuarios',
            component: ListaUsuarios,
        },
        {
            path: '/usuarios/crear',
            name: 'nuevo-usuario',
            component: Usuario,
            props: { editable: true },
        },
        {
            path: '/usuarios/:id',
            name: 'editar-usuario',
            component: Usuario,
            props: { editable: true },
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
            path: '/informes/:id/aprobar',
            name: 'aprobar-informe',
            component: Formulario,
            props: { etapa: EtapasEnum.aprobando }
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
        {
            path: '/informes/:id/apelar',
            name: 'apelar-evaluacion',
            component: Formulario,
            props: { etapa: EtapasEnum.apelando }
        },
    ],
});

Vue.mixin({
    data: function() {
        return {
            usuario: undefined,
            titulos_item: Object.freeze({
                item_docencia: 'Docencia',
                item_investigacion: 'Investigación y desarrollo',
                item_asistencia: 'Asistencia técnica',
                item_perfeccionamiento: 'Perfeccionamiento',
                item_administracion: 'Administración académica',
                item_extension: 'Extensión',
                item_educacion_continua: 'Educación continua'
            }),
            etapas: EtapasEnum,
            ecuaciones: Object.freeze({
                equivalentes: 'Math.round((semanal * 36 + semestral_anual) / 44 * 10) / 10',
                calificacion: ''
            })
        }
    },
    created: function() {
        axios
            .get('/user')
            .then(response => { 
                this.usuario = Object.assign({}, response.data, this.usuario);
            })
            .catch(e => {
                console.log(e);
            });
    },
    methods: {
        formData: function(object) {
            let formData = new FormData();
            for (var key in object) {
                formData.append(key, object[key]);
            }
            return formData;
        },
        equivalentes: function(a, b) {
            return eval(this.ecuaciones.equivalentes.replaceAll('semanal', a).replaceAll('semestral_anual', b));
        },
        volver: function(route, mensaje = undefined) {
            this.$router.push({
                name: route,
                params: { 
                    mensaje: mensaje
                }
            });
            return mensaje;
        },
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
}).$mount('#app');