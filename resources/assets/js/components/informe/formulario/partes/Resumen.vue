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
                            v-if="etapa === etapas.evaluando"
                            v-model.number="informe[key].calificacion">
                        <p v-else>{{ informe[key].calificacion }}</p>
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
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        props: ['informe', 'etapa'],
        data: function() {
            return {
                resumenes: {},
                totales: {}
            }
        },
        created: function() {                
            this.actualizar()
        },
        methods: {
            equivalentes: function(se, sa) {
                const formula = this.informe.formula.equivalente
                return eval(formula.replaceAll('se', se).replaceAll('sa', sa))
            },
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
            }
        },
        computed: {
            ...mapState(['factores', 'rangos']),
            calificacion: function() {
                let formula = this.informe.formula.nota_final

                for (var itemKey in this.informe) {
                    if (itemKey.startsWith('item')) {
                        formula = formula
                                        .replaceAll('nota_' + itemKey, resumenes[itemKey].calificacion)
                                        .replaceAll('comprometido_eq_' + itemKey, totales[itemKey].comprometido.equivalente)
                                        .replaceAll('realizado_eq_' + itemKey, totales[itemKey].realizado.equivalente)
                    }
                }

                formula = formula
                                .replaceAll('comprometido_semanal' + itemKey, totales.comprometido.semanal)
                                .replaceAll('comprometido_anual' + itemKey, totales.comprometido.anual)
                                .replaceAll('comprometido_eq' + itemKey, totales.comprometido.equivalente)
                                .replaceAll('realizado_semanal' + itemKey, totales.realizado.semanal)
                                .replaceAll('realizado_anual' + itemKey, totales.realizado.anual)
                                .replaceAll('realizado_eq' + itemKey, totales.realizado.equivalente)

                return eval(formula)
            },
            rango: function() {
                let calificacion = this.calificacion
                const rango = this.rangos.find((rango) => {
                    return rango.base <= calificacion && calificacion <= rango.tope
                })
                return rango || {
                    leyenda: 'No definido',
                    color: 'black'
                }
            }
        },
        watch: {
            informe: {
                handler() {
                    this.actualizar()
                },
                deep: true
            }
        }
    }
</script>