<template>
    <div class="row">
        <label for="facultad">Comisión Superior</label>
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
                </tr>
            </thead>
            <tbody>
                <tr v-for = "user in filtrar">
                    <td>{{user.nombres}} {{user.apellido_paterno}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.rol.nombre}}</td>
                    <td>{{user.departamento.nombre}}</td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'usuarios-comision'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Usuario
                </router-link>
        </div>
    </div> 
</template>

<script>
    import axios from 'axios';
    export default {       
        created: function() {
            axios.get('/api/usuarios')
            .then(response => {
                console.log(response.data);
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
        data () {
            return {
            users: [],
            search: ''
            }
        }
  }
</script>