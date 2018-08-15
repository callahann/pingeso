<template>
    <div class="row">
        <label for="facultad">Comisión Departamental</label>
        <br></br>
        <input type="text" v-model="search" placeholder="Buscar usuarios"/>
        <br></br>
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
                <tr v-for = "user in filtrar">
                    <td>{{user.nombres}} {{user.apellido_paterno}}</td>
                    <td>{{user.email}}</td>
                    <td v-if="user.rol === 0"> Académico</td>
                    <td v-if="user.rol === 1"> Director Departamento</td>
                    <td v-if="user.rol === 2"> Administrador</td>
                    <td>{{user.departamento.nombre}}</td>
                    <td><button v-on:click.prevent="agregar(user.id, 1)" class="btn btn-xs btn-success">
                            <span class="glyphicon glyphicon-check" aria-hidden="true">Fijo</span>
                          </button>
                          <button v-on:click.prevent="agregar(user.id, 2)" class="btn btn-xs btn-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true">Suplente</span>
                          </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                
        </div>
    </div> 
</template>

<script>
    import axios from 'axios';
    export default {       
        created: function() {
            axios.get('/api/usuarios/comision')
            .then(response => {
                this.users = response.data;
            });
        },
        computed: {
            filtrar: function(){
                return this.users.filter((user)=>
                {
                    return user.nombres.toLowerCase().match(this.search.toLowerCase());
                });
            }

        },
        methods: {
            agregar(id, tipo){
                axios.get('/api/usuarios/' + id)
                .then(response => {
                    this.seleccionado = response.data;
                    this.seleccionado.id_comision = this.$route.params.id;
                    this.seleccionado.rol_comision = tipo;
                    axios.put('/api/usuarios/' + id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/usuarios/comision')
                        .then(response => {
                            this.users = response.data;
                        });
                    });
                });      

            }
        },
        data () {
            return {
            users: [],
            search: ''
            }
        }
  }
</script>