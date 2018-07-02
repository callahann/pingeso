import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import * as Mutations from './mutations'
import * as Actions from './actions'

Vue.use(Vuex)

const asArray = function(data) {
    return Object.keys(data).map(key => data[key])
}

const store = new Vuex.Store({
    state: {
        queue: 0,
        facultades: [],
        informes: [],
        jerarquias: [],
        jornadas: [],
        roles: [],
        usuarios: [],
        formula: {
            equivalente: 'Math.round((se * 36 + sa) / 44 * 10) / 10',
            nota_final: '(nota_item_docencia * realizado_eq_item_docencia + nota_item_investigacion * realizado_eq_item_investigacion + nota_item_asistencia * realizado_eq_item_asistencia + nota_item_perfeccionamiento * realizado_eq_item_perfeccionamiento + nota_item_administracion * realizado_eq_item_administracion + nota_item_extension * realizado_eq_item_extension + nota_item_educacion_continua * realizado_eq_item_educacion_continua) / realizado_eq'
        }
    },
    mutations: {
        [Mutations.SET_AUTH_USER] (state, payload) {
            state.auth = Object.assign({}, state.auth, payload.data)
        },
        [Mutations.SET_FACULTADES] (state, payload) {
            state.facultades = Object.assign([], state.facultades, payload.data)
        },
        [Mutations.SET_JERARQUIAS] (state, payload) {
            state.jerarquias = Object.assign([], state.jerarquias, payload.data)
        },
        [Mutations.SET_JORNADAS] (state, payload) {
            state.jornadas = Object.assign([], state.jornadas, payload.data)
        },
        [Mutations.SET_ROLES] (state, payload) {
            state.roles = Object.assign([], state.roles, payload.data)
        },
        [Mutations.SET_USUARIOS] (state, payload) {
            state.usuarios = state.auth.rol.id > 1 ? Object.assign([], state.usuarios, payload.data) : []
        },
        [Mutations.INSERT_DECLARACION] (state, { payload, callback }) {
            state.informes.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_DECLARACION] (state, { payload, callback }) {
            const index = state.informes.findIndex(informe => {
                return informe.id === payload.data.id
            })
            const informe = state.informes[index]
            state.informes[index] = Object.assign({}, informe, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.HANDLE_ERROR] (state, { payload, callback }) {
            callback(false, payload);
        }
    },
    actions: {
        async [Actions.INIT_STORE] ({ dispatch, commit }, callback) {
            await dispatch(Actions.FETCH_AUTH_USER, callback)
            commit(Mutations.SET_FACULTADES, await axios.get('/api/facultades'))
            commit(Mutations.SET_JERARQUIAS, await axios.get('/api/jerarquias'))
            commit(Mutations.SET_JORNADAS, await axios.get('/api/jornadas'))
            commit(Mutations.SET_ROLES, await axios.get('/api/roles'))
            commit(Mutations.SET_USUARIOS, await axios.get('/api/usuarios'))
            callback()
        },
        async [Actions.FETCH_AUTH_USER] ({ commit }) {
            axios
                .get('/user')
                .then(response => {
                    commit(Mutations.SET_AUTH_USER, response)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        [Actions.INSERT_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .post('/api/declaraciones', informe)
                .then(response => {
                    commit(Mutations.INSERT_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        },
        [Actions.UPDATE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id, informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        },
        [Actions.APPROVE_DECLARACION] ({ commit }, { id, cb }) {
            axios
                .get('/api/declaraciones/' + id + '/aprobar')
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, e, cb)
                })
        }
    }
})

export default store