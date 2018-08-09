<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title text-center">
            Apelación
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-md-9">Comentario</th>
                    <th class="col-md-3">{{ editable ? 'Dirigida a' : 'Archivo' }}</th>
                </tr>
            </thead>
            <tbody v-if="editable">
                <tr>
                    <td rowspan="3">
                        <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.comentario"></textarea>
                    </td>
                    <td>
                        <select v-model="apelacion.comision">
                            <option v-for="tipo in [...Array(comision.length - 1).keys()]"
                                :key="tipo" :value="tipo">{{ comision.etiquetas[tipo] }}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Archivo</th>
                </tr>
                <tr>
                    <td>
                        <label for="input" class="btn btn-info btn-block input-file">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{ apelacion.archivo !== undefined ? apelacion.archivo.name : 'Seleccionar archivo...' }}
                        </label>
                        <input id="input" type="file" ref="archivo" v-on:change="obtenerArchivo">
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td>{{ apelacion.comentario }}</td>
                    <td>
                        <a :href="'/api/apelaciones/' + apelacion.id + '/adjunto'" v-if="apelacion.nombre_archivo" type="button" class="btn btn-info btn-block">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> {{ apelacion.nombre_archivo }}
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
        props: ['previa', 'actual'],
        data: function() {
            return {
                /**
                 * Objeto inicial. Se actualiza con los datos de la apelación
                 * existente, si hubiese.
                 */
                apelacion: {
                    comentario: '',
                    comision: 0,
                    archivo: undefined
                }
            }
        },
        created: function() {
            if(this.previa === undefined) return
            this.apelacion = this.copy(this.previa)
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