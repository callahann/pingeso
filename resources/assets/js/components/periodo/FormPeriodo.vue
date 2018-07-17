<template>  

    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'periodos'}">Listado</router-link></li>
            <li class="active">Periodo</li>
        </ol>
        <div v-if="status === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
            <br>
            {{this.message}}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Periodo
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input v-if="editable" type="text" class="form-control" id="nombre"
                            v-model="element.nombre">
                        <p v-else>{{ element.nombre }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="desde">Desde:</label>
                        <input v-if="editable" type="date" class="form-control" id="desde"
                            :value="element.desde && element.desde.toISOString().split('T')[0]"
                            v-on:input="element.desde = $event.target.valueAsDate">
                        <p v-else>{{ element.desde }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="hasta">Hasta:</label>
                        <input v-if="editable" type="date" class="form-control" id="hasta"
                            :value="element.desde && element.hasta.toISOString().split('T')[0]"
                            v-on:input="element.hasta = $event.target.valueAsDate">
                        <p v-else>{{ element.hasta }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="etapa">Etapa:</label>
                        <select v-if="editable" class="form-control" id="etapa" v-model="element.etapa">
                            <option v-for="etapa in etapas"
                                :key="etapa.id"
                                :value="etapa.id">
                                {{ etapa.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ element.etapa }}</p>
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
        INSERT_PERIODO,
        UPDATE_PERIODO
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
        this.etapas = [
            {id: 1, nombre: "Etapa de Declaracion"},
            {id: 3, nombre: "Etapa de Informar trabajo realizado"},
            {id: 4, nombre: "Etapa de Evaluación"},
            {id: 5, nombre: "Etapa de Apelación"}
        ];
        this.sentMessage = (this.accion == 'Editar')?'actualizado':'creado';
    },
    data () {
        console.log(this);
        return {
        element: (this.elemento?this.format(this.elemento):{}),
        }
    },
    methods: {
        callback: function(ok = false, payload) {
            this.mensaje = ok ? 1 : -1
            this.element = Object.assign({}, this.element, payload)
            if (ok) {
                this.volver('periodos', 'Se ha '+this.sentMessage+' el periodo correctamente.')
            }
        },
        addElem(){
            if (this.accion=='Editar') {
                this.$store.dispatch(UPDATE_PERIODO, { periodo: this.element, cb: this.callback });
            } else {
                this.$store.dispatch(INSERT_PERIODO, { periodo: this.element, cb: this.callback });
            }   
            
        },
        format(elemento){
            console.log('Elemento', elemento.hasta);
            console.log('ElementoD', elemento.desde);
            elemento.hasta = new Date(elemento.hasta);
            elemento.desde = new Date(elemento.desde);
            console.log('Elemento2', elemento.hasta);
            console.log('ElementoD2', elemento.desde);
            return elemento;
        }
    }
  }
</script>