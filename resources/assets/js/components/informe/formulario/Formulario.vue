<template>
    <div>
        <div class="col-md-12 alert text-center" v-if="cargando">
            <i class="fa fa-circle-notch fa-spin" aria-hidden="true" style="font-size: 10em"></i>&ensp;
            <h3>Cargando...</h3>
        </div>
        <div class="col-md-12" v-else>
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
                <div class="panel panel-default text-center" v-if="cargandoApelacion">
                    <h3>
                        <i class="fas fa-circle-notch fa-spin"></i> 
                        Cargando...
                    </h3>
                </div>
                <apelacion :previo="apelacion" v-on:actualizar="apelacion = $event" v-else></apelacion>
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
                        <button v-if="informe.id === undefined" type="button" class="btn btn-info" v-on:click="enviar">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        </button>
                        <button v-else-if="etapa <= etapas.evaluando" type="button" class="btn btn-info" v-on:click="actualizar">
                            <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                        </button>
                        <button v-else type="button" class="btn btn-success" v-on:click="enviarApelacion">
                            <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar apelación
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
    import axios from 'axios';
    import ListaActividades from './partes/ListaActividades';
    import Apelacion from './partes/Apelacion';
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
                apelacion: {
                    id_declaracion: 0
                },
                cargando: true,
                cargandoApelacion: true,
                mensaje: 0
            }
        },
        components: {
            'lista-actividades': ListaActividades,
            'resumen': Resumen,
        },
        created: function() {
            axios
                .get('/api/declaraciones/' + this.$route.params.id)
                .then(response => { 
                    console.log("Se ha obtenido la data. Copiando localmente...");
                    this.informe = Object.assign({}, this.informe, response.data);

                    if(this.etapa >= this.etapas.evaluando) {
                        this.apelacion.id_declaracion = this.informe.id;
                        this.obtenerApelacion();
                    }
                        
                    this.cargando = false;
                })
                .catch(e => {
                    console.log(e);
                    this.cargando = false;
                });
        },
        methods: {
            enviar: function() {
                let formData = this.formData(this.informe);
                axios
                    .post('/api/declaraciones', formData)
                    .then(response => {
                        console.log('Se ha registrado el informe correctamente');
                        this.informe = Object.assign({}, this.informe, response.data);
                        this.mensaje = 1;
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
            actualizar: function() {
                let formData = this.formData(this.informe);
                axios
                    .put('/api/declaraciones/' + this.$route.params.id, formData)
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
                        console.log(this.volver('informes', 'Se ha aprobado la declaración'));
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
            obtenerApelacion: function() {
                axios
                    .get('/api/apelaciones/' + this.informe.id)
                    .then(response => { 
                        console.log("Se ha obtenido la apelación. Copiando localmente...");
                        this.apelacion = Object.assign({}, this.apelacion, response.data);
                        this.cargandoApelacion = false;
                    })
                    .catch(e => {
                        console.log(e);
                        this.cargandoApelacion = false;
                    });
            },
            enviarApelacion: function() {
                let formData = this.formData(this.apelacion);
                axios
                    .post('/api/apelaciones', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(this.volver('informes', 'Se ha registrado la apelación correctamente'));
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            },
        }
    }
</script>
