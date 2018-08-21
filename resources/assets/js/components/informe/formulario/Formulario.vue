<template>
    <div>
        <div class="col-md-12">
            <div class="row">
                <ol class="breadcrumb">
                    <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
                    <li class="active">Informe de Actividades</li>
                </ol>
            </div>
            <div class="row" v-if="informe.usuario && (etapa === etapas.aprobando || etapa === etapas.evaluando)">
                <usuario v-bind:editable="false" :declarante="informe.usuario"></usuario>
            </div>
            <div class="row">
                <resumen :informe="informe" :etapa="etapa"
                    v-on:resumenes="informe.resumenes = $event"
                    v-on:totales="informe.totales = $event"
                    v-on:calificacion="informe.calificacion_final = $event"></resumen>
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
                    apelacion: {
                        apelado: false,
                        apelar: false,
                        comision: 0,
                        apelaciones: []
                    },
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
            if(this.$route.params.id) {
                const informes = this.informes.usuario.concat(this.informes.comision)
                const informe = informes.find(informe => {
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
            callback: function(ok = false, payload) {
                this.$root.$emit('alert', {
                    mensaje: ok ? payload.mensaje : '<strong>Oh no!</strong> Ha ocurrido un error.',
                    class: ok ? 'success' : 'danger'
                })
                this.informe = Object.assign({}, this.informe, payload.data)
                if(payload.volver && ok) this.$router.push({ name: 'inicio' })
            },
            /**
             * Despacha la acción para insertar un informe si no existe, o actualizarlo en caso contrario.
             */
            actualizar: function() {
                const payload = {
                    mensaje: '<strong>¡Bien!</strong> Se ha registrado los cambios.',
                    volver: false
                }
                this.$store.dispatch(
                    this.informe.id === undefined ? INSERT_DECLARACION : UPDATE_DECLARACION,
                    { informe: this.informe, cb: this.callback, payload }
                )
            },
            /**
             * Marca un informe con el estado de "enviado"
             */
            enviar: function() {
                this.$root.$emit('dismiss')
                if(confirm('Se enviará esta declaración al Director de Departamento. ¿Continuar?')) {
                    const payload = {
                        mensaje: 'Se ha enviado la declaración al Director de Departamento',
                        volver: true
                    }
                    this.$store.dispatch(SEND_DECLARACION, { informe: this.informe, cb: this.callback, payload })
                }
            },
            /**
             * Marca un informe con el estado de "aprobado"
             */
            aprobar: function() {
                this.$root.$emit('dismiss')
                if(confirm('Se aprobará esta declaración. ¿Continuar?')) {
                    const payload = {
                        mensaje: 'Se ha aprobado la declaración',
                        volver: true
                    }
                    this.$store.dispatch(APPROVE_DECLARACION, { informe: this.informe, cb: this.callback, payload })
                }
            },
            /**
             * Marca un informe con el estado de "revisar"
             */
            revision: function() {
                this.$root.$emit('dismiss')
                if(confirm('Se solicitará revisión de esta declaración al académico. ¿Continuar?')) {
                    const payload = {
                        mensaje: 'Se ha solicitado la revisión de la declaración',
                        volver: true
                    }
                    this.$store.dispatch(DECLINE_DECLARACION, { informe: this.informe, cb: this.callback, payload })
                }
            },
            /**
             * Ingresa una nueva apelación en la base de datos.
             */
            apelar: function() {
                this.$root.$emit('dismiss')
                if(confirm('Recuerde: sólo puede apelar una vez a cada comisión. ¿Continuar?')) {
                    this.apelacion.id_declaracion = this.informe.id;
                    const payload = {
                        mensaje: 'Se ha registrado la apelación correctamente',
                        volver: true
                    }
                    this.$store.dispatch(INSERT_APELACION, { apelacion: this.apelacion, cb: this.callback, payload })
                }
            },
            resuelto: function() {
                this.$root.$emit('dismiss')
                this.$store.dispatch(UPDATE_DECLARACION, { informe: this.informe, cb: () => {} })
                const payload = {
                    mensaje: 'Se ha marcado la apelación como resuelta.',
                    volver: true
                }
                this.$store.dispatch(RESOLVE_APELACION, { apelacion: this.apelacion, cb: this.callback, payload })
            }
        },
        computed: mapState(['formula', 'informes'])
    }
</script>
