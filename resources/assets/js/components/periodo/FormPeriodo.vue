<template>
    <div class="col-md-8 col-md-offset-2">
        <ol class="breadcrumb">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'periodos'}">Listado</router-link></li>
            <li class="active">Periodo</li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ this.accion }} Periodo
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre"
                            v-model="periodo.nombre">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="etapa">Etapa:</label>
                        <select class="form-control" id="etapa" v-model="periodo.etapa">
                            <option v-for="etapa in etapas"
                                :key="etapa.id"
                                :value="etapa.id">
                                {{ etapa.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="desde">Desde:</label>
                        <input type="date" class="form-control" id="desde"
                            :value="periodo.desde && periodo.desde.toISOString().split('T')[0]"
                            v-on:input="periodo.desde = $event.target.valueAsDate">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="hasta">Hasta:</label>
                        <input type="date" class="form-control" id="hasta"
                            :value="periodo.desde && periodo.hasta.toISOString().split('T')[0]"
                            v-on:input="periodo.hasta = $event.target.valueAsDate">
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
    data: function() {
        return {
            periodo: this.elemento? this.format(this.elemento) : {},
            etapas: [
                { id: 1, nombre: "Etapa de Declaracion" },
                { id: 3, nombre: "Etapa de Informar trabajo realizado" },
                { id: 4, nombre: "Etapa de Evaluación" },
                { id: 5, nombre: "Etapa de Apelación" }
            ]
        }
    },
    methods: {
        /**
         * Callback para mostrar un mensaje luego de obtener respuesta
         * desde la API.
         * @param ok Indica si la operación se realizó correctamente
         * @param payload Data (respuesta) obtenida desde la API
         */
        callback: function(ok = false, payload) {
            this.$root.$emit('alert', {
                mensaje: ok ? payload.mensaje : '<strong>Oh no!</strong> Ha ocurrido un error.',
                class: ok ? 'success' : 'danger'
            })
            this.periodo = Object.assign({}, this.periodo, payload.data)
        },
        /**
         * Crea o actualiza un objeto de periodo.
         */
        addElem: function() {
            if (this.accion=='Editar') {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha registrado los cambios. Debe <strong>actualizar la página</strong> para reflejar los cambios.' }
                this.$store.dispatch(UPDATE_PERIODO, { periodo: this.periodo, cb: this.callback, payload })
            } else {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha creado el periodo.' }
                this.$store.dispatch(INSERT_PERIODO, { periodo: this.periodo, cb: this.callback, payload })
            }   
            
        },
        /**
         * Instancia las fechas de este objeto periodo como un objeto Date.
         * @param periodo Periodo para el cual se "formatearan" las fechas.
         * @return periodo con fechas de tipo Date.
         */
        format: function(periodo) {
            periodo.hasta = new Date(periodo.hasta)
            periodo.desde = new Date(periodo.desde)
            return periodo
        }
    }
  }
</script>