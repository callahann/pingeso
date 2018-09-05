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
                    <td v-if="user.rol_comision === 0"> Fijo </td>
                    <td v-else-if="user.rol_comision === 1"> Suplente </td>
                    <td v-else> Externo </td>
                    <td>{{user.departamento.nombre}}</td>
                    <td><button v-on:click.prevent="eliminarUsuario(user.id)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true">Quitar</span>
                          </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                    <button v-if="cantidad_usuarios[0] < 7" v-on:click="agregarFijo" type="button" class="btn btn-default" data-toggle="modal"
                     data-target="#agregar" data-backdrop="static" data-keyboard="false"
                     >Agregar Fijo</button>
                     <button v-else type="button" class="btn btn-default disabled"
                     >Agregar Fijo</button>
                     <button type="button" class="btn btn-default disabled"
                     >Agregar Suplente</button>
                     <button  v-if="cantidad_usuarios[2] < 2" v-on:click="agregarExterno" type="button" class="btn btn-default" data-toggle="modal"
                     data-target="#agregar" data-backdrop="static" data-keyboard="false"
                     >Agregar Externo</button>
                     <button v-else type="button" class="btn btn-default disabled"
                     >Agregar Externo</button>
        </div>
        <!-- Modal -->
        <div v-if="abierto" id="agregar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Agregar a comisión</h4>
              </div>
              <div class="modal-body">
                  <agregar-usuario
                  v-bind:id_comision="1"
                  v-bind:tipo_usuario="this.tipo_usuario"
                  v-bind:id_entidad="0"
                  v-bind:tipo_entidad="0"
                  ></agregar-usuario>
                  <br/>
              </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-default col-xs-2 col-lg-2 col-sm-2 col-md-2"  data-dismiss="modal"
                    v-on:click="actualizar">Cerrar</button>
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
                this.actualizarBotones(this.users);
            });
        },
        methods: {
            eliminarUsuario(id){
                axios.get('/api/usuarios/' + id)
                .then(response => {
                    this.seleccionado = response.data;
                    this.seleccionado.comision = null;
                    this.seleccionado.rol_comision = null;
                    axios.put('/api/usuarios/comision/agregar/' + id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/comisiones/superior')
                        .then(response => {
                            this.users = response.data.usuarios;
                            this.actualizarBotones(this.users);
                        });
                    });
                });
            },
            agregarFijo: function(){
            this.abierto = true;
            this.tipo_usuario = 0;

            },
            agregarSuplente: function(){
                this.abierto = true;
                this.tipo_usuario = 1;

            },
            agregarExterno: function(){
                this.abierto = true;
                this.tipo_usuario = 2;

            },
            cerrar: function(){
                this.abierto = false;
            },
            actualizarBotones: function(users){
                this.cantidad_usuarios[0] = 0;
                this.cantidad_usuarios[1] = 0;
                this.cantidad_usuarios[2] = 0;
                for (var i = 0; i < users.length; i++) {
                    if (users[i].rol_comision == 0) {
                        this.cantidad_usuarios[0] +=1;
                    }
                    else if (users[i].rol_comision == 1) {
                        this.cantidad_usuarios[1] +=1;
                    }
                    else {
                        this.cantidad_usuarios[2] +=1;
                    }
                }

            },
            actualizar: function(){
                axios.get('/api/comisiones/superior')
                .then(response => {
                    this.users = response.data.usuarios;
                    this.actualizarBotones(this.users);
                });
                this.abierto = false;
            }
            
        },
        components: {
        'agregar-usuario': ListadoUsuarios,
        },  
        data () {
            return {
            users: [],
            seleccionado: {},
            abierto: false,
            tipo_usuario: {},
            cantidad_usuarios: []
            }
        }
  }
</script>
<style type="text/css">
    .modal-xl{
        width: 95%;
        max-width: 1250px;
    }
    .btn-default:hover{
        background-color: #002F6C;
        width: auto;
        text-align: center;
    }
    .btn-default .active{
        background-color: #002F6C;
        width: auto;
        text-align: center;
    }
    .btn-default{
        width: auto;
        text-align: center;
        background-color: #004299;
    }
</style>