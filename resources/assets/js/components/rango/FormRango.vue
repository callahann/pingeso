<template>  
    <div class="col-md-6 col-md-offset-3">
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'rangos'}">Listado</router-link></li>
            <li class="active">Rango</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Rango
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="nombres">Leyenda:</label>
                        <input v-if="editable" type="text" class="form-control" id="nombres"
                            v-model="element.leyenda">
                        <p v-else>{{ element.leyenda }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Base:</label>
                        <input v-if="editable" type="number" class="form-control" id="base"
                            v-model="element.base">
                        <p v-else>{{ element.base }}</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombres">Tope:</label>
                        <input v-if="editable" type="number" class="form-control" id="tope"
                            v-model="element.tope">
                        <p v-else>{{ element.tope }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="nombres">Color:</label>
                        <input v-if="editable" type="color" class="form-control" id="color"
                            v-model="element.color">
                        <p v-else>{{ element.color }}</p>
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
        INSERT_RANGO,
        UPDATE_RANGO
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
                this.volver('rangos', 'Se ha '+this.sentMessage+' el rango correctamente.')
            }
        },
        addElem(){
            if (this.accion=='Editar') {
                this.$store.dispatch(UPDATE_RANGO, { rango: this.element, cb: this.callback });
            } else {
                this.$store.dispatch(INSERT_RANGO, { rango: this.element, cb: this.callback });
            }   
            
        },
        format(value, selector){
            if ( (typeof value) == "string" ) {
               this.element[selector] = parseFloat(value.replace(',',"."))
            }
            this.element[selector] = parseFloat(value);
        }
    }
  }
</script>