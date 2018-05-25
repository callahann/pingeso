<template>
    <div>
        <div class="panel-body">
            <div v-if="actividades.length == 0" class="text-center">
                <h3>No se han agregado actividades aún. Presione el botón "+"</h3>
            </div>
            <div v-else>
                <table class="table table-striped">
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
                                <input class="form-control" v-model="actividad.descripcion">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="actividad.primero.horasSemana">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="actividad.primero.horasSemestre">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="actividad.segundo.horasSemana">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="actividad.segundo.horasSemestre">
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
                            <th class="text-center">{{ totales.primero.horasSemana }}</th>
                            <th class="text-center">{{ totales.primero.horasSemestre }}</th>
                            <th class="text-center">{{ totales.segundo.horasSemana }}</th>
                            <th class="text-center">{{ totales.segundo.horasSemestre }}</th>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button type="button" class="btn btn-success" v-on:click="agregarActividad">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['previo'],
        data: function () {
            return {
                id: 1,
                actividades: []
            }
        },
        created: function() {
            Object.assign(this.actividades, this.previo);
        },
        methods: {
            nuevoItem: function() {
                return {
                    primero: {
                        horasSemana: 0,
                        horasSemestre: 0,
                    },
                    segundo: {
                        horasSemana: 0,
                        horasSemestre: 0,
                    },
                }
            },
            agregarActividad: function() {
                let item = this.nuevoItem();
                item['id'] = this.id++;
                this.actividades.push(item);
            },
            quitarActividad: function(index) {
                this.actividades.splice(index, 1);
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
                    totales.primero.horasSemana += actividad.primero.horasSemana;
                    totales.primero.horasSemestre += actividad.primero.horasSemestre;
                    totales.segundo.horasSemana += actividad.segundo.horasSemana;
                    totales.segundo.horasSemestre += actividad.segundo.horasSemestre;
                });

                return totales;
            }
        }
    }
</script>
