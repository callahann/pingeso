<template>
  <div class="container">
  
    <h1 class="page-header">Usuarios</h1>
   
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Facultad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="facu in facultades">
            <td>{{facu.nombre}}</td>
            <td>{{facu.apellido}}</td>
            <td>
                <router-link class="btn btn-xs btn-info" :to="{ name: 'editar-facultad', params: {accion: 'Editar', elemento: facu} }">Editar</router-link>
            </td>
          </tr>
        </tbody>
    </table>
    <div>
     <router-link class="btn btn-xs btn-info" :to="{ name: 'crear-facultad', params:{accion: 'Crear', elemento: {}} }">+ Facultad</router-link>
    </div>
  </div>
 
</template>


<script>
    import axios from 'axios';
    export default {
        
        data: function() {
            return {
                facultades: [],
                
            }
        },
        created: function() {
            axios.get('/api/facultades')
            .then(response=> {
              this.facultades = response.data.data;
              this.cargando = false;
              console.log(this.facultades);
            })
            .catch(e => {
                this.cargando = false;
                console.log(e);
            });
        }
    }
</script>