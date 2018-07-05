<template>
    <div class="col-md-8 col-md-offset-2">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div v-if="declarar" class="alert alert-warning">
            <strong>Atención: </strong> Puede enviar su declaración hasta el <b>{{ hasta }}</b>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Informes de actividades
            </div>
            <div v-if="informes.length === 0" class="text-center">
                <h3>No se ha ingresado nuevos informes de actividades</h3>
            </div>
            <table v-else class="table table-striped">
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Creado el</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="informe in informes" v-bind:key="informe.id">
                        <td>{{ informe.periodo.nombre }}</td>
                        <td>{{ new Date(informe.created_at).toString() }}</td>
                        <td>{{ estados.etiquetas[informe.estado] }}</td>
                        <td class="col-md-2">
                            <router-link class="btn btn-xs btn-info btn-block" :to="{ name: 'declarar-realizado', params: { id: informe.id }}">     
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success text-right" :to="{ name: 'nuevo-informe'}" v-if="declarar">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar informe
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        props: ['mensaje'],
        computed: {
            ...mapState(['informes']),
            declarar: function() {
                if(this.auth.departamento.periodo === null) return false

                const periodo = this.auth.departamento.periodo
                if(periodo.etapa > 1) return false

                const informe = this.informes.find(informe => {
                    return informe.periodo.id === periodo.id
                })
                if(informe) return false

                const ahora = Date.now()
                const desde = Date.parse(periodo.desde)
                const hasta = Date.parse(periodo.hasta)
                return desde <= ahora && ahora <= hasta
            },
            hasta: function() {
                const hastaStr = this.auth.departamento.periodo.hasta
                const hasta = new Date(hastaStr)
                return hasta.toStringWithTime()
            }
        }
    }
</script>
