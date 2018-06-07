<template>
  <div class="container">
  
    <h1 class="page-header">Usuarios</h1>
   
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users">
            <td>{{user.first_name}}</td>
            <td>{{user.last_name}}</td>
            <td>{{user.email}}</td>
          </tr>
        </tbody>
    </table>
    <div>
     <router-link class="btn btn-xs btn-info btn-block" :to="{ name: 'nuevo-usuario'}">Agregar usuario</router-link>
    </div>
  </div>
 
</template>


<script>
    export default {
        
        data: function() {
            return {
                users: [],
                
            }
        },
        created: function() {
            //AXIOS
        }
    }
</script>