<template>  
    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li class="active">Fórmulas</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="col-md-3">
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading panel-title text-center">
                    Fórmula para nota final
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="3">Comprometido</th>
                                <th class="text-center" colspan="3">Realizado</th>
                                <td class="td-margin" rowspan="2"></td>
                                <th class="text-center">Reservado comisión</th>
                            </tr>
                            <tr>
                                <th class="text-center">Horas semana</th>
                                <th class="text-center">Horas año</th>
                                <th class="text-center">Horas equivalentes</th>
                                <th class="text-center">Horas semana</th>
                                <th class="text-center">Horas año</th>
                                <th class="text-center">Horas equivalentes</th>
                                <th class="text-center">Calificación parcial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, key) in resumenes" v-bind:key="key">
                                <td class="text-center">
                                    <button>
                                </td>
                                <td class="text-center">{{ value.comprometido.horasAnio }}</td>
                                <td class="text-center">{{ value.comprometido.equivalente }}</td>
                                <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.horasSemana }}</td>
                                <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.horasAnio }}</td>
                                <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.equivalente }}</td>
                                <td class="td-margin" v-if="etapa >= etapas.evaluando"></td>
                                <td class="col-md-2" v-if="etapa >= etapas.evaluando">
                                    <input type="number" class="form-control" min=1 max=7 
                                        v-if="etapa === etapas.evaluando"
                                        v-model.number="informe[key].calificacion">
                                    <p class="text-center" v-else>{{ informe[key].calificacion }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right"><b>TOTAL</b></th>
                                <th class="text-center"><b>{{ totales.comprometido.semanal }}</b></th>
                                <th class="text-center"><b>{{ totales.comprometido.anual }}</b></th>
                                <th class="text-center"><b>{{ totales.comprometido.equivalente  }}</b></th>
                                <th class="text-center" v-if="etapa >= etapas.realizado"><b>{{ totales.realizado.semanal }}</b></th>
                                <th class="text-center" v-if="etapa >= etapas.realizado"><b>{{ totales.realizado.anual }}</b></th>
                                <th class="text-center" v-if="etapa >= etapas.realizado"><b>{{ totales.realizado.equivalente }}</b></th>
                                <td class="td-margin" v-if="etapa >= etapas.evaluando"></td>
                                <th class="text-center" :style="{ color: rango.color }" v-if="etapa >= etapas.evaluando">
                                    {{ calificacion }} - {{ rango.leyenda }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-success" v-on:click="addElem">
                        <span class="glyphicon glyphicon-send" aria-hidden="true"></span> {{this.accion}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        INSERT_FORMULA,
        UPDATE_FORMULA
    } from '../../vuex/actions'
    import { mapState } from 'vuex'

    export default {
        data: function() {
            return {
                form: {
                    equivalente: '',
                    nota_final: ''
                }
            }
        },
        created: function() {
            this.form = Object.assign({}, this.form, this.formula.copy())
        },
        methods: {
            callback: function(ok = false, payload) {
                this.mensaje = ok ? 1 : -1
            },
            actualizar: function() {
                this.$store.dispatch(UPDATE_FORMULA, { formula: this.form, cb: this.callback })
            },
            crear: function() {
                this.$store.dispatch(INSERT_FORMULA, { formula: this.form, cb: this.callback }) 
            }
        },
        computed: mapState(['formula'])
    }
</script>