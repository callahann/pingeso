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
                enviado: 1,
                aprobado: 2
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
    },
    computed: {
        ...mapState(['auth'])
    }
})

export { EtapasEnum }