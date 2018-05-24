
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

 Vue.component(
    'formulario',
    require('./components/declaracion/Formulario.vue').default
);

Vue.component(
    'datos-personales',
    require('./components/declaracion/secciones/DatosPersonales.vue').default
);

Vue.component(
    'lista-items',
    require('./components/declaracion/secciones/ListaItems.vue').default
);

Vue.component(
    'resumen-declaraciones',
    require('./components/declaracion/secciones/Resumen.vue').default
);

Vue.component(
    'lista-declaraciones',
    require('./components/declaracion/Lista.vue').default
);

const app = new Vue({
    el: '#app'
}).$mount('#app');
