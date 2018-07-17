<template>
  <div :class="{ 'col-md-12': auth.rol.id >= 3, 'col-md-8 col-md-offset-2': auth.rol.id <= 2 }">
        <div v-if="mensaje" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de facultades
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nombre Facultad</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(facu,index) in facultades" v-bind:key="facu.id">
                        <td>{{ facu.nombre }}</td>
                        <td class="col-md-2">
                          <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-facultad', params: {accion: 'Editar', elemento: Object.assign({}, facu, {})} }">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                          </router-link>
                          <button v-on:click="deleteElem(facu.id,index,facu.nombre)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'crear-facultad', params: {accion: 'Crear'}}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Facultad
                </router-link>
            </div>
        </div>
    </div>
 
</template>


<script>
    import {
        DELETE_FACULTAD
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
                this.$store.dispatch(DELETE_FACULTAD, { facultad: this.facultades[index], cb: this.callback });
            }
        },
        computed: mapState(['facultades'])
    }
</script>