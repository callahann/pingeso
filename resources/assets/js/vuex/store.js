import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import * as Mutations from './mutations'
import * as Actions from './actions'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        queue: 0,
        informes: [],
        usuarios: [],
        formula: Object.freeze({
            equivalente: 'Math.round((s * 36 + sa) / 44 * 10) / 10',
            nota_final: '(nota_item_docencia * realizado_eq_item_docencia + nota_item_investigacion * realizado_eq_item_investigacion + nota_item_asistencia * realizado_eq_item_asistencia + nota_item_perfeccionamiento * realizado_eq_item_perfeccionamiento + nota_item_administracion * realizado_eq_item_administracion + nota_item_extension * realizado_eq_item_extension + nota_item_educacion_continua * realizado_eq_item_educacion_continua) / realizado_eq'
        })
    },
    mutations: {
        [Mutations.SET_AUTH_USER] (state, payload) {
            state.auth = payload.auth
        },
        [Mutations.INSERT_DECLARACION] (state, { payload, callback }) {
            state.informes.push(payload)
            callback(true, payload);
        },
        [Mutations.UPDATE_DECLARACION] (state, { payload, callback }) {
            const index = state.informes.findIndex(informe => {
                return informe.id === payload.id
            })
            const informe = state.informes[index]
            state.informes[index] = Object.assign({}, informe, payload)
            
            callback(true, payload);
        },
        [Mutations.HANDLE_ERROR] (state, { payload, callback }) {
            callback(false, payload);
        }
    },
    actions: {
        [Actions.FETCH_AUTH_USER] ({ commit }, callback) {
            axios
                .get('/user')
                .then(response => {
                    commit(Mutations.SET_AUTH_USER, { auth: response.data })
                    callback()
                })
                .catch(e => {
                    console.log(e)
                })
            return new Promise((resolve, reject) => {
                setTimeout(async () => {
                    const response = await 
                    
                    resolve()
                }, 1000)
            })
        },
        [Actions.INSERT_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .post('/api/declaraciones', informe)
                .then(response => {
                    commit(Mutations.INSERT_DECLARACION, { informe: response.data, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        },
        [Actions.UPDATE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id, informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response.data, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        },
        [Actions.APPROVE_DECLARACION] ({ commit }, { id, cb }) {
            axios
                .get('/api/declaraciones/' + id + '/aprobar')
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response.data, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        }
    }
})

export default store