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
                                    <td><button v-on:click.prevent="eliminar(user.id)" class="btn btn-xs btn-danger">
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
                <router-link class="btn btn-success" :to="{ name: 'usuarios-comision-facultad', params: { id: id_comision }}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Usuario
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
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
        });
    },
    data () {
        console.log(this);
        return {
        element: (this.elemento?this.elemento:{}),
        users: [],
        id_comision: {},
        seleccionado: {}
        }
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
        eliminar(id){
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
                        });
                    });
                });      

            }
    }
  }
</script>