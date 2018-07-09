<template>
  <div :class="{ 'col-md-12': auth.rol.id >= 3, 'col-md-8 col-md-offset-2': auth.rol.id <= 2 }">
        <div v-if="mensaje" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de periodos
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nombre Periodo</th>
                        <th class="text-center">Desde</th>
                        <th class="text-center">Hasta</th>
                        <th class="text-center">Etapas</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(periodo,index) in periodos" v-bind:key="periodo.id">
                        <td>{{ periodo.nombre }}</td>
                        <td>{{ periodo.desde }}</td>
                        <td>{{ periodo.hasta }}</td>
                        <td>{{ etapa(periodo.etapa) }}</td>
                        <td class="col-md-2">
                          <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-periodo', params: {accion: 'Editar', elemento: periodo} }">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                          </router-link>
                          <button v-on:click="deleteElem(periodo.id,index,periodo.nombre)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'crear-periodo', params: {accion: 'Crear'}}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Periodo
                </router-link>
            </div>
        </div>
    </div>
 
</template>


<script>
    import { mapState } from 'vuex'
    import axios from 'axios';
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
            deleteElem(id, index, nombre){
                var c = confirm("¿Estás seguro de borrar el "+ nombre + "?");
                if (c == false){
                    console.log('FALSE');
                    return;     
                }
                axios.delete('/api/periodos/'+id)
                .then(response=> {
                    this.periodos.splice(index, 1);
                });
            },
            etapa(numero) {
                switch(numero){
                    case 1:
                            return "Declaración";
                    case 2:
                            return "Aprobación";
                    case 3:
                            return "Información";
                    case 4:
                            return "Evaluación";
                    case 5:
                            return "Apelación";
                }
            }
        },
        computed: mapState(['periodos'])
    }
</script>