/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

String.prototype.replaceAll = function(search, replacement) {
    var target = this
    return target.replace(new RegExp(search, 'g'), replacement)
}

window.Vue = require('vue')

import Vue from 'vue'
import 'es6-promise/auto'
import axios from 'axios'
Vue.prototype.$http = axios

import App from './components/App'

import { FETCH_AUTH_USER } from './vuex/actions'
import store from './vuex/store'
import { router } from './router'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = function() {
    new Vue({
        el: '#app',
        store,
        router,
        components: { App },
    })
}

store.dispatch(FETCH_AUTH_USER, app)
