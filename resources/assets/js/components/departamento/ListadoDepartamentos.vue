<template>
  <div :class="{ 'col-md-12': auth.rol.id >= 3, 'col-md-8 col-md-offset-2': auth.rol.id <= 2 }">
        <div v-if="mensaje" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de departamentos
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nombre Departamento</th>
                        <th class="text-center">Nombre Facultad</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(departamento,index) in departamentos" v-bind:key="departamento.id">
                        <td>{{ departamento.nombre }}</td>
                        <td>{{ departamento.facultad.nombre}}</td>
                        <td class="col-md-2">
                          <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-departamento', params: {accion: 'Editar', elemento: departamento} }">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                          </router-link>
                          <button v-on:click="deleteElem(departamento.id,index)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'crear-departamento', params: {accion: 'Crear'}}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Departamento
                </router-link>
            </div>
        </div>
    </div>
 
</template>


<script>
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
                departamentos: [],
                
            }
        },
        created: function() {
            axios.get('/api/departamentos')
            .then(response=> {
              this.departamentos = response.data;
              this.cargando = false;
            })
            .catch(e => {
                this.cargando = false;
                console.log(e);
            });
        },
        methods: {
            deleteElem(id, index){
                console.log('Index: ', index);
                axios.delete('/api/departamentos/'+id)
                .then(response=> {
                    this.departamentos.splice(index, 1);
                });
            }
        }
    }
</script>