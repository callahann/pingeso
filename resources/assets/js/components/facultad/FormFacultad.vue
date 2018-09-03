<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'facultades'}">Listado</router-link></li>
            <li class="active">Facultad</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Facultad
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombre:</label>
                        <input v-if="editable" type="text" class="form-control" id="nombres"
                            v-model="element.nombre">
                        <p v-else>{{ element.nombre }}</p>
                    </div>
                </div>
                <div class="row">
                        <label for="facultad">Comisión de Facultad</label>
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
                                <tr v-for="user in users" :key="user.id">
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
                </div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-success" v-on:click="addElem">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span> {{this.accion}}
                </button>
                <button v-if="cantidad_usuarios[0] < 2" v-on:click="agregarFijo" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar" data-backdrop="static" data-keyboard="false"
                 >Agregar Fijo</button>
                 <button v-else type="button" class="btn btn-default disabled"
                 >Agregar Fijo</button> 
                 <button v-if="cantidad_usuarios[1] < 1" v-on:click="agregarSuplente" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar" data-backdrop="static" data-keyboard="false"
                 >Agregar Suplente</button>
                 <button v-else type="button" class="btn btn-default disabled"
                 >Agregar Suplente</button>
                 <button  v-if="cantidad_usuarios[2] < 3" v-on:click="agregarExterno" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar" data-backdrop="static" data-keyboard="false"
                 >Agregar Externo</button>
                 <button v-else type="button" class="btn btn-default disabled"
                 >Agregar Externo</button>
            </div>
        </div>
        <!-- Modal -->
        <div v-if="abierto" id="agregar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="container">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Agregar a comisión</h4>
                  </div>
                  <div class="modal-body">
                      <agregar-usuario
                      v-bind:id_comision="id_comision"
                      v-bind:tipo_usuario="this.tipo_usuario"
                      v-bind:id_entidad="this.element.id"
                      v-bind:tipo_entidad="1"
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
    </div>
</template>

<script>
    import axios from 'axios'
    import ListadoUsuarios from '../comision/ListadoUsuarios'
    import {
        INSERT_FACULTAD,
        UPDATE_FACULTAD
    } from '../../vuex/actions'
    import { mapState } from 'vuex'
    export default {
    props: {
        accion: {
            type: String,
            required: true
        },
        elemento: {
            type: Object,
            required: false
        }
    },
    created: function() {
        this.editable = true;
        this.message = '';
        this.status = 0;
        axios.get('/api/comisiones/facultad/' + this.element.id)
        .then(response => {
            this.id_comision = response.data.id;
            this.users = response.data.usuarios;
            this.actualizarBotones(this.users);
        });
    },
    data () {
        console.log(this);
        return {
        element: (this.elemento?this.elemento:{}),
        users: [],
        id_comision: {},
        seleccionado: {},
        abierto: false,
        tipo_usuario: {},
        cantidad_usuarios: []
        }
    },
    components: {
        'agregar-usuario': ListadoUsuarios,
    },
    methods: {
        callback: function(ok = false, payload) {
            this.mensaje = ok ? 1 : -1
            this.element = Object.assign({}, this.element, payload)
        },
        addElem(){
            if (this.accion=='Editar') {
                this.$store.dispatch(UPDATE_FACULTAD, { facultad: this.element, cb: this.callback });
                this.volver('facultades', 'Se ha actualizado la facultad correctamente.')
            } else {
                this.$store.dispatch(INSERT_FACULTAD, { facultad: this.element, cb: this.callback });
                this.volver('facultades', 'Se ha creado la facultad correctamente.')
            }   
            
        },
        eliminarUsuario(id){
                axios.get('/api/usuarios/' + id)
                .then(response => {
                    this.seleccionado = response.data;
                    this.seleccionado.comision = null;
                    this.seleccionado.rol_comision = null;
                    axios.put('/api/usuarios/' + id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/comisiones/facultad/'+ this.element.id)
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
            axios.get('/api/comisiones/facultad/' + this.element.id)
            .then(response => {
                this.id_comision = response.data.id;
                this.users = response.data.usuarios;
                this.actualizarBotones(this.users);
            });
            this.abierto = false;
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