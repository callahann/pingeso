<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Creada el</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="declaracion in declaraciones" v-bind:key="declaracion.id">
                    <td>{{ declaracion.periodo }}</td>
                    <td>{{ declaracion.created_at }}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-success" v-on:click="verDeclaracion">     
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        </button>
                        <button type="button" class="btn btn-xs btn-danger" v-on:click="enviarDeclaracion">     
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        data: function() {
            return {
                declaraciones: []
            }
        },
        mounted: function() {
            axios.get('/declaraciones')
            .then(response => {
                this.declaraciones = response.data;    
                console.log(this.declaraciones);
            })
            .catch(e => {
                console.log(e);
            });
        }
    }
</script>
