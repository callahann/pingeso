<template>  
  <div class="container">
    <h1 class="page-header">{{accion}} Facultad</h1>
        <h4>Datos del nuevo usuario</h4>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" v-model="element.nombre" required>
        </div>
        
        
        <button v-on:click="addElem" class="btn btn-primary">{{accion}}</button>
  </div>
</template>

<script>
  import axios from 'axios';
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
    data () {
        console.log(this);
        return {
        element: (this.elemento?this.elemento:{}),
        }
    },
    methods: {
        addElem(){
            console.log('Voy a'+(this.accion=='Editar')?'Editar':'Crear');
            if (this.accion=='Editar') {
               axios.put('/api/facultades/'+this.element.id, this.element)
                .success(response => {
                    self.$router.push('/facultades');
                })
                .then(response => {
                    console.log('Se ha editado la facultad correctamente');
                    this.message = response.data;
                    this.mensaje = 1;
                    self.$router.push('/facultades');
                })
                .catch(e => {
                    console.log(e);
                    this.mensaje = -1; 
                }); 
            } else {
                axios.post('/api/facultades/', this.element)
                .then(response => {
                    console.log('Se ha registrado la facultad correctamente');
                    this.message = response.data;
                    this.mensaje = 1;
                    self.$router.push('/facultades');
                })
                .catch(e => {
                    console.log(e);
                    this.mensaje = -1; 
                });
            }   
            
        }
    }
  }
</script>