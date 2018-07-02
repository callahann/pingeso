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
        [Mutations.SET_STATE_ARRAY] (state, { key, payload }) {
            state[key] = Object.assign([], state[key], payload.data)
        },
        [Mutations.SET_STATE_OBJECT] (state, { key, payload }) {
            state[key] = Object.assign({}, state[key], payload.data)
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
        [Mutations.HANDLE_ERROR] (state, { error, callback }) {
            callback(false, error);
        }
    },
    actions: {
        async [Actions.INIT_STORE] ({ dispatch, commit }, callback) {
            const rol = await dispatch(Actions.FETCH_AUTH_USER, callback)
            
            dispatch(Actions.FETCH_DECLARACIONES, rol)

            if(rol > 1) {
                const request = ['facultades', 'jerarquias', 'jornadas', 'roles', 'usuarios']
                request.forEach(r => {
                    axios
                        .get('/api/' + r)
                        .then(response => {
                            commit(Mutations.SET_STATE_ARRAY, { key: r, payload: response })
                        })
                })
            }
            
            callback()
        },
        async [Actions.FETCH_AUTH_USER] ({ commit }) {
            const response = await axios.get('/user')
            commit(Mutations.SET_STATE_OBJECT, { key: 'auth', payload: response })
            return response.data.rol.id
        },
        [Actions.FETCH_DECLARACIONES] ({ commit }, rol) {
            const q = rol === 1 ? '/user/declaraciones' : '/declaraciones'
            axios
                .get('/api' + q)
                .then(response => {
                    commit(Mutations.SET_STATE_ARRAY, { key: 'informes', payload: response })
                })
        },
        [Actions.INSERT_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .post('/api/declaraciones', informe)
                .then(response => {
                    commit(Mutations.INSERT_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id, informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.APPROVE_DECLARACION] ({ commit }, { id, cb }) {
            axios
                .get('/api/declaraciones/' + id + '/aprobar')
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { informe: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        }
    }
})

export default store