<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title text-center">
            Apelación
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-md-9">Comentario</th>
                    <th class="col-md-3">Archivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.comentario" v-if="editable"></textarea>
                        <p v-else>{{ apelacion.comentario }}</p>
                    </td>
                    <td v-if="editable">
                        <label for="input" class="btn btn-info btn-block input-file">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{ apelacion.archivo !== undefined ? apelacion.archivo.name : 'Seleccionar archivo...' }}
                        </label>
                        <input id="input" type="file" ref="archivo" v-on:change="obtenerArchivo">
                    </td>
                    <td v-else>
                        <button v-if="apelacion.nombre_archivo" type="button" class="btn btn-info btn-block" v-on:click="descargar">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> {{ apelacion.nombre_archivo }}
                        </button>
                        <p class="text-center" v-else>No se adjuntó archivo a esta apelación</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['previo'],
        data: function() {
            return {
                apelacion: {
                    comentario: '',
                    archivo: undefined
                }
            }
        },
        created: function() {
            this.apelacion = Object.assign({}, this.apelacion, this.previo)
        },
        methods: {
            obtenerArchivo: function() {
                this.apelacion.archivo = this.$refs.archivo.files[0]
            },
            descargar: function() {
                this.$http
                    .get('/api/apelaciones/' + this.apelacion.id + '/archivo')
                    .then(response => {
                        console.log('Se ha iniciado la descarga del archivo')
                    })
                    .catch(e => {
                        console.log(e)
                        this.mensaje = -1 
                    })
            }
        },
        computed: {
            editable: function() {
                return this.etapa === this.etapas.apelando && this.apelacion.id === undefined
            }
        },
        watch: {
            apelacion:  {
                handler(e) {
                    this.$emit('actualizar', e)
                },
                deep: true
            }
        }
    }
</script>