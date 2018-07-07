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
        formula: {},
        informes: [],
        jerarquias: [],
        jornadas: [],
        rangos: [],
        roles: [],
        usuarios: [],
        departamentos: [],
    },
    mutations: {
        [Mutations.SET_STATE_ARRAY] (state, { key, payload }) {
            state[key] = Object.assign([], state[key], payload.data)
        },
        [Mutations.SET_STATE_OBJECT] (state, { key, payload }) {
            state[key] = Object.assign({}, state[key], payload.data)
        },
        [Mutations.SET_STATE_PAGINATION] (state, { key, payload }) {
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
        [Mutations.ATTACH_APELACION] (state, { payload, callback }) {
            const index = state.informes.findIndex(informe => {
                return informe.id === payload.data.id_declaracion
            })
            state.informes[index].apelaciones.push(payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.INSERT_FACULTAD] (state, { payload, callback }) {
            state.facultades.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_FACULTAD] (state, { payload, callback }) {
            const index = state.facultades.findIndex(facultad => {
                return facultad.id === payload.data.id
            })
            const facultad = state.facultades[index]
            state.facultades[index] = Object.assign({}, facultad, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_FACULTAD] (state, { payload, callback}) {
            const index = state.facultades.findIndex(facultad => {
                return facultad.id === payload.data.id
            })
            state.facultades.splice(index, 1);
            callback(true, payload.data);
        },
        [Mutations.INSERT_DEPARTAMENTO] (state, { payload, callback }) {
            state.departamentos.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_DEPARTAMENTO] (state, { payload, callback }) {
            const index = state.departamentos.findIndex(departamento => {
                return departamento.id === payload.data.id
            })
            const departamento = state.departamentos[index]
            state.departamentos[index] = Object.assign({}, departamento, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_DEPARTAMENTO] (state, { payload, callback}) {
            const index = state.departamentos.findIndex(departamento => {
                return departamento.id === payload.data.id
            })
            state.departamentos.splice(index, 1);
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

            var request = ['descripciones', 'factores', 'rangos']
            if(rol === 2 || rol === 4)
                request = request.concat(['facultades', 'departamentos', 'jerarquias', 'jornadas', 'roles', 'usuarios'])
            
            request.forEach(r => {
                axios
                    .get('/api/' + r)
                    .then(response => {
                        commit(Mutations.SET_STATE_ARRAY, { key: r, payload: response })
                    })
            })

            axios
                .get('/api/formulas')
                .then(response => {
                    commit(Mutations.SET_STATE_OBJECT, { key: 'formula', payload: response })
                })
            
            callback()
        },
        async [Actions.FETCH_AUTH_USER] ({ commit }) {
            const response = await axios.get('/api/auth')
            commit(Mutations.SET_STATE_OBJECT, { key: 'auth', payload: response })
            return response.data.rol.id
        },
        [Actions.FETCH_DECLARACIONES] ({ commit }, rol) {
            axios
                .get('/api/auth/declaraciones')
                .then(response => {
                    commit(Mutations.SET_STATE_ARRAY, { key: 'informes', payload: response })
                })
        },
        [Actions.INSERT_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .post('/api/declaraciones', informe)
                .then(response => {
                    commit(Mutations.INSERT_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id, informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.SEND_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/enviar', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.APPROVE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/aprobar', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DECLINE_DECLARACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/revision', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_APELACION] ({ commit }, { apelacion, cb }) {
            axios
                .post('/api/apelaciones', apelacion)
                .then(response => {
                    commit(Mutations.ATTACH_APELACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.RESOLVE_APELACION] ({ commit }, { informe, cb }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/resolver', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_FACULTAD] ({ commit }, { facultad, cb }) {
            axios
                .post('/api/facultades', facultad)
                .then(response => {
                    commit(Mutations.INSERT_FACULTAD, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_FACULTAD] ({ commit }, { facultad, cb }) {
            axios
                .put('/api/facultades/' + facultad.id, facultad)
                .then(response => {
                    commit(Mutations.UPDATE_FACULTAD, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_FACULTAD] ({ commit }, { facultad, cb }) {
            axios
                .delete('/api/facultades/' + facultad.id, facultad)
                .then(response => {
                    commit(Mutations.DELETE_FACULTAD, { payload: {data: facultad}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_DEPARTAMENTO] ({ commit }, { departamento, cb }) {
            axios
                .post('/api/departamentos', departamento)
                .then(response => {
                    commit(Mutations.INSERT_DEPARTAMENTO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_DEPARTAMENTO] ({ commit }, { departamento, cb }) {
            axios
                .put('/api/departamentos/' + departamento.id, departamento)
                .then(response => {
                    commit(Mutations.UPDATE_DEPARTAMENTO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_DEPARTAMENTO] ({ commit }, { departamento, cb }) {
            axios
                .delete('/api/departamentos/' + departamento.id, departamento)
                .then(response => {
                    commit(Mutations.DELETE_DEPARTAMENTO, { payload: {data: departamento}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
    }
})

export default store