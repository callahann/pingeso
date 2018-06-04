<template>
    <div class="col-md-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
                <li><router-link :to="{ name: 'informes'}">Listado</router-link></li>
                <li class="active">Informe de Actividades</li>
            </ol>
        </div>
        <div class="row" v-if="etapa === etapas.aprobando || etapa === etapas.evaluando">
            <datos-personales v-bind:editable="false"></datos-personales>
        </div>
        <div class="row" v-if="etapa >= etapas.evaluando">
            <evaluacion v-if="!cargando" :informe="informe" :etapa="etapa"></evaluacion>
            <div class="panel panel-default text-center" v-if="cargando">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
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
                <div class="text-center" v-if="cargando">
                    <h3>
                        <i class="fas fa-circle-notch fa-spin"></i> 
                        Cargando...
                    </h3>
                </div>
                <div class="tab-content" v-else>
                    <div :id="key" v-for="(value, key) in  informe" :key="key"
                        class="tab-pane fade" :class="{ 'in active': key === 'item_docencia' }"
                        v-if="key.startsWith('item')">
                        <lista-actividades :previo="value.actividades" :etapa="etapa"
                            v-on:actualizar="value.actividades = $event"></lista-actividades>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mensajes -->
        <div class="row">
            <div v-if="mensaje === 1" class="alert alert-success">
                <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">Cerrar &times;</a>
                <a href="#" class="close" aria-label="close" v-on:click="volver">Volver</a>
                <strong>Bien!</strong> Se han guardado los cambios.
            </div>
            <div v-if="mensaje === -1" class="alert alert-danger">
                <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
                <strong>Oh no!</strong> Ha ocurrido un error.
            </div>
        </div>
        <!-- Modal resumen -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-footer">
                    <button v-if="etapa <= etapas.declarando" type="button" class="btn btn-default" data-toggle="modal"
                        data-target="#resumen" v-on:click="resumenAbierto = true">Ver resumen</button>
                    <button v-if="informe.id === undefined" type="button" class="btn btn-info" v-on:click="enviar">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    </button>
                    <button v-else type="button" class="btn btn-info" v-on:click="actualizar">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    </button>
                    <button v-if="etapa === etapas.aprobando" type="button" class="btn btn-success" v-on:click="aprobar">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Aprobar
                    </button>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="resumen" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                            v-on:click="resumenAbierto = false">&times;</button>
                        <h4 class="modal-title">Resumen de items</h4>
                    </div>
                    <resumen-declaraciones
                        v-bind:informe="informe"
                        v-bind:abierto="resumenAbierto"></resumen-declaraciones>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                            v-on:click="resumenAbierto = false">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import DatosPersonales from '../DatosPersonales.vue';
    import Evaluacion from './partes/Evaluacion';
    import ListaActividades from './partes/ListaActividades';
    import Resumen from './partes/Resumen';

    export default {
        props: ['etapa'],
        data: function() {
            return {
                resumenAbierto: false,
                informe: {
                    periodo: 2018,
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
                    }
                },
                cargando: true,
                mensaje: 0
            }
        },
        components: {
            'datos-personales': DatosPersonales,
            'evaluacion': Evaluacion,
            'lista-actividades': ListaActividades,
            'resumen-declaraciones': Resumen,
        },
        created: function() {
            console.log('Etapa: ' + this.etapa);
            this.obtener();
        },
        methods: {
            obtener: function() {
                axios
                    .get('/api/declaraciones/' + this.$route.params.id)
                    .then(response => { 
                        console.log("Se ha obtenido la data. Copiando localmente...");
                        Object.assign(this.informe, response.data);
                        this.cargando = false;
                    })
                    .catch(e => {
                        console.log(e);
                        this.cargando = false;
                    });
            },
            enviar: function() {
                axios
                    .post('/api/declaraciones', this.informe)
                    .then(response => {
                        console.log('Se ha registrado el informe correctamente');
                        this.informe = response.data;
                        this.mensaje = 1;
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
            actualizar: function() {
                axios
                    .put('/api/declaraciones/' + this.$route.params.id, this.informe)
                    .then(response => { 
                        console.log("Se han actualizado los datos!");
                        this.mensaje = 1;
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
            aprobar: function(estado) {
                axios
                    .get('/api/declaraciones/' + this.$route.params.id + '/aprobar')
                    .then(response => { 
                        console.log(this.volver('Se ha aprobado la declaración'));
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
            volver: function(mensaje) {
                this.$router.push({
                    name: 'informes',
                    params: mensaje === undefined ? {} : { mensaje: mensaje }
                });
                return mensaje;
            }
        }
    }
</script>
