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
        descripciones: [],
        factores: [],
        facultades: [],
        informes: [],
        jerarquias: [],
        jornadas: [],
        rangos: [],
        roles: [],
        usuarios: [],
        formulas: [],
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

            var request = ['descripciones', 'factores', 'formulas', 'rangos']
            if(rol === 2 || rol === 4)
                request = request.concat(['facultades', 'jerarquias', 'jornadas', 'roles', 'usuarios'])
            
            request.forEach(r => {
                axios
                    .get('/api/' + r)
                    .then(response => {
                        commit(Mutations.SET_STATE_ARRAY, { key: r, payload: response })
                    })
            })
            
            callback()
        },
        async [Actions.FETCH_AUTH_USER] ({ commit }) {
            const response = await axios.get('/api/auth')
            commit(Mutations.SET_STATE_OBJECT, { key: 'auth', payload: response })
            return response.data.rol.id
        },
        [Actions.FETCH_DECLARACIONES] ({ commit }, rol) {
            const q = rol === 1 ? '/auth/declaraciones' : '/declaraciones'
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