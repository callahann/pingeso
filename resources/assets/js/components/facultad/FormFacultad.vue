<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'facultades'}">Listado</router-link></li>
            <li class="active">Facultad</li>
        </ol>
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
    created: function() {
        this.editable = true;
        this.message = '';
        this.status = 0;
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
                .then(response => {
                    console.log(this.volver('facultades', response.data))
                    this.status = 1;
                })
                .catch(e => {
                    console.log(e);
                    this.message = response.data;
                    this.status = -1; 
                }); 
            } else {
                axios.post('/api/facultades/', this.element)
                .then(response => {
                    console.log(this.volver('facultades', response.data))
                    this.status = 1;
                })
                .catch(e => {
                    console.log(e);
                    this.message = response.data;
                    this.status = -1; 
                });
            }   
            
        }
    }
  }
</script>