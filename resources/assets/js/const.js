import Vue from 'vue'
import { mapState } from 'vuex'

/**
 * Etapas del proceso, la cual se guarda en un periodo. Cada
 * periodo (por departamento) puede tener un valor de etapa
 * distinto.
 */
const EtapasEnum = Object.freeze({
    declarando: 1,
    aprobando: 2,
    realizado: 3,
    evaluando: 4,
    apelando: 5
})

/**
 * Variables y métodos globales para la aplicación.
 */
Vue.mixin({
    data: function() {
        return {
            /**
             * Títulos para mostrar en las pestañas de la ListaActividades,
             * de acuerdo al "key" del ítem dentro del formulario (iterable).
             */
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
            /**
             * Estados de una declaración. El estado 0 y 1 permiten editar al
             * académico. El estado 2 permite aprobar la declaración por parte
             * del Director. El estado 3 es necesario para las siguientes etapas
             * del proceso.
             */
            estados: Object.freeze({
                editable: 0,
                revisar: 1,
                enviado: 2,
                aprobado: 3
            }),
            /**
             * Códigos de rol de la plataforma. Utilizado para bloquear rutas
             * y condicionar la visualización de las vistas y componentes.
             */
            rol: Object.freeze({
                academico: 0,
                director: 1,
                admin: 2
            }),
            rolesComision: Object.freeze({
                comision: 0,
                suplente: 1
            }),
            comision: Object.freeze({
                superior: 0,
                facultad: 1,
                departamental: 2
            }),
            etiquetas: {
                comision: [
                    'Comisión superior',
                    'Comisión de facultad',
                    'Comisión departamental'
                ],
                etapa: [
                    'Declaración / Aprobación',
                    'Informar trabajo realizado',
                    'Evaluación',
                    'Apelación'
                ],
                estado: [
                    'No enviado',
                    'Revisar',
                    'Esperando aprobación',
                    'Aprobado'
                ],
                rol: [
                    'Académico',
                    'Director de departamento',
                    'Administrador'
                ],
                rolComision: [
                    'Fijo',
                    'Suplente',
                    'Externo'
                ]
            }
        }
    },
    methods: {
        /**
         * Redirige a la ruta indicada, con un mensaje para mostrar
         * en la vista a la cual se redirige.
         * @param route Nombre de la ruta a la cual se redirige (router.js)
         * @param mensaje Mensaje para mostrar en la vista a la cual se redirige
         * @return el mensaje, para ser utilizado, por ejemplo, con console.log
         */
        volver: function(route, mensaje = undefined) {
            this.$router.push({ name: route })
            this.$root.$emit('alert', { mensaje, class: 'success' })
            return mensaje
        },
        /**
         * Crea una copia de un objeto sin referencias.
         * @param source Objeto que se copiará
         * @param deep Realiza una copia en profundidad
         * @return copia de "source"
         */
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
        /**
         * Todos los componentes tendrán disponible globalmente el objeto
         * "auth", que corresponde a la información del usuario con sesión
         * activa en la plataforma.
         */
        ...mapState(['auth'])
    }
})

export { EtapasEnum }