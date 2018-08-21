<template>  
    <div>
        <ol class="breadcrumb">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li class="active">Fórmulas</li>
        </ol>
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
                }
            }
        },
        created: function() {
            // Crea una copia de las fórmulas actuales
            const formulas = Object.assign({}, this.form, this.copy(this.formula))
            
            // Descompone la fórmula para horas equivalentes
            var subformula = formulas.equivalente.substring(11, formulas.equivalente.lenght)
            this.formulas.equivalente.decimales = this.decimales(subformula) 
            this.formulas.equivalente.f = subformula.substring(0, subformula.length - (7 + (this.formulas.equivalente.decimales + 1) * 2))

            // Descompone la fórmula para calificación final
            subformula = formulas.nota_final.substring(11, formulas.nota_final.lenght)
            this.formulas.nota_final.decimales = this.decimales(subformula)
            this.formulas.nota_final.f = subformula.substring(0, subformula.length - (7 + (this.formulas.nota_final.decimales + 1) * 2))
        },
        methods: {
            /**
             * Callback para mostrar un mensaje luego de obtener respuesta
             * desde la API.
             * @param ok Indica si la operación se realizó correctamente
             * @param payload Data (respuesta) obtenida desde la API
             */
            callback: function(ok = false, payload) {
                this.$root.$emit('alert', {
                    mensaje: ok ? payload.mensaje : '<strong>Oh no!</strong> Ha ocurrido un error.',
                    class: ok ? 'success' : 'danger'
                })
            },
            /**
             * Actualiza el objeto fórmula actual en la base de datos
             */
            actualizar: function() {
                if(confirm('ATENCIÓN: actualizar la fórmula actual afectará al cálculo de la calificación y horas equivalentes de todos los informes que la utilicen. ¿Continuar?')) {
                    var formulas = this.construir()
                    formulas['id'] = this.formula.id
                    const payload = {
                        mensaje: '<strong>¡Bien!</strong> Se ha actualizado las fórmulas.',
                        volver: false
                    }
                    this.$store.dispatch(UPDATE_FORMULA, { formula: formulas, cb: this.callback, payload })
                }
            },
            /**
             * Ingresa un nuevo objeto fórmula en la base de datos.
             */
            crear: function() {
                if(confirm('ATENCIÓN: al crear una nueva fórmula, ésta se aplicará a todos los informes que se creen a partir de ese momento. ¿Continuar?')) {
                    const payload = {
                        mensaje: '<strong>¡Bien!</strong> Se ha ingresado las nuevas fórmulas.',
                        volver: false
                    }
                    this.$store.dispatch(INSERT_FORMULA, { formula: this.construir(), cb: this.callback, payload }) 
                }
            },
            /**
             * Determina la cantidad de decimales que utiliza la fórmula dada
             * @return Cantidad de decimales
             */
            decimales: function(formula) {
                var decimales = 0, i = formula.length - 1
                while(formula[i] !== '1') {
                    decimales++
                    i--
                }
                return decimales
            },
            /**
             * Construye el objeto "formula" que se almacenará en la base de datos. Este objeto
             * incluye las fórmulas finales en formato String.
             * @return Objeto formula
             */
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