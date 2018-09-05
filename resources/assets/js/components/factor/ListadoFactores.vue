<template>
  <div class="col-md-6 col-md-offset-3">
        <div v-if="mensaje" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de factores
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Diferencia</th>
                        <th class="text-center">Factor</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(factor,index) in factores" v-bind:key="factor.id">
                        <td>{{ factor.diferencia }}</td>
                        <td>{{ factor.factor }}</td>
                        <td class="col-md-2">
                          <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-factor', params: {accion: 'Editar', elemento: Object.assign({}, factor, {})} }">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                          </router-link>
                          <button v-on:click="deleteElem(factor.id,index,factor.diferencia)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'crear-factor', params: {accion: 'Crear'}}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar factor
                </router-link>
            </div>
        </div>
    </div>
 
</template>


<script>
    import {
        DELETE_FACTOR
    } from '../../vuex/actions'
    import { mapState } from 'vuex'
    export default {
        props: {
            mensaje: {
                type: String,
                required: false
            },
        },
        data: function() {
            return {
            }
        },
        methods: {
            callback: function(ok = false, payload) {
                this.mensaje = ok ? payload : "";
            },
            deleteElem(id, index, nombre){
                var c = confirm("¿Estás seguro de borrar el factor de diferencia: "+ nombre + "?");
                if (c == false){
                    console.log('FALSE');
                    return;     
                }
                this.$store.dispatch(DELETE_FACTOR, { factor: this.factores[index], cb: this.callback });
            }
        },
        computed: mapState(['factores'])
    }
</script>