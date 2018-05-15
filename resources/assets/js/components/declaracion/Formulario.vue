<template>
    <div class="col-md-12">
        <div v-if="error" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="error = false">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
        </div>
        <div v-if="correcto" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="correcto = false">&times;</a>
            <strong>Bien!</strong> Se han guardado los cambios.
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
                <div class="tab-content">
                    <div id="docencia" class="tab-pane fade in active">
                        <lista-items :inicial="declaraciones[0]" :cargando="cargando"
                            v-on:actualizar="declaraciones[0] = $event"></lista-items>
                    </div>
                    <div id="invdes" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[1]" :cargando="cargando"
                                v-on:actualizar="declaraciones[1] = $event"></lista-items>
                    </div>
                    <div id="asistec" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[2]" :cargando="cargando"
                                v-on:actualizar="declaraciones[2] = $event"></lista-items>
                    </div>
                    <div id="perf" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[3]" :cargando="cargando"
                                v-on:actualizar="declaraciones[3] = $event"></lista-items>
                    </div>
                    <div id="adminacad" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[4]" :cargando="cargando"
                                v-on:actualizar="declaraciones[4] = $event"></lista-items>
                    </div>
                    <div id="extension" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[5]" :cargando="cargando"
                                v-on:actualizar="declaraciones[5] = $event"></lista-items>
                    </div>
                    <div id="educont" class="tab-pane fade">
                        <lista-items :inicial="declaraciones[6]" :cargando="cargando"
                                v-on:actualizar="declaraciones[6] = $event"></lista-items>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-toggle="modal"
                        data-target="#resumen" v-on:click="resumenAbierto = true">Ver resumen</button>
                    <button v-if="nuevo" type="button" class="btn btn-success" v-on:click="enviar">Enviar</button>
                    <else v-else>
                        <button type="button" class="btn btn-info" v-on:click="actualizar()">Guardar cambios</button>
                        <button type="button" class="btn btn-success" v-on:click="aprobar()">Aprobar</button>
                    </else>
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
                        <h4 class="modal-title">Resumen de declaraciones</h4>
                    </div>
                    <div class="modal-body">
                        <resumen-declaraciones
                            v-bind:declaraciones="declaraciones"
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
    export default {
        props: ['id'],
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
                cargando: true,
                nuevo: true,
                declaraciones: [[], [], [], [], [], [], []],
                correcto: false,
                error: false
            }
        },
        created: function() {
            axios.get('/declaraciones/' + this.id)
            .then(response => {
                let declaracion = response.data;
                this.declaraciones[0] = declaracion.docencia_comp || [];
                this.declaraciones[1] = declaracion.investigacion_comp || [];
                this.declaraciones[2] = declaracion.asistencia_comp || [];
                this.declaraciones[3] = declaracion.perfeccionamiento_comp || [];
                this.declaraciones[4] = declaracion.administracion_comp || [];
                this.declaraciones[5] = declaracion.extension_comp || [];
                this.declaraciones[6] = declaracion.educacion_continua_comp || [];
                this.cargando = false;
                this.nuevo = false;
            })
            .catch(e => {
                console.log(e);
            });
        },
        methods: {
            getBody: function() {
                return {
                    periodo: 2018,
                    docencia_comp: this.declaraciones[0],
                    investigacion_comp: this.declaraciones[1],
                    asistencia_comp: this.declaraciones[2],
                    perfeccionamiento_comp: this.declaraciones[3],
                    administracion_comp: this.declaraciones[4],
                    extension_comp: this.declaraciones[5],
                    educacion_continua_comp: this.declaraciones[6]
                }
            },
            enviar: function() {
                axios.post('/api/declaraciones', this.getBody())
                .then(response => { 
                    console.log("Se han registado los datos!");
                    window.location.href = '/declaraciones';
                })
                .catch(e => { console.log(e); this.error = true });
            },
            actualizar: function() {
                axios.put('/api/declaraciones/' + this.id, this.getBody())
                .then(response => { 
                    console.log("Se han actualizado los datos!!");
                    this.correcto = true;
                })
                .catch(e => { console.log(e); this.error = true });
            },
            aprobar: function(estado) {
                axios.get('/declaraciones/' + this.id + '/aprobar')
                .then(response => { 
                    console.log("Se han aprobado la declaración!");
                    window.location.href = '/declaraciones';
                })
                .catch(e => { console.log(e); this.error = true });
            }
        }
    }
</script>
