<template>  
  <div class="container">
    <h1 class="page-header">Agregar usuario</h1>
    <form v-on:submit="addUser">
        
            <h4>Datos del nuevo usuario</h4>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre" v-model="user.nombre">
            </div>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" class="form-control" placeholder="Apellido" v-model="user.apellido">
            </div>
        
        
            
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Email" v-model="user.email">
            </div>
        
        <div>
        <label>Jerarquía</label>
        <select v-model="user.jerarquia">
          <option disabled value="">Seleccionar jerarquía</option>
          <option>A</option>
          <option>B</option>
          <option>C</option>
        </select>
        </div>
        
        <div>
        <label>Jornada</label>
        <select v-model="user.jornada">
          <option disabled value="">Seleccionar jornada</option>
          <option>Jornada completa</option>
          <option>3/4 Jornada completa</option>
          <option>1/2 Jornada completa</option>
          <option>1/4 Jornada completa</option>
        </select>
        </div>
        
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    name: 'add',
    data () {
        return {
        user: {}
        }
    },
    methods: {
        addUser(e){
            if(!this.user.nombre || !this.user.apellido || !this.user.email){
                console.log('No se han llenado los campos necesarios');
            } else {
              axios.post('/api/usuarios', this.user)
                    .then(response => {
                        console.log('Se ha registrado el usuario correctamente');
                        this.message = response.data;
                        this.mensaje = 1;
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            }
            e.preventDefault();
        }
    }
  }
</script>
