<template>  
    <div class="col-md-10 col-md-offset-1">
        <ol class="breadcrumb">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'departamentos'}">Listado</router-link></li>
            <li class="active">Departamento</li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Departamento
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombre:</label>
                        <input v-if="auth.rol === rol.admin" type="text" class="form-control" id="nombres"
                            v-model="departamento.nombre">
                        <p v-else>{{ departamento.nombre }}</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="facultad">Facultad:</label>
                        <select v-if="auth.rol === rol.admin" class="form-control" id="facultad" v-model="departamento.id_facultad">
                            <option v-for="facultad in facultades"
                                :key="facultad.id"
                                :value="facultad.id">
                                {{ facultad.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ departamento.facultad.nombre }}</p>
                    </div>
                </div>
                <div class="row" v-if="auth.rol === rol.director">
                    <div class="form-group col-md-12">
                        <label for="facultad">Comisión Departamental</label>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Apellido paterno</th>
                                    <th class="text-center">Apellido materno</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Cargo</th>
                                    <th class="text-center">Departamento</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.apellido_paterno }}</td>
                                    <td>{{ user.apellido_materno }}</td>
                                    <td>{{ user.nombres }}</td>
                                    <td>{{ user.email}}</td>
                                    <td>{{ etiquetas.rolComision[user.rol_comision] }}</td>
                                    <td>{{ user.departamento.nombre }}</td>
                                    <td>
                                        <button v-on:click.prevent="eliminarUsuario(user.id)" class="btn btn-xs btn-danger">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&ensp;Quitar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-success" v-on:click="addElem">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;{{this.accion}}
                </button>
                <!--<router-link class="btn btn-success" :to="{ name: 'usuarios-comision-departamento', params: { id: id_comision }}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&ensp;Usuario
                </router-link>-->
                <button v-on:click="agregarFijo" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Fijo</button>
                 <button v-on:click="agregarSuplente" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Suplente</button>
                 <button  v-on:click="agregarExterno" type="button" class="btn btn-default" data-toggle="modal"
                 data-target="#agregar">Agregar Externo</button>
            </div>
        </div>
    
        <!-- Modal -->
        <div v-if="abierto" id="agregar" class="modal fade" role="dialog">
          <div class="modal-dialog modal-xl">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Agregar a comisión</h4>
              </div>
              <div class="modal-body"></div>
              <agregar-usuario
              v-bind:id_comision="id_comision"
              v-bind:tipo_usuario="this.tipo_usuario"
              v-bind:id_entidad="this.departamento.id"
              v-bind:tipo_entidad="2"
              ></agregar-usuario>
              <br/>
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
    import {
        INSERT_DEPARTAMENTO,
        UPDATE_DEPARTAMENTO
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
        axios
            .get('/api/comisiones/departamento/'+ this.departamento.id)
            .then(response => {
                this.id_comision = response.data.id
                this.users = response.data.usuarios
                console.log(this.users)
            })
    },
    data: function() {
        return {
            departamento: this.elemento ? this.elemento : { id_facultad: '' },
            users: [],
            id_comision: {},
            seleccionado: {},
            abierto: false,
            tipo_usuario: {}
        }
    },
    components: {
        'agregar-usuario': ListadoUsuarios,
    },
    methods: {
        /**
         * Callback para mostrar un mensaje luego de obtener respuesta
         * desde la API.
         * @param ok Indica si la operación se realizó correctamente
         * @param payload Data (respuesta) obtenida desde la API
         */
        callback: function(ok = false, payload) {
            this.$root.$emit('alert', {
                mensaje: ok ? payload.mensaje : '<strong>Oh no!</strong> Ha ocurrido un error.',
                class: ok ? 'success' : 'danger'
            })
            this.departamento = Object.assign({}, this.departamento, payload.data)
        },
        addElem: function() {
            if (this.accion == 'Editar') {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha registrado los cambios.' }
                this.$store.dispatch(UPDATE_DEPARTAMENTO, { departamento: this.departamento, cb: this.callback, payload })
            } else {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha registrado el nuevo departamento.' }
                this.$store.dispatch(INSERT_DEPARTAMENTO, { departamento: this.departamento, cb: this.callback, payload })
            }   
            
        },
        eliminarUsuario: function(id) {
            axios
                .get('/api/usuarios/' + id)
                .then(response => {
                    this.seleccionado = response.data
                    this.seleccionado.comision = null
                    this.seleccionado.rol_comision = null
                    axios.put('/api/usuarios/' + id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/comisiones/departamento/'+ this.departamento.id)
                        .then(response => {
                            this.users = response.data.usuarios
                        })
                    })
                })
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
        actualizar: function(){
            axios
            .get('/api/comisiones/departamento/'+ this.departamento.id)
            .then(response => {
                this.id_comision = response.data.id
                this.users = response.data.usuarios
                console.log(this.users)
            });
            this.abierto = false;
        }


    },
    computed: mapState(['facultades'])
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