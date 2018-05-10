<template>
    <div>
        <div class="col-md-10 col-md-offset-1">
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
                            <lista-items v-on:actualizar="declaraciones[0] = $event"></lista-items>
                        </div>
                        <div id="invdes" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[1] = $event"></lista-items>
                        </div>
                        <div id="asistec" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[2] = $event"></lista-items>
                        </div>
                        <div id="perf" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[3] = $event"></lista-items>
                        </div>
                        <div id="adminacad" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[4] = $event"></lista-items>
                        </div>
                        <div id="extension" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[5] = $event"></lista-items>
                        </div>
                        <div id="educont" class="tab-pane fade">
                            <lista-items v-on:actualizar="declaraciones[6] = $event"></lista-items>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default" data-toggle="modal"
                            data-target="#resumen" v-on:click="resumenAbierto = true">Ver resumen</button>
                        <button type="button" class="btn btn-success" v-on:click="enviarDeclaracion">Enviar</button>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div id="resumen" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
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
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data: function() {
            return {
                resumenAbierto: false,
                datosPersonales: {},
                declaraciones: [[], [], [], [], [], [], []]
            }
        },
        methods: {
            enviarDeclaracion: function() {
                axios.post('/api/declaraciones',
                {
                    periodo: 2018,
                    docencia_comp: this.declaraciones[0],
                    investigacion_comp: this.declaraciones[1],
                    asistencia_comp: this.declaraciones[2],
                    perfeccionamiento_comp: this.declaraciones[3],
                    administracion_comp: this.declaraciones[4],
                    extension_comp: this.declaraciones[5],
                    educacion_continua_comp: this.declaraciones[6],
                })
                .then(response => { console.log("Se han registado los datos!") })
                .catch(e => { console.log(e) });
            }
        }
    }
</script>
