<template>
    <div>
        <div v-if="actividades.length == 0" class="text-center">
            <h3 class="inline-text" v-if="etapa === etapas.declarando">
                No se ha agregado actividades aún. Presione el botón 
                <b class="btn-text">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar actividad
                </b>
            </h3>
            <h3 v-else>No se declararon actividades para este ítem</h3>
        </div>
        <div v-else>
            <!-- Declarando -->
            <table class="table table-striped" v-if="etapa === etapas.declarando">
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
                            <p v-if="actividad.observaciones.director.length > 0"><b>Director: </b>{{ actividad.observaciones.director }}</p>
                            <textarea class="form-control" rows=1 v-model="actividad.observaciones.academico"></textarea>
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
            <!-- Aprobando -->
            <table class="table table-striped" v-else-if="etapa === etapas.aprobando">
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
                                title="Agregue una observación respecto a esta tarea">?</a>
                        </th>
                    </tr>
                    <tr>
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
                        <td class="text-center">{{ actividad.comprometido.segundo.horasSemana }}</td>
                        <td class="text-center">{{ actividad.comprometido.segundo.horasSemestre }}</td>
                        <td class="col-md-4">
                            <p v-if="actividad.observaciones.academico.length > 0"><b>Académico: </b>{{ actividad.observaciones.academico }}</p>
                            <textarea class="form-control" rows=1 v-model="actividad.observaciones.director"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.primero.horasSemestre }}</th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido.segundo.horasSemestre }}</th>
                        <th></th>
                    </tr>
                </tbody>
            </table>
            <!-- Realizado -->
            <table class="table table-striped" v-else-if="etapa === etapas.realizado">
                <thead>
                    <tr>
                        <th class="text-center" rowspan="3">Descripción</th>
                        <th class="text-center" colspan="4">Primer semestre</th>
                        <th class="text-center" colspan="4">Segundo semestre</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="2">Horas semana</th>
                        <th class="text-center" colspan="2">Horas semestre</th>
                        <th class="text-center" colspan="2">Horas semana</th>
                        <th class="text-center" colspan="2">Horas semestre</th>
                    </tr>
                    <tr>
                        <th class="text-center">Declarado</th>
                        <th class="text-center">Realizado</th>
                        <th class="text-center">Declarado</th>
                        <th class="text-center">Realizado</th>
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
                            {{ actividad.comprometido.primero.horasSemana }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado.primero.horasSemana">
                        </td>
                        <td class="col-md-1 text-center">
                            {{ actividad.comprometido.primero.horasSemestre }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado.primero.horasSemestre">
                        </td>
                        <td class="col-md-1 text-center">
                            {{ actividad.comprometido.segundo.horasSemana }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado.segundo.horasSemana">
                        </td>
                        <td class="col-md-1 text-center">
                            {{ actividad.comprometido.segundo.horasSemestre }}
                        </td>
                        <td class="col-md-1">
                            <input type="number" class="form-control" min=0 v-model.number="actividad.realizado.segundo.horasSemestre">
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">TOTAL</th>
                        <th class="text-center">{{ totales.comprometido[semestre].horasSemana }}</th>
                        <th class="text-center">{{ totales.realizado[semestre].horasSemana }}</th>
                        <th class="text-center">{{ totales.comprometido[semestre].horasSemestre }}</th>
                        <th class="text-center">{{ totales.realizado[semestre].horasSemestre }}</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right" v-if="etapa === etapas.declarando">
            <button type="button" class="btn btn-success" v-on:click="agregarActividad">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar actividad
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['previo', 'etapa', 'tipo'],
        data: function () {
            return {
                id: 1,
                /**
                 * Lista de actividades de este ítem.
                 */
                actividades: [],
                /**
                 * Lista de descripciones de actividades predefinidas, disponibles
                 * a través de una lista desplegable.
                 */
                descripciones: []
            }
        },
        created: function() {
            this.actividades = Object.assign([], this.actividades, this.previo)
            const cuenta = this.actividades.length 
            if(cuenta > 0) this.id = this.actividades[cuenta - 1].id

            const descripciones = this.$store.state.descripciones.filter(descripcion => {
                return descripcion.tipo === this.tipo;
            });
            this.descripciones = Object.assign([], this.descripciones, descripciones);
        },
        methods: {
            /**
             * Crea un nuevo objeto de actividad.
             * @return Nueva actividad
             */
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
                    },
                    observaciones: {
                        academico: '',
                        director: ''
                    }
                }
            },
            /**
             * Agrega una nueva actividad a la lista de actividades de
             * este componente.
             */
            agregarActividad: function() {
                const item = this.nuevoItem()
                item['id'] = this.id++
                this.actividades.push(item)
            },
            /**
             * Quita la actividad con el índice señalado de la lista de
             * actividades de este componente.
             * @param index Índice de la actividad en la lista
             */
            quitarActividad: function(index) {
                this.actividades.splice(index, 1)
            },
            /**
             * Muestra la caja de texto editable si se ha seleccionado la actividad
             * "Otras actividades..." en la lista desplegable.
             */
            otra: function(actividad) {
                if(actividad.descripcion === 'Otra actividad...') {
                    actividad.descripcion = ''
                    actividad.otra = true
                }
            }
        },
        watch: {
            /**
             * Observa y envía las modificaciones de la lista de actividades
             * al componente padre.
             */
            actividades: function(newActividades) {
                this.$emit('actualizar', newActividades)
                Vue.nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            }
        },
        computed: {
            /**
             * Calcula las horas totales de las actividades ingresadas en este
             * componente.
             */
            totales: function() {
                const totales = this.nuevoItem()
                
                this.actividades.forEach(function(actividad) {
                    ['comprometido', 'realizado'].forEach((parte) => {
                        ['primero', 'segundo'].forEach((semestre) => {
                            ['horasSemana', 'horasSemestre'].forEach((hora) => {
                                totales[parte][semestre][hora] += actividad[parte][semestre][hora]
                            })
                        })
                    })
                })
                
                totales.realizado.primero['diffSemanal'] =  totales.realizado.primero.horasSemana - totales.comprometido.primero.horasSemana
                totales.realizado.primero['diffSemestral'] =  totales.realizado.primero.horasSemestre - totales.comprometido.primero.horasSemestre
                totales.realizado.segundo['diffSemanal'] =  totales.realizado.segundo.horasSemana - totales.comprometido.segundo.horasSemana
                totales.realizado.segundo['diffSemestral'] =  totales.realizado.segundo.horasSemestre - totales.comprometido.segundo.horasSemestre

                return totales
            }
        }
    }
</script>
