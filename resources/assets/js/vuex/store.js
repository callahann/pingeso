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
        usuarios: [],
        departamentos: [],
        periodos: [],
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
            callback(true, payload.mensaje.data);
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
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_RANGO] (state, { payload, callback }) {
            state.rangos.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_RANGO] (state, { payload, callback }) {
            const index = state.rangos.findIndex(rango => {
                return rango.id === payload.data.id
            })
            const rango = state.rangos[index]
            state.rangos[index] = Object.assign({}, rango, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_RANGO] (state, { payload, callback}) {
            const index = state.rangos.findIndex(rango => {
                return rango.id === payload.data.id
            })
            state.rangos.splice(index, 1);
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_JERARQUIA] (state, { payload, callback }) {
            state.jerarquias.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_JERARQUIA] (state, { payload, callback }) {
            const index = state.jerarquias.findIndex(jerarquia => {
                return jerarquia.id === payload.data.id
            })
            const jerarquia = state.jerarquias[index]
            state.jerarquias[index] = Object.assign({}, jerarquia, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_JERARQUIA] (state, { payload, callback}) {
            const index = state.jerarquias.findIndex(jerarquia => {
                return jerarquia.id === payload.data.id
            })
            state.jerarquias.splice(index, 1);
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_JORNADA] (state, { payload, callback }) {
            state.jornadas.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_JORNADA] (state, { payload, callback }) {
            const index = state.jornadas.findIndex(jornada => {
                return jornada.id === payload.data.id
            })
            const jornada = state.jornadas[index]
            state.jornadas[index] = Object.assign({}, jornada, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_JORNADA] (state, { payload, callback}) {
            const index = state.jornadas.findIndex(jornada => {
                return jornada.id === payload.data.id
            })
            state.jornadas.splice(index, 1);
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_FACTOR] (state, { payload, callback }) {
            state.factores.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_FACTOR] (state, { payload, callback }) {
            const index = state.factores.findIndex(factor => {
                return factor.id === payload.data.id
            })
            const factor = state.factores[index]
            state.factores[index] = Object.assign({}, factor, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_FACTOR] (state, { payload, callback}) {
            const index = state.factores.findIndex(factor => {
                return factor.id === payload.data.id
            })
            state.factores.splice(index, 1);
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_PERIODO] (state, { payload, callback }) {
            state.periodos.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_PERIODO] (state, { payload, callback }) {
            const index = state.periodos.findIndex(periodo => {
                return periodo.id === payload.data.id
            })
            const periodo = state.periodos[index]
            state.periodos[index] = Object.assign({}, periodo, payload.data)
            
            callback(true, payload.data);
        },
        [Mutations.DELETE_PERIODO] (state, { payload, callback}) {
            const index = state.periodos.findIndex(periodo => {
                return periodo.id === payload.data.id
            })
            state.periodos.splice(index, 1);
            callback(true, payload.mensaje.data);
        },
        [Mutations.INSERT_USUARIO] (state, { payload, callback }) {
            state.usuarios.push(payload.data)
            callback(true, payload.data);
        },
        [Mutations.UPDATE_USUARIO] (state, { payload, callback }) {
            const index = state.usuarios.findIndex(usuario => {
                return usuario.id === payload.data.id
            })
            const usuario = state.usuarios[index]
            state.usuarios[index] = Object.assign({}, usuario, payload.data)
            
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
            if(rol >= 1)
                request = request.concat(['facultades', 'departamentos', 'jerarquias', 'jornadas', 'usuarios', 'periodos'])
            
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
                    commit(Mutations.DELETE_FACULTAD, { payload: {data: facultad, mensaje: response}, callback: cb })
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
                    commit(Mutations.DELETE_DEPARTAMENTO, { payload: {data: departamento, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_RANGO] ({ commit }, { rango, cb }) {
            axios
                .post('/api/rangos', rango)
                .then(response => {
                    commit(Mutations.INSERT_RANGO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_RANGO] ({ commit }, { rango, cb }) {
            axios
                .put('/api/rangos/' + rango.id, rango)
                .then(response => {
                    commit(Mutations.UPDATE_RANGO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_RANGO] ({ commit }, { rango, cb }) {
            axios
                .delete('/api/rangos/' + rango.id, rango)
                .then(response => {
                    commit(Mutations.DELETE_RANGO, { payload: {data: rango, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_JERARQUIA] ({ commit }, { jerarquia, cb }) {
            axios
                .post('/api/jerarquias', jerarquia)
                .then(response => {
                    commit(Mutations.INSERT_JERARQUIA, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_JERARQUIA] ({ commit }, { jerarquia, cb }) {
            axios
                .put('/api/jerarquias/' + jerarquia.id, jerarquia)
                .then(response => {
                    commit(Mutations.UPDATE_JERARQUIA, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_JERARQUIA] ({ commit }, { jerarquia, cb }) {
            axios
                .delete('/api/jerarquias/' + jerarquia.id, jerarquia)
                .then(response => {
                    commit(Mutations.DELETE_JERARQUIA, { payload: {data: jerarquia, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_JORNADA] ({ commit }, { jornada, cb }) {
            axios
                .post('/api/jornadas', jornada)
                .then(response => {
                    commit(Mutations.INSERT_JORNADA, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_JORNADA] ({ commit }, { jornada, cb }) {
            axios
                .put('/api/jornadas/' + jornada.id, jornada)
                .then(response => {
                    commit(Mutations.UPDATE_JORNADA, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_JORNADA] ({ commit }, { jornada, cb }) {
            axios
                .delete('/api/jornadas/' + jornada.id, jornada)
                .then(response => {
                    commit(Mutations.DELETE_JORNADA, { payload: {data: jornada, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_FACTOR] ({ commit }, { factor, cb }) {
            axios
                .post('/api/factores', factor)
                .then(response => {
                    commit(Mutations.INSERT_FACTOR, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_FACTOR] ({ commit }, { factor, cb }) {
            axios
                .put('/api/factores/' + factor.id, factor)
                .then(response => {
                    commit(Mutations.UPDATE_FACTOR, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_FACTOR] ({ commit }, { factor, cb }) {
            axios
                .delete('/api/factores/' + factor.id, factor)
                .then(response => {
                    commit(Mutations.DELETE_FACTOR, { payload: {data: factor, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_PERIODO] ({ commit }, { periodo, cb }) {
            axios
                .post('/api/periodos', periodo)
                .then(response => {
                    commit(Mutations.INSERT_PERIODO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_PERIODO] ({ commit }, { periodo, cb }) {
            axios
                .put('/api/periodos/' + periodo.id, periodo)
                .then(response => {
                    commit(Mutations.UPDATE_PERIODO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.DELETE_PERIODO] ({ commit }, { periodo, cb }) {
            axios
                .delete('/api/periodos/' + periodo.id, periodo)
                .then(response => {
                    commit(Mutations.DELETE_PERIODO, { payload: {data: periodo, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.INSERT_USUARIO] ({ commit }, { usuario, cb }) {
            axios
                .post('/api/usuarios', usuario)
                .then(response => {
                    commit(Mutations.INSERT_USUARIO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
        [Actions.UPDATE_USUARIO] ({ commit }, { usuario, cb }) {
            axios
                .put('/api/usuarios/' + usuario.id, usuario)
                .then(response => {
                    commit(Mutations.UPDATE_USUARIO, { payload: response, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { error: e, callback: cb })
                })
        },
    }
})

export default store