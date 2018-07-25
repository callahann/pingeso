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
                </tr>
            </thead>
            <tbody>
                <tr v-for = "user in users">
                    <td>{{user.nombres}} {{user.apellido_paterno}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.rol.nombre}}</td>
                    <td>{{user.departamento.nombre}}</td>
                </tr>
            </tbody>
        </table>
    </div> 
</template>

<script>
    import axios from 'axios';
    export default {       
        created: function() {
            axios.get('/api/comisiones/superior')
            .then(response => {
                console.log(response.data.usuarios);
                this.users = response.data.usuarios;
            });
        },
        data () {
            return {
            users: []
            }
        }
  }
</script>


