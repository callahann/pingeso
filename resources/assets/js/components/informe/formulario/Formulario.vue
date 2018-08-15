<template>
    <div>
        <div class="col-md-12">
            <div class="row">
                <ol class="breadcrumb">
                    <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
                    <li><router-link :to="{ name: 'informes'}">Listado</router-link></li>
                    <li class="active">Informe de Actividades</li>
                </ol>
            </div>
            <div class="row" v-if="informe.usuario && (etapa === etapas.aprobando || etapa === etapas.evaluando)">
                <usuario v-bind:editable="false" :declarante="informe.usuario"></usuario>
            </div>
            <div class="row">
                <resumen :informe="informe" :etapa="etapa"></resumen>
            </div>
            <div class="row" v-if="(etapa === etapas.apelando && auth.rol === rol.academico) || informe.apelacion.apelado">
                <apelacion :previo="informe.apelacion" :usuario="informe.usuario.id === auth.id"
                    v-on:actualizar="apelacion = $event"></apelacion>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading panel-tabs">
                        <ul class="nav nav-tabs text-center">
                            <li v-for="(value, key) in  informe" :key="key"
                                :class="{ active: key === 'item_docencia' }" v-if="key.startsWith('item')">
                                <a data-toggle="tab" :href="'#' + key">{{ titulos_item[key] }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div :id="key" v-for="(value, key, index) in  informe" :key="key"
                            class="tab-pane fade" :class="{ 'in active': key === 'item_docencia' }"
                            v-if="key.startsWith('item')">
                            <lista-actividades :previo="value.actividades" :etapa="etapa" :tipo="index + 1"
                                v-on:actualizar="value.actividades = $event"></lista-actividades>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensajes -->
            <div class="row">
                <div v-if="mensaje === 1" class="alert alert-success">
                    <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">[Cerrar &times;]</a>
                    <a href="#" class="close" aria-label="close" v-on:click="volver('informes')">[Volver] </a>
                    <strong>Bien!</strong> Se han guardado los cambios.
                </div>
                <div v-if="mensaje === -1" class="alert alert-danger">
                    <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
                    <strong>Oh no!</strong> Ha ocurrido un error.
                </div>
            </div>
            <!--Footer -->
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-footer">
                        <button v-if="etapa < etapas.apelando" type="button" class="btn btn-info" v-on:click="actualizar">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&ensp;Guardar
                        </button>
                        <button v-if="etapa === etapas.declarando && informe.id" type="button" class="btn btn-success" v-on:click="enviar">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar
                        </button>
                        <a v-if="etapa === etapas.aprobando">
                            <button type="button" class="btn btn-warning" v-on:click="revision">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Solicitar revisión
                            </button>
                            <button type="button" class="btn btn-success" v-on:click="aprobar">
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&ensp;Aprobar
                            </button>
                        </a>
                        <button v-if="etapa === etapas.apelando && informe.usuario.id === auth.id && informe.apelacion.apelar" type="button" class="btn btn-success" v-on:click="apelar">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar apelación
                        </button>
                        <button v-else-if="informe.usuario.id !== auth.id && informe.apelacion.apelado" type="button" class="btn btn-success" v-on:click="resuelto">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&ensp;Marcar resuelto
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {
        INSERT_DECLARACION,
        UPDATE_DECLARACION,
        SEND_DECLARACION,
        APPROVE_DECLARACION,
        DECLINE_DECLARACION,
        INSERT_APELACION,
        RESOLVE_APELACION
    } from '../../../vuex/actions'
    import { mapState } from 'vuex'
    import Usuario from '../../usuario/Usuario'
    import ListaActividades from './partes/ListaActividades'
    import Apelacion from './partes/Apelacion'
    import Resumen from './partes/Resumen'

    export default {
        props: ['etapa'],
        data: function() {
            return {
                /**
                 * Estructura inicial de un informe
                 */
                informe: {
                    item_docencia: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_investigacion: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_asistencia: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_perfeccionamiento: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_administracion: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_extension: {
                        actividades: [],
                        calificacion: 1
                    },
                    item_educacion_continua: {
                        actividades: [],
                        calificacion: 1
                    },
                    apelaciones: [null, null, null],
                    formula: {},
                    periodo: {},
                    resumenes: {},
                    totales: {},
                    calificacion_final: 0,
                    usuario: undefined,
                    estado: 0
                },
                /**
                 * Apelación del informe. Se guarda por separado cuando se
                 * edita (para enviar). Cuando se recibe (comisión) viene
                 * dentro del informe.
                 */
                apelacion: {},
                /**
                 * Código de mensaje.
                 * 0: No mostrar
                 * 1: Operación realizada correctamente
                 * -1: Mensaje de error
                 */
                mensaje: 0,
                mensajeVolver: ''
            }
        },
        components: {
            'usuario': Usuario,
            'lista-actividades': ListaActividades,
            'resumen': Resumen,
            'apelacion': Apelacion,
        },
        created: function() {
            this.$root.$on('update-resumenes-totales', (payload) => {
                this.informe.resumenes = payload.resumenes
                this.informe.totales = payload.totales
            })
            this.$root.$on('update-calificacion', (calificacion) => {
                this.informe.calificacion_final = calificacion
            })

            if(this.$route.params.id) {
                const informe = this.informes.find(informe => {
                    return informe.id === this.$route.params.id
                })
                this.informe = Object.assign({}, this.informe, this.copy(informe))
            } else {
                this.informe.formula = this.formula
                this.informe.periodo = this.auth.departamento.periodo
                this.informe.usuario = this.auth
            }
        },
        methods: {
            /**
             * Callback para mostrar un mensaje luego de obtener respuesta
             * desde la API.
             * @param ok Indica si la operación se realizó correctamente
             * @param payload Data (respuesta) obtenida desde la API
             */
            cbMensaje: function(ok = false, payload) {
                this.mensaje = ok ? 1 : -1
                this.informe = Object.assign({}, this.informe, payload)
            },
            /**
             * Callback para volver a la vista anterior si la operación se
             * completó sin errores, o mostrar un mensaje de error en caso
             * contrario.
             * @param ok Indica si la operación se realizó correctamente
             * @param payload Data (respuesta) obtenida desde la API
             */
            cbVolver: function(ok = false, payload) {
                console.log('Ok: ' + ok)
                if(ok) this.volver('informes', this.mensajeVolver)
                this.mensaje = -1
            },
            /**
             * Despacha la acción para insertar un informe si no existe, o actualizarlo en caso contrario.
             */
            actualizar: function() {
                this.$store.dispatch(
                    this.informe.id === undefined ? INSERT_DECLARACION : UPDATE_DECLARACION,
                    { informe: this.informe, cb: this.cbMensaje }
                )
            },
            /**
             * Marca un informe con el estado de "enviado"
             */
            enviar: async function() {
                if(confirm('¿Está seguro que desea enviar esta declaración?')) {
                    this.mensajeVolver = 'Se ha enviado la declaración al Director de Departamento'
                    this.$store.dispatch(SEND_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            /**
             * Marca un informe con el estado de "aprobado"
             */
            aprobar: async function(estado) {
                if(confirm('¿Está seguro que desea aprobar esta declaración?')) {
                    this.mensajeVolver = 'Se ha aprobado la declaración'
                    this.$store.dispatch(APPROVE_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            /**
             * Marca un informe con el estado de "revisar"
             */
            revision: async function(estado) {
                if(confirm('¿Está seguro que desea solicitar revisión para esta declaración?')) {
                    this.mensajeVolver = 'Se ha solicitado la revisión de la declaración'
                    this.$store.dispatch(DECLINE_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            /**
             * Ingresa una nueva apelación en la base de datos.
             */
            apelar: function() {
                if(confirm('Sólo puede apelar una vez a cada comisión. ¿Desea continuar?')) {
                    this.apelacion.id_declaracion = this.informe.id;
                    let formData = this.formData(this.apelacion)
                    this.mensajeVolver = 'Se ha registrado la apelación correctamente'
                    this.$store.dispatch(INSERT_APELACION, { apelacion: formData, cb: this.cbVolver })
                }
            },
            resuelto: function() {
                this.mensajeVolver = 'Se ha marcado como resuelto'
                this.$store.dispatch(RESOLVE_APELACION, { apelacion: this.apelacion, cb: this.cbVolver })
            }
        },
        computed: mapState(['formula', 'informes'])
    }
</script>
