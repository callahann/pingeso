<template>
    <div class="panel panel-default">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Item</th>
                    <th class="text-center" colspan="2">Comprometido</th>
                    <th class="text-center" colspan="2">Realizado</th>
                    <th class="text-center" rowspan="2">Horas eq. semanales realizadas</th>
                    <th class="text-center">Reservado comisión</th>
                </tr>
                <tr>
                    <th class="text-center">Horas semana</th>
                    <th class="text-center">Horas año</th>
                    <th class="text-center">Horas semana</th>
                    <th class="text-center">Horas año</th>
                    <th class="text-center">Calificación parcial</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, key) in resumenes" v-bind:key="key">
                    <td>{{ titulos_item[key] }}</td>
                    <td class="text-center">{{ value.comprometido.horasSemana }}</td>
                    <td class="text-center">{{ value.comprometido.horasAnio }}</td>
                    <td class="text-center">{{ value.realizado.horasSemana }}</td>
                    <td class="text-center">{{ value.realizado.horasAnio }}</td>
                    <td class="text-center">{{ value.realizado.equivalente }}</td>
                    <td class="col-md-2" v-if="etapa === etapas.evaluando">
                        <input type="number" class="form-control" min=1 max=7 v-model.number="informe[key].calificacion">
                    </td>
                    <td class="text-center" v-else>{{ informe[key].calificacion }}</td>
                </tr>
                <tr>
                    <th><b>Horas cronológicas promedio anual</b></th>
                    <th class="text-center"><b>{{ totales.comprometido.semanal }}</b></th>
                    <th class="text-center"><b>{{ totales.comprometido.anual }}</b></th>
                    <th class="text-center"><b>{{ totales.realizado.semanal }}</b></th>
                    <th class="text-center"><b>{{ totales.realizado.anual }}</b></th>
                    <td rowspan="2"></td>
                    <th class="text-center"><b>Calificación final y rango</b></th>
                </tr>
                <tr>
                    <th><b>Horas semanales equivalentes</b></th>
                    <th colspan="2" class="text-center"><b>{{ totales.comprometido.equivalente  }}</b></th>
                    <th colspan="2" class="text-center"><b>{{ totales.realizado.equivalente  }}</b></th>
                    <th class="text-center" :style="{ color: rango.color }">{{ calificacion }} - {{ rango.leyenda }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['informe', 'etapa'],
        data: function() {
            return {
                c: 20, // Para redondear con dos decimales. NO CAMBIAR
                resumenes: {},
                totales: {
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
                },
                rangos: [{
                    base: 0.01,
                    tope: 1.49,
                    leyenda: 'Insuficiente',
                    color: 'red'
                },{
                    base: 1.50,
                    tope: 1.99,
                    leyenda: 'Condicional',
                    color: 'orange'
                },{
                    base: 2.00,
                    tope: 2.79,
                    leyenda: 'Aceptable',
                    color: 'yellow'
                },{
                    base: 2.80,
                    tope: 3.69,
                    leyenda: 'Bueno',
                    color: 'green'
                },{
                    base: 3.70,
                    tope: 7.00,
                    leyenda: 'Sobresaliente',
                    color: 'blue'
                }]
            }
        },
        created: function() {                
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
                            this.resumenes[itemKey][parte].horasSemana += (actividad[parte].primero.horasSemana + actividad[parte].segundo.horasSemana) / 2;
                            this.resumenes[itemKey][parte].horasAnio += actividad[parte].primero.horasSemestre + actividad[parte].segundo.horasSemestre;
                        });

                        this.totales[parte].semanal += this.resumenes[itemKey][parte].horasSemana;
                        this.totales[parte].anual += this.resumenes[itemKey][parte].horasAnio;
                        
                        this.resumenes[itemKey][parte].equivalente = this.equivalentes(this.resumenes[itemKey][parte].horasSemana, this.resumenes[itemKey][parte].horasAnio);
                        this.totales[parte].equivalente += this.resumenes[itemKey][parte].equivalente;
                    });
                }
            }
        },
        computed: {
            calificacion: function() {
                if (this.totales.realizado.equivalente === 0) return 0;
                
                var final = 0;
                for(var itemKey in this.resumenes) 
                    final += this.resumenes[itemKey].realizado.equivalente * this.informe[itemKey].calificacion;
                return Math.round(final / this.totales.realizado.equivalente * 100) / 100;
            },
            rango: function() {
                let calificacion = this.calificacion;
                var rango = undefined;
                this.rangos.forEach((opcion) => {
                    if(opcion.base <= calificacion && calificacion <= opcion.tope) rango = opcion;
                });
                return rango || {
                    leyenda: 'No definido',
                    color: 'black'
                };
            }
        }
    }
</script>