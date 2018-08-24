<template>
    <div class="row">
        <label for="facultad">Comisión Superior</label>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cargo</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for = "user in users">
                    <td>{{user.nombres}} {{user.apellido_paterno}}</td>
                    <td>{{user.email}}</td>
                    <td v-if="user.rol_comision === 1"> Fijo </td>
                    <td v-else> Suplente </td>
                    <td>{{user.departamento.nombre}}</td>
                    <td><button v-on:click.prevent="eliminarUsuario(user.id)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true">Quitar</span>
                          </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                <!--<router-link class="btn btn-success" :to="{ name: 'usuarios-comision-superior'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Usuario
                </router-link>-->
                <button type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Fijo</button>
                 <button type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Suplente</button>
                 <button type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Externo</button>
        </div>
        <!-- Modal -->
        <div id="agregar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Agregar a comisión</h4>
              </div>
              <div class="modal-body"></div>
              <agregar-usuario
              v-bind:id_comision="1"
              v-bind:tipo_usuario="0"
              v-bind:id_entidad="0"
              v-bind:tipo_entidad="0"
              ></agregar-usuario>
              <br/>
              <div class="modal-footer">
              </div>
            </div>

          </div>
        </div>
    </div> 
</template>

<script>
    import axios from 'axios'
    import ListadoUsuarios from '../comision/ListadoUsuarios'
    export default {       
        created: function() {
            axios.get('/api/comisiones/superior')
            .then(response => {
                this.users = response.data.usuarios;
            });
        },
        methods: {
            eliminarUsuario(id){
                axios.get('/api/usuarios/' + id)
                .then(response => {
                    this.seleccionado = response.data;
                    this.seleccionado.comision = null;
                    this.seleccionado.rol_comision = null;
                    axios.put('/api/usuarios/' + id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/comisiones/superior')
                        .then(response => {
                            this.users = response.data.usuarios;
                        });
                    });
                });      

            }
        },
        components: {
        'agregar-usuario': ListadoUsuarios,
        },  
        data () {
            return {
            users: [],
            seleccionado: {}
            }
        }
  }
</script>
<style type="text/css">
    .modal-xl{
        width: 95%;
        max-width: 1250px;
    }
</style>