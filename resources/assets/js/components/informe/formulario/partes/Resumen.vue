<template>
    <div class="panel panel-default">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Item</th>
                    <th class="text-center" colspan="3">Comprometido</th>
                    <th class="text-center" colspan="3" v-if="etapa >= etapas.realizado">Realizado</th>
                    <td class="td-margin" rowspan="2" v-if="etapa >= etapas.evaluando"></td>
                    <th class="text-center" v-if="etapa >= etapas.evaluando">Reservado comisión</th>
                </tr>
                <tr>
                    <th class="text-center">Horas semana</th>
                    <th class="text-center">Horas año</th>
                    <th class="text-center">Horas equivalentes</th>
                    <th class="text-center" v-if="etapa >= etapas.realizado">Horas semana</th>
                    <th class="text-center" v-if="etapa >= etapas.realizado">Horas año</th>
                    <th class="text-center" v-if="etapa >= etapas.realizado">Horas equivalentes</th>
                    <th class="text-center" v-if="etapa >= etapas.evaluando">Calificación parcial</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, key) in resumenes" v-bind:key="key">
                    <td>{{ titulos_item[key] }}</td>
                    <td class="text-center">{{ value.comprometido.horasSemana }}</td>
                    <td class="text-center">{{ value.comprometido.horasAnio }}</td>
                    <td class="text-center">{{ value.comprometido.equivalente }}</td>
                    <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.horasSemana }}</td>
                    <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.horasAnio }}</td>
                    <td class="text-center" v-if="etapa >= etapas.realizado">{{ value.realizado.equivalente }}</td>
                    <td class="td-margin" v-if="etapa >= etapas.evaluando"></td>
                    <td class="col-md-2" v-if="etapa >= etapas.evaluando">
                        <input type="number" class="form-control" min=1 max=7 
                            v-if="value.comprometido.equivalente > 0 && auth.comision !== null && etapa >= etapas.evaluando"
                            v-model.number="informe[key].calificacion">
                        <div class="text-center" v-else>{{ informe[key].calificacion }}</div>
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
                    <th class="text-center" v-if="etapa >= etapas.evaluando">
                        {{ calificacion }}
                    </th>
                </tr>
            </tbody>
        </table>
        <div v-if="etapa <= etapas.aprobando && estado.mensaje"
            :class="'alert alert-' + estado.clase"
            style="margin-bottom: 0">
            <strong>{{ estado.mensaje }}</strong>
        </div>
    </div>
