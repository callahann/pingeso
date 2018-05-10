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
                <tr v-for="declaracion in resumenes" v-bind:key="declaracion.item">
                    <td>{{ declaracion.item }}</td>
                    <td class="text-center">{{ Math.round(declaracion.horasSemana * posDec) / posDec }}</td>
                    <td class="text-center">{{ Math.round(declaracion.horasAnio * posDec) / posDec }}</td>
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
        props: ['declaraciones', 'abierto'],
        data: function() {
            return {
                posDec: 10, // Para redondear con un decimal. NO CAMBIAR
                resumenes: [
                    {
                        item: 'Docencia',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Investigación y desarrollo',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Asistencia técnica',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Perfeccionamiento',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Administración académica',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Extensión',
                        horasSemana: 0,
                        horasAnio: 0
                    },
                    {
                        item: 'Educación continua',
                        horasSemana: 0,
                        horasAnio: 0
                    }
                ],
                totales: {
                    semanal: 0,
                    anual: 0
                }
            }
        },
        methods: {
            actualizarResumen: function() {
                this.totales.semanal = 0;
                this.totales.anual = 0;

                this.declaraciones.forEach((declaracion, index) => {
                    this.resumenes[index].horasSemana = 0;
                    this.resumenes[index].horasAnio = 0;

                    declaracion.forEach((item) => {
                        this.resumenes[index].horasSemana += (item.primero.horasSemana + item.segundo.horasSemana) / 2;
                        this.resumenes[index].horasAnio += item.primero.horasSemestre + item.segundo.horasSemestre;
                    });

                    this.totales.semanal += this.resumenes[index].horasSemana;
                    this.totales.anual += this.resumenes[index].horasAnio;
                });
            }
        },
        watch: {
            abierto: function(newValue) {
                if(newValue) this.actualizarResumen();
            }
        }
    }
</script>
