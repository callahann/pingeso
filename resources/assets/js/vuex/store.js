import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import * as Mutations from './mutations'
import * as Actions from './actions'

Vue.use(Vuex)

/**
 * Genera un objeto FormData para enviar a la API. Esto es necesario
 * cuando se envían archivos (como en el caso de la Apelación).
 * @param object Objeto para el cual se creará el objeto FormData
 */
const formData = function(object) {
    let formData = new FormData()
    for (var key in object) {
        formData.append(key, object[key])
    }
    return formData
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
            state.informes.usuario.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_DECLARACION] (state, { payload, callback }) {
            ['usuario', 'comision'].forEach((key) => {
                const index = state.informes[key].findIndex(informe => {
                    return informe.id === payload.data.id
                })

                if(index >= 0) {
                    const informe = state.informes[key][index]
                    state.informes[key][index] = Object.assign({}, informe, payload.data)
                }
            })

            callback(true, payload)
        },
        [Mutations.ATTACH_APELACION] (state, { payload, comision, callback }) {
            var index = -1;
            const tipo = ['usuario', 'comision'].find((key) => {
                index = state.informes[key].findIndex(informe => {
                    return informe.id === payload.data.id_declaracion
                })
                return index >= 0
            })

            var apelacion = state.informes[tipo][index].apelacion
            Vue.set(apelacion.apelaciones, comision, payload.data)
            apelacion.apelado = true
            apelacion.apelar = false
            callback(true, payload)
        },
        [Mutations.UPDATE_APELACION] (state, { payload, callback }) {
            var index = -1;
            const tipo = ['usuario', 'comision'].find((key) => {
                index = state.informes[key].findIndex(informe => {
                    return informe.id === payload.data.id_declaracion
                })
                return index >= 0
            })

            var apelacion = state.informes[tipo][index].apelacion
            const comision = apelacion.apelaciones.findIndex(apelacion => {
                return apelacion !== null && apelacion.id === payload.data.id
            })
            Vue.set(apelacion.apelaciones, comision, payload.data)
            apelacion.apelado = false
            apelacion.apelar = apelacion.apelaciones.includes(null)
            callback(true, payload)
        },
        [Mutations.INSERT_FACULTAD] (state, { payload, callback }) {
            state.facultades.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_FACULTAD] (state, { payload, callback }) {
            const index = state.facultades.findIndex(facultad => {
                return facultad.id === payload.data.id
            })
            const facultad = state.facultades[index]
            state.facultades[index] = Object.assign({}, facultad, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_FACULTAD] (state, { payload, callback}) {
            const index = state.facultades.findIndex(facultad => {
                return facultad.id === payload.data.id
            })
            state.facultades.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_DEPARTAMENTO] (state, { payload, callback }) {
            state.departamentos.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_DEPARTAMENTO] (state, { payload, callback }) {
            const index = state.departamentos.findIndex(departamento => {
                return departamento.id === payload.data.id
            })
            const departamento = state.departamentos[index]
            state.departamentos[index] = Object.assign({}, departamento, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_DEPARTAMENTO] (state, { payload, callback}) {
            const index = state.departamentos.findIndex(departamento => {
                return departamento.id === payload.data.id
            })
            state.departamentos.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_RANGO] (state, { payload, callback }) {
            state.rangos.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_RANGO] (state, { payload, callback }) {
            const index = state.rangos.findIndex(rango => {
                return rango.id === payload.data.id
            })
            const rango = state.rangos[index]
            state.rangos[index] = Object.assign({}, rango, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_RANGO] (state, { payload, callback}) {
            const index = state.rangos.findIndex(rango => {
                return rango.id === payload.data.id
            })
            state.rangos.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_JERARQUIA] (state, { payload, callback }) {
            state.jerarquias.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_JERARQUIA] (state, { payload, callback }) {
            const index = state.jerarquias.findIndex(jerarquia => {
                return jerarquia.id === payload.data.id
            })
            const jerarquia = state.jerarquias[index]
            state.jerarquias[index] = Object.assign({}, jerarquia, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_JERARQUIA] (state, { payload, callback}) {
            const index = state.jerarquias.findIndex(jerarquia => {
                return jerarquia.id === payload.data.id
            })
            state.jerarquias.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_JORNADA] (state, { payload, callback }) {
            state.jornadas.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_JORNADA] (state, { payload, callback }) {
            const index = state.jornadas.findIndex(jornada => {
                return jornada.id === payload.data.id
            })
            const jornada = state.jornadas[index]
            state.jornadas[index] = Object.assign({}, jornada, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_JORNADA] (state, { payload, callback}) {
            const index = state.jornadas.findIndex(jornada => {
                return jornada.id === payload.data.id
            })
            state.jornadas.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_FACTOR] (state, { payload, callback }) {
            state.factores.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_FACTOR] (state, { payload, callback }) {
            const index = state.factores.findIndex(factor => {
                return factor.id === payload.data.id
            })
            const factor = state.factores[index]
            state.factores[index] = Object.assign({}, factor, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_FACTOR] (state, { payload, callback}) {
            const index = state.factores.findIndex(factor => {
                return factor.id === payload.data.id
            })
            state.factores.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_PERIODO] (state, { payload, callback }) {
            state.periodos.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_PERIODO] (state, { payload, callback }) {
            const index = state.periodos.findIndex(periodo => {
                return periodo.id === payload.data.id
            })
            const periodo = state.periodos[index]
            state.periodos[index] = Object.assign({}, periodo, payload.data)
            
            callback(true, payload)
        },
        [Mutations.DELETE_PERIODO] (state, { payload, callback}) {
            const index = state.periodos.findIndex(periodo => {
                return periodo.id === payload.data.id
            })
            state.periodos.splice(index, 1)
            callback(true, payload.mensaje.data)
        },
        [Mutations.INSERT_USUARIO] (state, { payload, callback }) {
            state.usuarios.push(payload.data)
            callback(true, payload)
        },
        [Mutations.UPDATE_USUARIO] (state, { payload, callback }) {
            const index = state.usuarios.findIndex(usuario => {
                return usuario.id === payload.data.id
            })
            const usuario = state.usuarios[index]
            state.usuarios[index] = Object.assign({}, usuario, payload.data)
            
            callback(true, payload)
        },
        [Mutations.UPDATE_FORMULA] (state, { payload, callback }) {
            state.formula = Object.assign({}, state.formula, payload.data)
            callback(true, payload)
        },
        [Mutations.HANDLE_ERROR] (state, { payload, callback }) {
            callback(false, payload)
        }
    },
    actions: {
        async [Actions.INIT_STORE] ({ dispatch, commit }, { step, callback }) {
            const rol = await dispatch(Actions.FETCH_AUTH_USER, callback)
            
            var promises = []
            promises.push(dispatch(Actions.FETCH_DECLARACIONES))

            var request = ['descripciones', 'factores', 'rangos']
            if(rol >= 1)
                request = request.concat(['facultades', 'departamentos', 'jerarquias', 'jornadas', 'usuarios', 'periodos'])
            
            request.forEach(r => {
                const promise = axios.get('/api/' + r)
                promises.push(promise)
                promise.then(response => {
                    commit(Mutations.SET_STATE_ARRAY, { key: r, payload: response })
                    step(promises.length)
                })
            })

            const promise = axios.get('/api/formulas')
            promises.push(promise)
            promise.then(response => {
                commit(Mutations.SET_STATE_OBJECT, { key: 'formula', payload: response })
                step(promises.length)
            })
            
            Promise.all(promises).then(() => {
                callback()
            })
        },
        async [Actions.FETCH_AUTH_USER] ({ commit }) {
            const response = await axios.get('/api/auth')
            commit(Mutations.SET_STATE_OBJECT, { key: 'auth', payload: response })
            return response.data.rol
        },
        [Actions.FETCH_DECLARACIONES] ({ commit }) {
            axios
                .get('/api/auth/declaraciones')
                .then(response => {
                    commit(Mutations.SET_STATE_ARRAY, { key: 'informes', payload: response })
                })
        },
        [Actions.INSERT_DECLARACION] ({ commit }, { informe, cb, payload }) {
            axios
                .post('/api/declaraciones', informe)
                .then(response => {
                    commit(Mutations.INSERT_DECLARACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_DECLARACION] ({ commit }, { informe, cb, payload }) {
            axios
                .put('/api/declaraciones/' + informe.id, informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.SEND_DECLARACION] ({ commit }, { informe, cb, payload }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/enviar', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.APPROVE_DECLARACION] ({ commit }, { informe, cb, payload }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/aprobar', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DECLINE_DECLARACION] ({ commit }, { informe, cb, payload }) {
            axios
                .put('/api/declaraciones/' + informe.id + '/revision', informe)
                .then(response => {
                    commit(Mutations.UPDATE_DECLARACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_APELACION] ({ commit }, { apelacion, cb, payload }) {
            axios
                .post('/api/apelaciones', formData(apelacion))
                .then(response => {
                    commit(Mutations.ATTACH_APELACION, { payload: { ...payload, data: response.data }, comision: apelacion.comision, callback: cb })
                }, e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.RESOLVE_APELACION] ({ commit }, { apelacion, cb, payload }) {
            axios
                .put('/api/apelaciones/' + apelacion.id, apelacion)
                .then(response => {
                    commit(Mutations.UPDATE_APELACION, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_FACULTAD] ({ commit }, { facultad, cb, payload }) {
            axios
                .post('/api/facultades', facultad)
                .then(response => {
                    commit(Mutations.INSERT_FACULTAD, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_FACULTAD] ({ commit }, { facultad, cb, payload }) {
            axios
                .put('/api/facultades/' + facultad.id, facultad)
                .then(response => {
                    commit(Mutations.UPDATE_FACULTAD, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_FACULTAD] ({ commit }, { facultad, cb, payload }) {
            axios
                .delete('/api/facultades/' + facultad.id, facultad)
                .then(response => {
                    commit(Mutations.DELETE_FACULTAD, { payload: {data: facultad, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_DEPARTAMENTO] ({ commit }, { departamento, cb, payload }) {
            axios
                .post('/api/departamentos', departamento)
                .then(response => {
                    commit(Mutations.INSERT_DEPARTAMENTO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_DEPARTAMENTO] ({ commit }, { departamento, cb, payload }) {
            axios
                .put('/api/departamentos/' + departamento.id, departamento)
                .then(response => {
                    commit(Mutations.UPDATE_DEPARTAMENTO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_DEPARTAMENTO] ({ commit }, { departamento, cb, payload }) {
            axios
                .delete('/api/departamentos/' + departamento.id, departamento)
                .then(response => {
                    commit(Mutations.DELETE_DEPARTAMENTO, { payload: {data: departamento, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_RANGO] ({ commit }, { rango, cb, payload }) {
            axios
                .post('/api/rangos', rango)
                .then(response => {
                    commit(Mutations.INSERT_RANGO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_RANGO] ({ commit }, { rango, cb, payload }) {
            axios
                .put('/api/rangos/' + rango.id, rango)
                .then(response => {
                    commit(Mutations.UPDATE_RANGO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_RANGO] ({ commit }, { rango, cb, payload }) {
            axios
                .delete('/api/rangos/' + rango.id, rango)
                .then(response => {
                    commit(Mutations.DELETE_RANGO, { payload: {data: rango, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_JERARQUIA] ({ commit }, { jerarquia, cb, payload }) {
            axios
                .post('/api/jerarquias', jerarquia)
                .then(response => {
                    commit(Mutations.INSERT_JERARQUIA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_JERARQUIA] ({ commit }, { jerarquia, cb, payload }) {
            axios
                .put('/api/jerarquias/' + jerarquia.id, jerarquia)
                .then(response => {
                    commit(Mutations.UPDATE_JERARQUIA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_JERARQUIA] ({ commit }, { jerarquia, cb, payload }) {
            axios
                .delete('/api/jerarquias/' + jerarquia.id, jerarquia)
                .then(response => {
                    commit(Mutations.DELETE_JERARQUIA, { payload: {data: jerarquia, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_JORNADA] ({ commit }, { jornada, cb, payload }) {
            axios
                .post('/api/jornadas', jornada)
                .then(response => {
                    commit(Mutations.INSERT_JORNADA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_JORNADA] ({ commit }, { jornada, cb, payload }) {
            axios
                .put('/api/jornadas/' + jornada.id, jornada)
                .then(response => {
                    commit(Mutations.UPDATE_JORNADA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_JORNADA] ({ commit }, { jornada, cb, payload }) {
            axios
                .delete('/api/jornadas/' + jornada.id, jornada)
                .then(response => {
                    commit(Mutations.DELETE_JORNADA, { payload: {data: jornada, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_FACTOR] ({ commit }, { factor, cb, payload }) {
            axios
                .post('/api/factores', factor)
                .then(response => {
                    commit(Mutations.INSERT_FACTOR, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_FACTOR] ({ commit }, { factor, cb, payload }) {
            axios
                .put('/api/factores/' + factor.id, factor)
                .then(response => {
                    commit(Mutations.UPDATE_FACTOR, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_FACTOR] ({ commit }, { factor, cb, payload }) {
            axios
                .delete('/api/factores/' + factor.id, factor)
                .then(response => {
                    commit(Mutations.DELETE_FACTOR, { payload: {data: factor, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_PERIODO] ({ commit }, { periodo, cb, payload }) {
            axios
                .post('/api/periodos', periodo)
                .then(response => {
                    commit(Mutations.INSERT_PERIODO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_PERIODO] ({ commit }, { periodo, cb, payload }) {
            axios
                .put('/api/periodos/' + periodo.id, periodo)
                .then(response => {
                    commit(Mutations.UPDATE_PERIODO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.DELETE_PERIODO] ({ commit }, { periodo, cb, payload }) {
            axios
                .delete('/api/periodos/' + periodo.id, periodo)
                .then(response => {
                    commit(Mutations.DELETE_PERIODO, { payload: {data: periodo, mensaje: response}, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_USUARIO] ({ commit }, { usuario, cb, payload }) {
            axios
                .post('/api/usuarios', usuario)
                .then(response => {
                    commit(Mutations.INSERT_USUARIO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_USUARIO] ({ commit }, { usuario, cb, payload }) {
            axios
                .put('/api/usuarios/' + usuario.id, usuario)
                .then(response => {
                    commit(Mutations.UPDATE_USUARIO, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.INSERT_FORMULA] ({ commit }, { formula, cb, payload }) {
            axios
                .POST('/api/formulas/', formula)
                .then(response => {
                    commit(Mutations.UPDATE_FORMULA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
        [Actions.UPDATE_FORMULA] ({ commit }, { formula, cb, payload }) {
            axios
                .put('/api/formulas/' + formula.id, formula)
                .then(response => {
                    commit(Mutations.UPDATE_FORMULA, { payload: { ...payload, data: response.data }, callback: cb })
                })
                .catch(e => {
                    commit(Mutations.HANDLE_ERROR, { payload: { ...payload, error: e }, callback: cb })
                })
        },
    }
})

export default store