import Vue from 'vue'
import { mapState } from 'vuex'

const EtapasEnum = Object.freeze({
    declarando: 1,
    aprobando: 2,
    realizado: 3,
    evaluando: 4,
    apelando: 5
})

Vue.mixin({
    data: function() {
        return {
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
            estados: Object.freeze({
                editable: 0,
                revisar: 1,
                enviado: 2,
                aprobado: 3,
                etiquetas: [
                    'No enviado',
                    'Revisar',
                    'Esperando aprobación',
                    'Aprobado'
                ]
            }),
            rol: Object.freeze({
                academico: 1,
                director: 2,
                comision: 3,
                admin: 4
            })
        }
    },
    methods: {
        formData: function(object) {
            let formData = new FormData()
            for (var key in object) {
                formData.append(key, object[key])
            }
            return formData
        },
        volver: function(route, mensaje = undefined) {
            this.$router.push({
                name: route,
                params: { 
                    mensaje: mensaje
                }
            })
            return mensaje
        },
        copy: function(source, deep = true) {
            var o, prop, type
            if (typeof source != 'object' || source === null) {
                o = source
                return o
            }
        
            o = new source.constructor();
            for (prop in source) {
                if (source.hasOwnProperty(prop)) {
                    type = typeof source[prop]
                    if (deep && type == 'object' && source[prop] !== null)
                        o[prop] = this.copy(source[prop])
                    else
                        o[prop] = source[prop]
                }
            }
            return o
        }
    },
    computed: {
        ...mapState(['auth'])
    }
})

export { EtapasEnum }