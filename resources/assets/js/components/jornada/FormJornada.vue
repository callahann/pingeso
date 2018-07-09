<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'jornadas'}">Listado</router-link></li>
            <li class="active">Jornada</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Jornada
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
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="horas">Horas:</label>
                        <input v-if="editable" type="number" class="form-control" id="horas"
                            v-model="element.horas">
                        <p v-else>{{ element.horas }}</p>
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
    import {
        INSERT_JORNADA,
        UPDATE_JORNADA
    } from '../../vuex/actions'
    import { mapState } from 'vuex'
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
        this.sentMessage = (this.accion == 'Editar')?'actualizado':'creado';
    },
    data () {
        console.log(this);
        return {
        element: (this.elemento?this.elemento:{}),
        }
    },
    methods: {
        callback: function(ok = false, payload) {
            this.mensaje = ok ? 1 : -1
            this.element = Object.assign({}, this.element, payload)
            if (ok) {
                this.volver('jornadas', 'Se ha '+this.sentMessage+' la jornada correctamente.')
            }
        },
        addElem(){
            if (this.accion=='Editar') {
                this.$store.dispatch(UPDATE_JORNADA, { jornada: this.element, cb: this.callback });
            } else {
                this.$store.dispatch(INSERT_JORNADA, { jornada: this.element, cb: this.callback });
            }   
            
        }
    }
  }
</script>