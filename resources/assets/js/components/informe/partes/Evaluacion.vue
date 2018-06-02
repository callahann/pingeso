<template>
    <div class="panel panel-default">
        <div class="panel-body">
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
                        <td class="text-center">{{ Math.round(value.comprometido.horasSemana * posDec) / posDec }}</td>
                        <td class="text-center">{{ Math.round(value.comprometido.horasAnio * posDec) / posDec }}</td>
                        <td class="text-center">{{ Math.round(value.realizado.horasSemana * posDec) / posDec }}</td>
                        <td class="text-center">{{ Math.round(value.realizado.horasAnio * posDec) / posDec }}</td>
                        <td class="text-center">{{ Math.round(value.realizado.equivalente * posDec) / posDec }}</td>
                        <td class="col-md-2">
                            <input type="number" class="form-control" min=1 v-model.number="value.nota">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Horas cronológicas promedio anual</b></td>
                        <td class="text-center"><b>{{ Math.round(totales.comprometido.semanal * posDec) / posDec }}</b></td>
                        <td class="text-center"><b>{{ Math.round(totales.comprometido.anual * posDec) / posDec }}</b></td>
                        <td class="text-center"><b>{{ Math.round(totales.realizado.semanal * posDec) / posDec }}</b></td>
                        <td class="text-center"><b>{{ Math.round(totales.realizado.anual * posDec) / posDec }}</b></td>
                        <td class="text-center"><b>Semanales realizadas</b></td>
                        <td class="text-center"><b>Calificación final y rango</b></td>
                    </tr>
                    <tr>
                        <td><b>Horas semanales equivalentes</b></td>
                        <td colspan="2" class="text-center"><b>{{ Math.round((totales.comprometido.semanal * 36 + totales.comprometido.anual) / 44  * posDec) / posDec }}</b></td>
                        <td colspan="2" class="text-center"><b>{{ Math.round((totales.realizado.semanal * 36 + totales.realizado.anual) / 44  * posDec) / posDec }}</b></td>
                        <td class="text-center">{{ Math.round(totales.realizado.equivalente  * posDec) / posDec }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['informe'],
        data: function() {
            return {
                posDec: 10, // Para redondear con un decimal. NO CAMBIAR
                resumenes: {},
                totales: {
                    comprometido: {
                        semanal: 0,
                        anual: 0
                    },
                    realizado: {
                        semanal: 0,
                        anual: 0,
                        equivalente: 0
                    }
                }
            }
        },
        created: function() {                
            for (var itemKey in this.informe) {
                if (itemKey.startsWith('item')) {
                    this.resumenes[itemKey] = {
                        comprometido: {
                            horasSemana: 0,
                            horasAnio: 0
                        },
                        realizado: {
                            horasSemana: 0,
                            horasAnio: 0,
                            equivalente: 0
                        }
                    };

                    ['comprometido', 'realizado'].forEach((parte) => {
                        this.informe[itemKey].forEach((item) => {
                            this.resumenes[itemKey][parte].horasSemana += (item[parte].primero.horasSemana + item[parte].segundo.horasSemana) / 2;
                            this.resumenes[itemKey][parte].horasAnio += item[parte].primero.horasSemestre + item[parte].segundo.horasSemestre;
                        });

                        this.totales[parte].semanal += this.resumenes[itemKey][parte].horasSemana;
                        this.totales[parte].anual += this.resumenes[itemKey][parte].horasAnio;
                    });

                    this.resumenes[itemKey].realizado.equivalente = (this.resumenes[itemKey].realizado.horasSemana * 36 + this.resumenes[itemKey].realizado.horasAnio) / 44;
                    this.totales.realizado.equivalente += this.resumenes[itemKey].realizado.equivalente;
                }
            }
        }
    }
</script>