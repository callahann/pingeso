<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'factores'}">Listado</router-link></li>
            <li class="active">Factor</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Factor
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="diferencia">Diferencia:</label>
                        <input v-if="editable" type="number" class="form-control" id="diferencia"
                            v-model="element.diferencia" step="0.01">
                        <p v-else>{{ element.diferencia }}</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="factor">Factor:</label>
                        <input v-if="editable" type="number" class="form-control" id="factor"
                            v-model="element.factor" step="0.01">
                        <p v-else>{{ element.factor }}</p>
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
        INSERT_FACTOR,
        UPDATE_FACTOR
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
        this.sendMessage = (this.accion == 'Editar')?'editado':'creado';
    },
    data () {
        return {
        element: (this.elemento?this.elemento:{}),
        }
    },
    methods: {
        callback: function(ok = false, payload) {
            this.mensaje = ok ? 1 : -1
            this.element = Object.assign({}, this.element, payload)
            if (ok) {
                this.volver('factores', 'Se ha '+this.sendMessage+' el factor correctamente.');
            }
        },
        addElem(){
            if (this.accion=='Editar') {
                this.$store.dispatch(UPDATE_FACTOR, { factor: this.element, cb: this.callback });
            } else {
                this.$store.dispatch(INSERT_FACTOR, { factor: this.element, cb: this.callback });
            }   
            
        },
    }
  }
</script>