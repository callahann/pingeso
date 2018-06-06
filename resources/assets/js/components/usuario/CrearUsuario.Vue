<template>  
  <div class="add container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Agregar usuario</h1>
    <form v-on:submit="addUser">
        
            <h4>Datos del nuevo usuario</h4>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre" v-model="customer.first_name">
            </div>
            <div class="form-group">
                <label>Apellido</label>
                <input type="text" class="form-control" placeholder="Apellido" v-model="customer.last_name">
            </div>
        
        
            
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" placeholder="Email" v-model="customer.email">
            </div>
        
        <div>
        <label>Jerarquía</label>
        <select v-model="jerarquia">
          <option disabled value="">Seleccionar jerarquía</option>
          <option>A</option>
          <option>B</option>
          <option>C</option>
        </select>
        </div>
        
        <div>
        <label>Jornada</label>
        <select v-model="jornada">
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
  export default {
    name: 'add',
    data () {
        return {
        user: {}
        }
    },
    methods: {
        addUser(e){
            if(!this.user.first_name || !this.user.last_name || !this.user.email){
                console.log('No se han llenado los campos necesarios');
            } else {
                  //CONSULTA AXIOS
                }
            e.preventDefault();
        }
    }
  }
</script>
