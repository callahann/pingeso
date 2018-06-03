<template>
    <div class="col-md-8 col-md-offset-2">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Informes de actividades
                <router-link class="btn btn-xs btn-success pull-right" :to="{ name: 'nuevo-informe'}">     
                    Ingresar nuevo informe <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </router-link>
            </div>
            <div class="panel-body text-center" v-if="cargando">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
            <div class="panel-body" v-else>
                <div v-if="informes.length === 0" class="text-center">
                    <h3>No se han ingresado nuevos informes de actividades</h3>
                </div>
                <table v-else class="table table-striped">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Creado el</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="informe in informes" v-bind:key="informe.id">
                            <td class="col-md-4">{{ informe.periodo }}</td>
                            <td class="col-md-6">{{ informe.created_at }}</td>
                            <td class="col-md-2">
                                <router-link class="btn btn-xs btn-success btn-block" :to="{ name: 'declarar-realizado', params: { id: informe.id }}">     
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        props: ['mensaje'],
        data: function() {
            return {
                informes: [],
                cargando: true,
            }
        },
        created: function() {
            axios.get('/api/declaraciones')
                .then(response => {
                    this.informes = response.data;
                    this.cargando = false;
                    console.log(this.informes);
                })
                .catch(e => {
                    this.cargando = false;
                    console.log(e);
                });
        },
        methods: {
            ver: function(declaracion) {
                
            }
        }
    }
</script>
