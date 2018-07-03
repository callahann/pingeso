<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'usuarios'}">Listado</router-link></li>
            <li class="active">Usuario</li>
        </ol>
        <div v-if="status === 1" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">[Cerrar &times;]</a>
            <a href="#" class="close" aria-label="close" v-on:click="volver('usuarios')">[Volver] </a>
            <strong>Bien!</strong> Se han guardado los cambios.
        </div>
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
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-success" v-on:click="addElem">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span> {{this.accion}}
                </button>
            </div>
        </div>
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