</template>
<script>
    import { UPDATE_DECLARACION } from '../../../../vuex/actions'
    import { mapState } from 'vuex'

    export default {
        props: ['informe', 'etapa'],
        data: function() {
            return {
                /**
                 * Resumenes por ítem.
                 */
                resumenes: {},
                /**
                 * Horas totales por cada ítem.
                 */
                totales: {}
            }
        },
        created: function() {
            this.$root.$on('activities-changed', () => {
                this.actualizar()
            })       
            this.actualizar()  
        },
        methods: {
            /**
             * Calcula las horas equivalentes.
             * @param se Horas semana
             * @param sa Horas semestre / año
             * @return Horas equivalentes
             */
            equivalentes: function(se, sa) {
                const formula = this.informe.formula.equivalente
                return eval(formula.replaceAll('se', se).replaceAll('sa', sa))
            },
            /**
             * Re-calcula y actualiza este componente de acuerdo a los
             * últimos datos disponibles en el informe de actividades.
             */
            actualizar: function() {
                this.totales = {
                    comprometido: {
                        semanal: 0,
                        anual: 0,
                        equivalente: 0
                    },
                    realizado: {
                        semanal: 0,
                        anual: 0,
                        equivalente: 0
                    }
                }
                
                for (var itemKey in this.informe) {
                    if (itemKey.startsWith('item')) {
                        this.resumenes[itemKey] = {
                            comprometido: {
                                horasSemana: 0,
                                horasAnio: 0,
                                equivalente: 0
                            },
                            realizado: {
                                horasSemana: 0,
                                horasAnio: 0,
                                equivalente: 0
                            }
                        };

                        ['comprometido', 'realizado'].forEach((parte) => {
                            this.informe[itemKey].actividades.forEach((actividad) => {
                                this.resumenes[itemKey][parte].horasSemana += (actividad[parte].primero.horasSemana + actividad[parte].segundo.horasSemana) / 2
                                this.resumenes[itemKey][parte].horasAnio += actividad[parte].primero.horasSemestre + actividad[parte].segundo.horasSemestre
                            })

                            this.totales[parte].semanal += this.resumenes[itemKey][parte].horasSemana
                            this.totales[parte].anual += this.resumenes[itemKey][parte].horasAnio
                            
                            this.resumenes[itemKey][parte].equivalente = this.equivalentes(this.resumenes[itemKey][parte].horasSemana, this.resumenes[itemKey][parte].horasAnio)
                            this.totales[parte].equivalente += this.resumenes[itemKey][parte].equivalente
                        })

                        this.totales.comprometido.equivalente = Math.round(this.totales.comprometido.equivalente * 10) / 10
                        this.totales.realizado.equivalente = Math.round(this.totales.realizado.equivalente * 10) / 10
                    }
                }

                this.$root.$emit('update-resumenes-totales', { resumenes: this.resumenes, totales: this.totales })
            }
        },
        computed: {
            ...mapState(['factores', 'rangos']),
            /**
             * Calificación de este informe de acuerdo a las calificaciones parciales definidas
             * por la comisión y el factor de corrección correspondiente a la diferencia entre
             * la calificación mínima y máxima.
             * @return Calificación final
             */
            calificacion: function() {
                var formula = this.informe.formula.nota_final
                var min = 7, max = 1

                for (var itemKey in this.informe) {
                    if (itemKey.startsWith('item')) {
                        min = Math.min(min, this.informe[itemKey].calificacion)
                        max = Math.max(max, this.informe[itemKey].calificacion)

                        formula = formula
                                        .replaceAll('nota_' + itemKey, this.informe[itemKey].calificacion)
                                        .replaceAll('comprometido_eq_' + itemKey, this.resumenes[itemKey].comprometido.equivalente)
                                        .replaceAll('realizado_eq_' + itemKey, this.resumenes[itemKey].realizado.equivalente)
                    }
                }

                formula = formula
                                .replaceAll('comprometido_semanal', this.totales.comprometido.semanal)
                                .replaceAll('comprometido_anual', this.totales.comprometido.anual)
                                .replaceAll('comprometido_eq', this.totales.comprometido.equivalente)
                                .replaceAll('realizado_semanal', this.totales.realizado.semanal)
                                .replaceAll('realizado_anual', this.totales.realizado.anual)
                                .replaceAll('realizado_eq', this.totales.realizado.equivalente)

                var calificacion = eval(formula)
                const diferencia = max - min
                const factor = this.factores.find(factor => {
                    return diferencia <= factor.diferencia
                })
                calificacion *= factor.factor

                this.$root.$emit('update-calificacion', calificacion)
                return calificacion
            },
            /**
             * Comprueba la cantidad de horas ingresadas y la contrasta con la cantidad
             * de horas que debería declarar la persona de acuerdo a su jornada.
             * @return Objeto indicando un mensaje para el usuario.
             */
            estado: function() {
                const horas = this.auth.jornada.horas
                const diferencia = Math.round((horas - this.totales.comprometido.equivalente) * 10) / 10
                const mensaje = diferencia > 0 ? 'Aún falta declarar ' + diferencia + ' horas' :
                                Math.abs(diferencia) >= 0.3 * horas ? 'Se ha declarado ' + Math.abs(diferencia) + ' horas más' : undefined
                const clase = diferencia <= horas * 0.1 ? 'info' : diferencia <= horas * 0.4 ? 'warning' : 'danger'
                return { mensaje, clase }
            }
        }
    }
</script>