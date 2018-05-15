<template>
    <div>
        <div class="panel-body">
            <div v-if="items.length == 0" class="text-center">
                <h3>No se han agregado items aún. Presione el botón "+"</h3>
            </div>
            <div v-else>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">
                                Descripción
                                <a class="badge" data-toggle="tooltip" data-placement="top"
                                    title="Ingrese una breve descripción de la tarea">?</a>
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
                        <tr v-for="(item, index) in items" v-bind:key="item.id">
                            <td class="col-md-3">
                                <input class="form-control" v-model="item.descripcion">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="item.primero.horasSemana">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="item.primero.horasSemestre">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="item.segundo.horasSemana">
                            </td>
                            <td class="col-md-1">
                                <input type="number" class="form-control" min=1 v-model.number="item.segundo.horasSemestre">
                            </td>
                            <td class="col-md-4">
                                <textarea class="form-control" rows=1 v-model="item.observaciones"></textarea>
                            </td>
                            <td class="col-md-1">
                                <button type="button" class="btn btn-block btn-danger"
                                    v-on:click="quitarItem(index)"
                                    v-bind:class="{ disabled: items.length == 1 }">
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
            <button type="button" class="btn btn-success" v-on:click="nuevoItem">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['inicial', 'cargando'],
        data: function () {
            return {
                id: 1,
                items: []
            }
        },
        mounted: function() {
            this.items = this.inicial;
        },
        methods: {
            nuevoItem: function() {
                this.items.push(
                    {
                        id: this.id++,
                        descripcion: '',
                        primero: {
                            horasSemana: 1,
                            horasSemestre: 1,
                        },
                        segundo: {
                            horasSemana: 1,
                            horasSemestre: 1,
                        },
                        observaciones: ''
                    }
                );
            },
            quitarItem: function(index) {
                this.items.splice(index, 1);
            }
        },
        watch: {
            cargando: function(newValue) {
                if(!newValue) this.items = this.inicial;
            },
            items: function(newItems) {
                this.$emit('actualizar', newItems);
                Vue.nextTick(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            }
        },
        computed: {
            totales: function() {
                let totales = {
                    primero: {
                        horasSemana: 0,
                        horasSemestre: 0
                    },
                    segundo: {
                        horasSemana: 0,
                        horasSemestre: 0
                    }
                };

                this.items.forEach(function(item) {
                    totales.primero.horasSemana += item.primero.horasSemana;
                    totales.primero.horasSemestre += item.primero.horasSemestre;
                    totales.segundo.horasSemana += item.segundo.horasSemana;
                    totales.segundo.horasSemestre += item.segundo.horasSemestre;
                });

                return totales;
            }
        }
    }
</script>
