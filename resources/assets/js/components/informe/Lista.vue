<template>
    <div class="col-md-8 col-md-offset-2">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Informes de actividades
            </div>
            <div class="text-center" v-if="cargando">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
            <div v-else>
                <div v-if="informes.length === 0" class="text-center">
                    <h3>No se ha ingresado nuevos informes de actividades</h3>
                </div>
                <table v-else class="table table-striped">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Creado el</th>
                            <th>Aprobado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="informe in informes" v-bind:key="informe.id">
                            <td class="col-md-4">{{ informe.periodo }}</td>
                            <td class="col-md-6">{{ informe.created_at }}</td>
                            <td class="col-md-2">
                                <router-link class="btn btn-xs btn-info btn-block" :to="{ name: 'declarar-realizado', params: { id: informe.id }}">     
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'nuevo-informe'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar informe
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['mensaje'],
        data: function() {
            return {
                informes: [],
                cargando: true,
            }
        },
        created: function() {
            this.$http.get('/api/declaraciones')
                .then(response => {
                    this.informes = response.data
                    this.cargando = false
                })
                .catch(e => {
                    this.cargando = false
                    console.log(e)
                })
        }
    }
</script>
