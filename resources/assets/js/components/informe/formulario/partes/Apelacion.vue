<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title text-center">
            Apelación
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="col-md-9">Comentario</th>
                    <th class="col-md-3">Archivo</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="actual">
                    <td>1</td>
                    <td v-if="editable">
                        <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.comentario"></textarea>
                    </td>
                    <td v-else>{{ apelacion.comentario }}</td>
                    <td v-if="editable">
                        <label for="input" class="btn btn-info btn-block input-file">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{ apelacion.archivo !== undefined ? apelacion.archivo.name : 'Seleccionar archivo...' }}
                        </label>
                        <input id="input" type="file" ref="archivo" v-on:change="obtenerArchivo">
                    </td>
                    <td v-else>
                        <a :href="'/api/apelaciones/' + apelacion.id + '/adjunto'" v-if="apelacion.nombre_archivo" type="button" class="btn btn-info btn-block">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> {{ apelacion.nombre_archivo }}
                        </a>
                        <p class="text-center" v-else>No se adjuntó archivo a esta apelación</p>
                    </td>
                </tr>
                <tr v-for="(anterior, index) in apelaciones" :key="anterior.id" v-if="anterior.id !== apelacion.id">
                    <td>{{ index + 2 }}</td>
                    <td>{{ anterior.comentario }}</td>
                    <td>
                        <a :href="'/api/apelaciones/' + anterior.id + '/adjunto'" v-if="anterior.nombre_archivo" type="button" class="btn btn-info btn-block">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> {{ anterior.nombre_archivo }}
                        </a>
                        <p class="text-center" v-else>No se adjuntó archivo a esta apelación</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['apelaciones', 'actual'],
        data: function() {
            return {
                /**
                 * Objeto inicial. Se actualiza con los datos de la apelación
                 * existente, si hubiese.
                 */
                apelacion: {
                    comentario: '',
                    archivo: undefined
                },
                /**
                 * Listado de apelaciones anteriores [eliminar]
                 */
                anteriores: []
            }
        },
        created: function() {
            const index = this.apelaciones.findIndex(apelacion => {
                return apelacion.actual === true
            })
            if(index === -1) return;

            const actual = this.apelaciones[index]
            this.apelacion = Object.assign({}, this.apelacion, actual)
            this.anteriores = Object.assign([], this.anteriores, this.apelaciones)
            this.anteriores.splice(index, 1)
        },
        methods: {
            /**
             * Obtiene el archivo seleccionado por el usuario.
             */
            obtenerArchivo: function() {
                this.apelacion.archivo = this.$refs.archivo.files[0]
            }
        },
        computed: {
            /**
             * Indica si la apelación es editable.
             * @return Verdadero o falso
             */
            editable: function() {
                return this.apelacion.id === undefined
            }
        },
        watch: {
            /**
             * Observa y envía las modificaciones de la apelación al componente padre.
             */
            apelacion:  {
                handler(e) {
                    this.$emit('actualizar', e)
                },
                deep: true
            }
        }
    }
</script>