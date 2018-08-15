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
                    <td><button v-on:click.prevent="eliminar(user.id)" class="btn btn-xs btn-danger">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true">Quitar</span>
                          </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'usuarios-comision-superior'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Usuario
                </router-link>
        </div>
    </div> 
</template>

<script>
    import axios from 'axios';
    export default {       
        created: function() {
            axios.get('/api/comisiones/superior')
            .then(response => {
                this.users = response.data.usuarios;
            });
        },
        methods: {
            eliminar(id){
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
        data () {
            return {
            users: [],
            seleccionado: {}
            }
        }
  }
</script>

