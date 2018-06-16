<template>
    <div>
        <div v-if="actividades.length == 0" class="text-center">
            <h3 class="inline-text" v-if="etapa <= etapas.evaluando">
                No se ha agregado actividades aún. Presione el botón 
                <b class="btn-text">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar actividad
                </b>
            </h3>
            <h3 v-else>No se declararon actividades para este ítem</h3>
        </div>
        <div v-else>
            <!-- Declarando / Aprobando -->
            <table class="table table-striped" v-if="etapa <= etapas.aprobando">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">
                            Descripción
                            <a class="badge" data-toggle="tooltip" data-placement="top"
                                title="Breve descripción de la tarea a realizar">?</a>
                        </th>
                        <th class="text-center" colspan="2">Primer semestre</th>
                        <th class="text-center" colspan="2">Segundo semestre</th>
                        <th class="text-center" rowspan="2">
                            Observaciones
                            <a class="badge" data-toggle="tooltip" data-placement="top"
                                title="Agregue una observación respecto a esta tarea para presentarla al Director de Departamento">?</a>
                        </th>
                        <th rowspan="2"></th>
                    </tr>
                    <tr>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(actividad, index) in actividades" v-bind:key="actividad.id">
                        <td class="col-md-3">
                            <select class="form-control" v-if="descripciones.length > 0 && !actividad.otra"
                                v-model="actividad.descripcion" v-on:change="otra(actividad)">
                                <option disabled value="">Seleccionar una...</option>
                                <option v-for="descripcion in descripciones" :key="descripcion.id">{{ descripcion.descripcion }}</option>
                                <option>Otra actividad...</option>
                            </select>
                            <div v-else class="input-group">
                                <input  class="form-control" v-model="actividad.descripcion" placeholder="Descripción de la actividad">
                                <div class="input-group-btn">
                                    <button class="btn btn-info" type="button" v-on:click="actividad.otra = false">
                                        <i class="glyphicon glyphicon-list"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.comprometido.primero.horasSemana">
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.comprometido.primero.horasSemestre">
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.comprometido.segundo.horasSemana">
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.comprometido.segundo.horasSemestre">
                        </td>
                        <td class="col-md-4">
                            <textarea class="form-control" rows=1 v-model="actividad.observaciones"></textarea>
                        </td>
                        <td class="col-md-1">
                            <button type="button" class="btn btn-block btn-danger"
                                v-on:click="quitarActividad(index)">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemestre }}</th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemestre }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tbody>
            </table>
            <!-- Realizado -->
            <table class="table table-striped" v-else-if="etapa === etapas.realizado">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="2">
                            Descripción
                            <a class="badge" data-toggle="tooltip" data-placement="top"
                                title="Breve descripción de la tarea a realizar">?</a>
                        </th>
                        <th class="text-center" colspan="2">Horas semana</th>
                        <th class="text-center" colspan="2">Horas semestre</th>
                        <th class="text-center" rowspan="2">
                            Observaciones
                            <a class="badge" data-toggle="tooltip" data-placement="top"
                                title="Agregue una observación respecto a esta tarea para presentarla al Director de Departamento">?</a>
                        </th>
                    </tr>
                    <tr>
                        <th class="text-center">Declarado</th>
                        <th class="text-center">Realizado</th>
                        <th class="text-center">Declarado</th>
                        <th class="text-center">Realizado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(actividad) in actividades" v-bind:key="actividad.id">
                        <td class="col-md-3">
                            {{ actividad.descripcion }}
                        </td>
                        <td class="col-md-1 text-center">
                            {{ actividad.comprometido[semestre].horasSemana }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado[semestre].horasSemana">
                        </td>
                        <td class="col-md-1 text-center">
                            {{ actividad.comprometido[semestre].horasSemestre }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado[semestre].horasSemestre">
                        </td>
                        <td class="col-md-4">
                            <textarea class="form-control" rows=1 v-model="actividad.observaciones"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">{{ totales.comprometido[semestre].horasSemana }}</th>
                        <th class="text-center">{{ totales.realizado[semestre].horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido[semestre].horasSemestre }}</th>
                        <th class="text-center">{{ totales.realizado[semestre].horasSemestre }}</th>
                        <th colspan="2"></th>
                    </tr>
                </tbody>
            </table>
            <!-- Evaluando -->
            <table class="table table-striped" v-else>
                <thead>
                    <tr>
                        <th class="text-center" rowspan="3">
                            Descripción
                            <a class="badge" data-toggle="tooltip" data-placement="top"
                                title="Breve descripción de la tarea a realizar">?</a>
                        </th>
                        <th class="text-center" colspan="4">Primer semestre</th>
                        <th class="text-center" colspan="4">Segundo semestre</th>
                        <th class="text-center" rowspan="3">Observaciones</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">Comprometido</th>
                        <th class="text-center" colspan="2">Realizado</th>
                        <th class="text-center" colspan="2">Comprometido</th>
                        <th class="text-center" colspan="2">Realizado</th>
                    </tr>
                    <tr>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                        <th class="text-center">Hrs. semana</th>
                        <th class="text-center">Hrs. semestre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(actividad) in actividades" v-bind:key="actividad.id">
                        <td class="col-md-3">
                            {{ actividad.descripcion }}
                        </td>
                        <td class="text-center">{{ actividad.comprometido.primero.horasSemana }}</td>
                        <td class="text-center">{{ actividad.comprometido.primero.horasSemestre }}</td>
                        <td class="text-center">{{ actividad.realizado.primero.horasSemana }}</td>
                        <td class="text-center">{{ actividad.realizado.primero.horasSemestre }}</td>
                        <td class="text-center">{{ actividad.comprometido.segundo.horasSemana }}</td>
                        <td class="text-center">{{ actividad.comprometido.segundo.horasSemestre }}</td>
                        <td class="text-center">{{ actividad.realizado.segundo.horasSemana }}</td>
                        <td class="text-center">{{ actividad.realizado.segundo.horasSemestre }}</td>
                        <td class="col-md-4">{{ actividad.observaciones }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemestre }}</th>
                        <th class="text-center" :style="{ color: totales.realizado.primero.diffSemanal >= 0 ? 'green' : 'red' }">
                            {{ totales.realizado.primero.horasSemana }} ({{ (totales.realizado.primero.diffSemanal >= 0 ? '+' : '') + totales.realizado.primero.diffSemanal }})
                        </th>
                        <th class="text-center" :style="{ color: totales.realizado.primero.diffSemestral >= 0 ? 'green' : 'red' }">
                            {{ totales.realizado.primero.horasSemestre }} ({{ (totales.realizado.primero.diffSemestral >= 0 ? '+' : '') + totales.realizado.primero.diffSemestral }})
                        </th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemestre }}</th>
                        <th class="text-center" :style="{ color: totales.realizado.segundo.diffSemanal >= 0 ? 'green' : 'red' }">
                            {{ totales.realizado.segundo.horasSemana }} ({{ (totales.realizado.segundo.diffSemanal >= 0 ? '+' : '') + totales.realizado.segundo.diffSemanal }})
                        </th>
                        <th class="text-center" :style="{ color: totales.realizado.segundo.diffSemestral >= 0 ? 'green' : 'red' }">
                            {{ totales.realizado.segundo.horasSemestre }} ({{ (totales.realizado.segundo.diffSemestral >= 0 ? '+' : '') + totales.realizado.segundo.diffSemestral }})
                        </th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right" v-if="etapa === etapas.declarando">
            <button type="button" class="btn btn-success" v-on:click="agregarActividad">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar actividad
            </button>
        </div>
        <div class="panel-footer" v-if="etapa === etapas.realizado">
            <b>Semestre: </b>
            <label class="radio-inline"><input type="radio" v-model="semestre" value="primero">Primero</label>
            <label class="radio-inline"><input type="radio" v-model="semestre" value="segundo">Segundo</label>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        props: ['previo', 'etapa', 'tipo'],
        data: function () {
            return {
                id: 1,
                actividades: [],
                descripciones: [],
                semestre: 'primero'
            }
        },
        created: function() {
            this.actividades = Object.assign([], this.actividades, this.previo);

            let cuenta = this.actividades.length; 
            if(cuenta > 0) this.id = this.actividades[cuenta - 1].id;

            if(this.etapa <= this.etapas.aprobando)
                axios
                    .get('/api/all/descripciones/' + this.tipo)
                    .then(response => {
                        this.descripciones = response.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
        },
        methods: {
            nuevoItem: function() {
                return {
                    id: this.id++,
                    descripcion: '',
                    otra: false,
                    comprometido: {
                        primero: {
                            horasSemana: 0,
                            horasSemestre: 0,
                        },
                        segundo: {
                            horasSemana: 0,
                            horasSemestre: 0,
                        }
                    },
                    realizado: {
                        primero: {
                            horasSemana: 0,
                            horasSemestre: 0,
                        },
                        segundo: {
                            horasSemana: 0,
                            horasSemestre: 0,
                        }
                    }
                }
            },
            agregarActividad: function() {
                let item = this.nuevoItem();
                item['id'] = this.id++;
                this.actividades.push(item);
            },
            quitarActividad: function(index) {
                this.actividades.splice(index, 1);
            },
            otra: function(actividad) {
                if(actividad.descripcion === 'Otra actividad...') {
                    actividad.descripcion = '';
                    actividad.otra = true;
                }
            }
        },
        watch: {
            actividades: function(newActividades) {
                this.$emit('actualizar', newActividades);
                Vue.nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        },
        computed: {
            totales: function() {
                let totales = this.nuevoItem();
                
                this.actividades.forEach(function(actividad) {
                    ['comprometido', 'realizado'].forEach((parte) => {
                        ['primero', 'segundo'].forEach((semestre) => {
                            ['horasSemana', 'horasSemestre'].forEach((hora) => {
                                totales[parte][semestre][hora] += actividad[parte][semestre][hora];
                            })
                        })
                    })
                });
                
                totales.realizado.primero['diffSemanal'] =  totales.realizado.primero.horasSemana - totales.comprometido.primero.horasSemana;
                totales.realizado.primero['diffSemestral'] =  totales.realizado.primero.horasSemestre - totales.comprometido.primero.horasSemestre;
                totales.realizado.segundo['diffSemanal'] =  totales.realizado.segundo.horasSemana - totales.comprometido.segundo.horasSemana;
                totales.realizado.segundo['diffSemestral'] =  totales.realizado.segundo.horasSemestre - totales.comprometido.segundo.horasSemestre;

                return totales;
            }
        }
    }
</script>
