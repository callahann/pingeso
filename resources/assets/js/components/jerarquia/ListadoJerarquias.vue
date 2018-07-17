<template>
  <div :class="{ 'col-md-12': auth.rol.id >= 3, 'col-md-8 col-md-offset-2': auth.rol.id <= 2 }">
        <div v-if="mensaje" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de jerarquias
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nombre Jerarquia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(jerarquia,index) in jerarquias" v-bind:key="jerarquia.id">
                        <td>{{ jerarquia.nombre }}</td>
                        <td class="col-md-2">
                          <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-jerarquia', params: {accion: 'Editar', elemento: Object.assign({}, jerarquia, {})} }">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                          </router-link>
                          <button v-on:click="deleteElem(jerarquia.id, index, jerarquia.nombre)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'crear-jerarquia', params: {accion: 'Crear'}}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Jerarquia
                </router-link>
            </div>
        </div>
    </div>
 
</template>


<script>
    import {
        DELETE_JERARQUIA
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
                var c = confirm("¿Estás seguro de borrar la "+ nombre + "?");
                if (c == false){
                    console.log('FALSE');
                    return;     
                }
                this.$store.dispatch(DELETE_JERARQUIA, { jerarquia: this.jerarquias[index], cb: this.callback });
            }
        },
        computed: mapState(['jerarquias'])
    }
</script>