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
            <div class="row" v-if="(etapa === etapas.apelando && auth.rol.id === rol.academico) || apelado">
                <apelacion :apelaciones="informe.apelaciones" :actual="informe.periodo.actual" v-on:actualizar="apelacion = $event"></apelacion>
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
                        <button v-if="informe.periodo.actual && etapa === etapas.apelando && auth.rol.id === rol.academico" type="button" class="btn btn-success" v-on:click="apelar">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar apelación
                        </button>
                        <button v-else-if="apelado" type="button" class="btn btn-success" v-on:click="resuelto">
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
                resumenAbierto: false,
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
                    apelaciones: undefined,
                    formula: {},
                    periodo: {},
                    usuario: undefined,
                    estado: 0
                },
                apelacion: {},
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
            if(this.$route.params.id) {
                const informe = this.informes.find(informe => {
                    return informe.id === this.$route.params.id
                })
                this.informe = Object.assign({}, this.informe, informe)
            } else {
                this.informe.formula = this.formula
                this.informe.periodo = this.auth.departamento.periodo
                this.informe.usuario = this.auth
            }
        },
        methods: {
            cbMensaje: function(ok = false, payload) {
                this.mensaje = ok ? 1 : -1
                this.informe = Object.assign({}, this.informe, payload)
            },
            cbVolver: function(ok = false, payload) {
                if(ok) this.volver('informes', this.mensajeVolver)
                this.mensaje = -1
            },
            actualizar: function() {
                this.$store.dispatch(
                    this.informe.id === undefined ? INSERT_DECLARACION : UPDATE_DECLARACION,
                    { informe: this.informe, cb: this.cbMensaje }
                )
            },
            enviar: async function() {
                if(confirm('¿Está seguro que desea enviar esta declaración?')) {
                    this.mensajeVolver = 'Se ha enviado la declaración al Director de Departamento'
                    this.$store.dispatch(SEND_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            aprobar: async function(estado) {
                if(confirm('¿Está seguro que desea aprobar esta declaración?')) {
                    this.mensajeVolver = 'Se ha aprobado la declaración'
                    this.$store.dispatch(APPROVE_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            revision: async function(estado) {
                if(confirm('¿Está seguro que desea solicitar revisión para esta declaración?')) {
                    this.mensajeVolver = 'Se ha solicitado la revisión de la declaración'
                    this.$store.dispatch(DECLINE_DECLARACION, { informe: this.informe, cb: this.cbVolver })
                }
            },
            apelar: function() {
                this.apelacion.id_declaracion = this.informe.id;
                let formData = this.formData(this.apelacion)
                this.mensajeVolver = 'Se ha registrado la apelación correctamente'
                this.$store.dispatch(INSERT_APELACION, { apelacion: formData, cb: this.cbVolver })
            },
            resuelto: function() {
                this.mensajeVolver = 'Se ha marcado como resuelto'
                this.$store.dispatch(RESOLVE_APELACION, { informe: this.informe, cb: this.cbVolver })
            }
        },
        computed: {
            ...mapState(['formula', 'informes']),
            apelado: function() {
                return this.informe.apelaciones.find(apelacion => {
                    return apelacion.actual
                }) !== undefined
            }
        }
    }
</script>
