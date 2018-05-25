<template>
    <div class="col-md-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><router-link :to="{ name: 'home'}">Inicio</router-link></li>
                <li><router-link :to="{ name: 'informes'}">Listado</router-link></li>
                <li class="active">Informe de Actividades</li>
            </ol>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading panel-title text-center">Datos personales</div>
                <div class="panel-body">
                    <datos-personales v-bind:editable="false"
                        v-on:actualizar="datosPersonales = $event"></datos-personales>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading panel-tabs">
                    <ul class="nav nav-tabs text-center">
                        <li class="active"><a data-toggle="tab" href="#docencia">Docencia</a></li>
                        <li><a data-toggle="tab" href="#invdes">Investigación y desarrollo</a></li>
                        <li><a data-toggle="tab" href="#asistec">Asistencia técnica</a></li>
                        <li><a data-toggle="tab" href="#perf">Perfeccionamiento</a></li>
                        <li><a data-toggle="tab" href="#adminacad">Administración académica</a></li>
                        <li><a data-toggle="tab" href="#extension">Extensión</a></li>
                        <li><a data-toggle="tab" href="#educont">Educación continua</a></li>
                    </ul>
                </div>
                <div class="text-center" v-if="cargando">
                    <h3>
                        <i class="fas fa-circle-notch fa-spin"></i> 
                        Cargando...
                    </h3>
                </div>
                <div class="tab-content" v-else>
                    <div id="docencia" class="tab-pane fade in active">
                        <lista-actividades :previo="informe.docencia_comp"
                            v-on:actualizar="informe.docencia_comp = $event"></lista-actividades>
                    </div>
                    <div id="invdes" class="tab-pane fade">
                        <lista-actividades :previo="informe.investigacion_comp"
                                v-on:actualizar="informe.investigacion_comp = $event"></lista-actividades>
                    </div>
                    <div id="asistec" class="tab-pane fade">
                        <lista-actividades :previo="informe.asistencia_comp"
                                v-on:actualizar="informe.asistencia_comp = $event"></lista-actividades>
                    </div>
                    <div id="perf" class="tab-pane fade">
                        <lista-actividades :previo="informe.perfeccionamiento_comp"
                                v-on:actualizar="informe.perfeccionamiento_comp = $event"></lista-actividades>
                    </div>
                    <div id="adminacad" class="tab-pane fade">
                        <lista-actividades :previo="informe.administracion_comp"
                                v-on:actualizar="informe.administracion_comp = $event"></lista-actividades>
                    </div>
                    <div id="extension" class="tab-pane fade">
                        <lista-actividades :previo="informe.extension_comp"
                                v-on:actualizar="informe.extension_comp = $event"></lista-actividades>
                    </div>
                    <div id="educont" class="tab-pane fade">
                        <lista-actividades :previo="informe.educacion_continua_comp"
                                v-on:actualizar="informe.educacion_continua_comp = $event"></lista-actividades>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mensajes -->
        <div class="row">
            <div v-if="mensaje === 1" class="alert alert-success">
                <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
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
                    <button type="button" class="btn btn-default" data-toggle="modal"
                        data-target="#resumen" v-on:click="resumenAbierto = true">Ver resumen</button>
                    <button v-if="$route.params.id === undefined" type="button" class="btn btn-success" v-on:click="enviar">Enviar</button>
                    <a v-else>
                        <button type="button" class="btn btn-info" v-on:click="actualizar()">Guardar cambios</button>
                        <button type="button" class="btn btn-success" v-on:click="aprobar()">Aprobar</button>
                    </a>
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
                    <div class="modal-body">
                        <resumen-declaraciones
                            v-bind:informe="informe"
                            v-bind:abierto="resumenAbierto"></resumen-declaraciones>
                    </div>
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
    import DatosPersonales from '../../DatosPersonales.vue';
    import ListaActividades from './partes/ListaActividades';
    import Resumen from '../Resumen';

    export default {
        props: ['modo'],
        components: {
            'datos-personales': DatosPersonales,
            'lista-actividades': ListaActividades,
            'resumen-declaraciones': Resumen,
        },
        data: function() {
            return {
                resumenAbierto: false,
                datosPersonales: {
                    apellidoPaterno: 'Álvarez',
                    apellidoMaterno: 'Molina',
                    nombres: 'Mario Francisco',
                    facultad: 'Ingeniería',
                    departamento: 'Informática',
                    jerarquia: 'Cargo',
                    jornada: 'Jornada'
                },
                informe: {
                    periodo: 2018,
                    docencia_comp: [],
                    investigacion_comp: [],
                    asistencia_comp: [],
                    perfeccionamiento_comp: [],
                    administracion_comp: [],
                    extension_comp: [],
                    educacion_continua_comp: []
                },
                cargando: true,
                mensaje: 0
            }
        },
        created: function() {
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
        methods: {
            enviar: function() {
                axios
                    .post('/api/declaraciones', this.informe)
                    .then(response => { 
                        console.log(this.volver('Se ha registrado el informe correctamente'));
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
                    params: {
                        mensaje: mensaje
                    }
                });
                return mensaje;
            }
        }
    }
</script>
