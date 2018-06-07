<template>
    <div class="col-md-12">
        <div class="row">
            <ol class="breadcrumb">
                <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
                <li><router-link :to="{ name: 'informes'}">Listado</router-link></li>
                <li class="active">Evaluación</li>
            </ol>
        </div>
        <div class="row" v-if="etapa === etapas.evaluando">
            <datos-personales v-bind:editable="false"></datos-personales>
        </div>
        <div class="row">
            <div class="panel panel-default text-center" v-if="cargando">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
            <evaluacion v-else :informe="informe" :etapa="etapa"></evaluacion>
        </div>
        <div class="row" v-if="etapa === etapas.evaluando && apelacion.id === undefined">
            {{ apelacion.id }}
            {{ apelacion }}
            <div class="panel panel-default">
                <div class="panel-heading panel-tabs">
                    <ul class="nav nav-tabs text-center">
                        <li v-for="(value, key) in  informe" :key="key"
                            :class="{ active: key === 'item_docencia' }" v-if="key.startsWith('item')">
                            <a data-toggle="tab" :href="'#' + key">{{ titulos_item[key] }}</a>
                        </li>
                    </ul>
                </div>
                <div class="text-center" v-if="cargando">
                    <h3>
                        <i class="fas fa-circle-notch fa-spin"></i> 
                        Cargando...
                    </h3>
                </div>
                <div class="tab-content" v-else>
                    <div :id="key" v-for="(value, key) in  informe" :key="key"
                        class="tab-pane fade" :class="{ 'in active': key === 'item_docencia' }"
                        v-if="key.startsWith('item')">
                        <lista-actividades :previo="value.actividades" :etapa="etapas.evaluando"
                            v-on:actualizar="value.actividades = $event"></lista-actividades>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-else>
            <div class="panel panel-default text-center" v-if="cargandoApelacion">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
            <apelacion :previo="apelacion"
                :editable="etapa === etapas.apelando && apelacion.id === undefined" 
                v-on:actualizar="apelacion = $event" v-else></apelacion>
        </div>
        <!-- Mensajes -->
        <div class="row">
            <div v-if="mensaje === 1" class="alert alert-success">
                <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">[Cerrar &times;]</a>
                <a href="#" class="close" aria-label="close" v-on:click="volver">[Volver] </a>
                <strong>Bien!</strong> Se han guardado los cambios de la evaluación.
            </div>
            <div v-if="mensaje === -1" class="alert alert-danger">
                <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
                <strong>Oh no!</strong> Ha ocurrido un error.
            </div>
        </div>
        <!-- Footer -->
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-footer">
                    <button v-if="etapa === etapas.evaluando" type="button" class="btn btn-info" v-on:click="actualizar">
                        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                    </button>
                    <button v-else type="button" class="btn btn-success" v-on:click="enviar">
                        <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar apelación
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Base from './base';
    import DatosPersonales from '../../DatosPersonales.vue';
    import Evaluacion from './partes/Evaluacion';
    import ListaActividades from './partes/ListaActividades';
    import Apelacion from './partes/Apelacion';

    export default {
        mixins: [Base],
        data: function() {
            return {
                apelacion: {
                    id_declaracion: 0
                },
                cargandoApelacion: true
            }
        },
        components: {
            'datos-personales': DatosPersonales,
            'evaluacion': Evaluacion,
            'lista-actividades': ListaActividades,
            'apelacion': Apelacion
        },
        methods: {
            obtenerApelacion: function() {
                axios
                    .get('/api/apelaciones/' + this.informe.id)
                    .then(response => { 
                        console.log("Se ha obtenido la apelación. Copiando localmente...");
                        this.apelacion = response.data;
                        this.cargandoApelacion = false;
                    })
                    .catch(e => {
                        console.log(e);
                        this.cargandoApelacion = false;
                    });
            },
            enviar: function() {
                axios
                    .post('/api/apelaciones', this.formData(this.apelacion),
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        console.log(this.volver('Se ha registrado la apelación correctamente'));
                    })
                    .catch(e => {
                        console.log(e);
                        this.mensaje = -1; 
                    });
            }
        }
    }
</script>