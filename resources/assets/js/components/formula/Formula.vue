<template>  
    <div>
        <ol class="breadcrumb">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li class="active">Fórmulas</li>
        </ol>
        <div v-if="mensaje === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading panel-title text-center">
                        Horas equivalentes
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Horas semanales</td>
                                <td>
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.equivalente.f += 'se'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Horas semestrales</td>
                                <td>
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.equivalente.f += 'sa'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Decimales:</label>
                                <input class="form-control" type="number" min=0 v-model="formulas.equivalente.decimales"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Fórmula:</label>
                                <textarea v-model="formulas.equivalente.f" class="form-control" rows=10></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading panel-title text-center">
                        Calificación final
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" rowspan="2">Item</th>
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
                            <tr v-for="(value, key) in titulos_item" :key="value">
                                <td>{{ titulos_item[key] }}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_sem_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_anio_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_eq_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_sem_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_anio_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_eq_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td class="td-margin"></td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'nota_' + key">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-right"><b>TOTAL</b></th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_semanal'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_anual'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'comprometido_eq'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_semanal'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_anual'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <th class="text-center">
                                    <button class="btn btn-xs btn-success" v-on:click="formulas.nota_final.f += 'realizado_eq'">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </button>
                                </th>
                                <td class="td-margin"></td>
                                <th class="text-center"></th>
                            </tr>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Decimales:</label>
                                <input class="form-control" type="number" min=0 v-model="formulas.nota_final.decimales"/>
                            </div>
                            <div class="form-group col-md-10">
                                <label>Fórmula:</label>
                                <textarea v-model="formulas.nota_final.f" class="form-control" rows=10></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="mensaje === 1" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">[Cerrar &times;]</a>
            <a href="#" class="close" aria-label="close" v-on:click="volver('inicio')">[Volver] </a>
            <strong>Bien!</strong> Se han guardado los cambios.
        </div>
        <div class="panel panel-default">
            <div class="panel-footer">
                <button type="button" class="btn btn-info" v-on:click="actualizar">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>&ensp;Guardar
                </button>
                <button type="button" class="btn btn-success" v-on:click="crear">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&ensp;Crear
                </button>
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
                formulas: {
                    equivalente: {
                        f: '',
                        decimales: 0
                    },
                    nota_final: {
                        f: '',
                        decimales: 0
                    },
                },
                mensaje: 0
            }
        },
        created: function() {
            const formulas = Object.assign({}, this.form, this.copy(this.formula))
            var subformula = formulas.equivalente.substring(11, formulas.equivalente.lenght)
            this.formulas.equivalente.decimales = this.decimales(subformula) 
            this.formulas.equivalente.f = subformula.substring(0, subformula.length - (7 + (this.formulas.equivalente.decimales + 1) * 2))

            subformula = formulas.nota_final.substring(11, formulas.nota_final.lenght)
            this.formulas.nota_final.decimales = this.decimales(subformula)
            this.formulas.nota_final.f = subformula.substring(0, subformula.length - (7 + (this.formulas.nota_final.decimales + 1) * 2))
        },
        methods: {
            callback: function(ok = false, payload) {
                this.mensaje = ok ? 1 : -1
            },
            actualizar: function() {
                var formulas = this.construir()
                formulas['id'] = this.formula.id
                this.$store.dispatch(UPDATE_FORMULA, { formula: formulas, cb: this.callback })
            },
            crear: function() {
                this.$store.dispatch(INSERT_FORMULA, { formula: this.construir(), cb: this.callback }) 
            },
            decimales: function(formula) {
                var decimales = 0, i = formula.length - 1
                while(formula[i] !== '1') {
                    decimales++
                    i--
                }
                return decimales
            },
            construir: function() {
                var formulas = {
                    equivalente: '',
                    nota_final: ''
                }
                var decimales = '1' + '0'.repeat(this.formulas.equivalente.decimales)
                formulas.equivalente = 'Math.round(' + this.formulas.equivalente.f + ' * ' + decimales + ') / ' + decimales
                decimales = '1' + '0'.repeat(this.formulas.nota_final.decimales)
                formulas.nota_final = 'Math.round(' + this.formulas.nota_final.f + ' * ' + decimales + ') / ' + decimales 
                return formulas
            }
        },
        computed: mapState(['formula'])
    }
</script>