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
            <div class="row" v-if="etapa === etapas.aprobando">
                <usuario v-bind:editable="false"></usuario>
            </div>
            <div class="row">
                <resumen :informe="informe" :etapa="etapa"></resumen>
            </div>
            <div class="row" v-if="apelacion.id !== undefined">
                <apelacion :previo="apelacion" v-on:actualizar="apelacion = $event"></apelacion>
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
                        <button v-if="informe.id === undefined" type="button" class="btn btn-info" v-on:click="insertar">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&ensp;Guardar
                        </button>
                        <button v-else-if="etapa <= etapas.evaluando" type="button" class="btn btn-info" v-on:click="actualizar">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&ensp;Guardar
                        </button>
                        <button v-else type="button" class="btn btn-success" v-on:click="enviarApelacion">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar apelación
                        </button>
                        <button v-if="etapa === etapas.declarando" type="button" class="btn btn-success" v-on:click="enviar">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar
                        </button>
                        <button v-if="etapa === etapas.aprobando" type="button" class="btn btn-success" v-on:click="aprobar">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aprobar
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
        APPROVE_DECLARACION
    } from '../../../vuex/actions'
    import { mapState } from 'vuex'
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
                    formula: {}
                },
                apelacion: {
                    id_declaracion: 0
                },
                mensaje: 0
            }
        },
        components: {
            'lista-actividades': ListaActividades,
            'resumen': Resumen,
        },
        created: function() {
            this.informe.formula = this.formulas.find(formula => {
                return formula.actual;
            })

            if(this.$route.params.id === undefined ) return;

            const informe = this.informes.find(informe => {
                return informe.id === this.$route.params.id
            })
            this.informe = Object.assign({}, this.informe, informe)
        },
        methods: {
            callback: function(ok = false, payload) {
                this.mensaje = ok ? 1 : -1
                this.informe = Object.assign({}, this.informe, payload)
            },
            insertar: function() {
                this.$store.dispatch(INSERT_DECLARACION, { informe: this.informe, cb: this.callback })
            },
            actualizar: function() {
                this.$store.dispatch(UPDATE_DECLARACION, { informe: this.informe, cb: this.callback })
            },
            enviar: function() {

            },
            aprobar: function(estado) {
                this.$store.dispatch(APPROVE_DECLARACION, { id: this.informe.id, cb: this.callback })
            },
            obtenerApelacion: function() {
                this.$http
                    .get('/api/apelaciones/' + this.informe.id)
                    .then(response => { 
                        console.log("Se ha obtenido la apelación. Copiando localmente...")
                        this.apelacion = Object.assign({}, this.apelacion, response.data)
                        this.cargandoApelacion = false
                    })
                    .catch(e => {
                        console.log(e)
                        this.cargandoApelacion = false
                    })
            },
            enviarApelacion: function() {
                let formData = this.formData(this.apelacion)
                this.$http
                    .post('/api/apelaciones', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(this.volver('informes', 'Se ha registrado la apelación correctamente'))
                    })
                    .catch(e => {
                        console.log(e)
                        this.mensaje = -1 
                    })
            },
        },
        computed: mapState(['formulas', 'informes'])
    }
</script>
