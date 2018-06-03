<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Item</th>
                    <th class="text-center">Horas semana</th>
                    <th class="text-center">Horas año</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, key) in resumenes" v-bind:key="key">
                    <td>{{ titulos_item[key] }}</td>
                    <td class="text-center">{{ Math.round(value.horasSemana * posDec) / posDec }}</td>
                    <td class="text-center">{{ Math.round(value.horasAnio * posDec) / posDec }}</td>
                </tr>
                <tr>
                    <td><b>Horas cronológicas promedio anual</b></td>
                    <td class="text-center"><b>{{ Math.round(totales.semanal * posDec) / posDec }}</b></td>
                    <td class="text-center"><b>{{ Math.round(totales.anual * posDec) / posDec }}</b></td>
                </tr>
                <tr>
                    <td><b>Horas semanales equivalentes</b></td>
                    <td colspan="2" class="text-center"><b>{{ (Math.round((totales.semanal * 36 + totales.anual) / 44  * posDec) / posDec) }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['informe', 'abierto'],
        data: function() {
            return {
                posDec: 10, // Para redondear con un decimal. NO CAMBIAR
                resumenes: {},
                totales: {
                    semanal: 0,
                    anual: 0
                }
            }
        },
        created: function() {
            this.actualizarResumen();
        },
        methods: {
            actualizarResumen: function() {
                this.totales.semanal = 0;
                this.totales.anual = 0;
                
                for (var itemKey in this.informe) {
                    if (itemKey.startsWith('item')) {
                        this.resumenes[itemKey] = {};
                        this.resumenes[itemKey]['horasSemana'] = 0;
                        this.resumenes[itemKey]['horasAnio'] = 0;

                        this.informe[itemKey].forEach((item) => {
                            this.resumenes[itemKey].horasSemana += (item.comprometido.primero.horasSemana + item.comprometido.segundo.horasSemana) / 2;
                            this.resumenes[itemKey].horasAnio += item.comprometido.primero.horasSemestre + item.comprometido.segundo.horasSemestre;
                        });

                        this.totales.semanal += this.resumenes[itemKey].horasSemana;
                        this.totales.anual += this.resumenes[itemKey].horasAnio;
                    }
                }
            }
        },
        watch: {
            abierto: function(newValue) {
                if(newValue) this.actualizarResumen();
            }
        }
    }
</script>
