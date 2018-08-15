<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title text-center">
            Apelación
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Dirigida a</th>
                    <th class="text-center">Archivo</th>
                    <th class="text-center">Comentario</th>
                    <th class="text-center">Respuesta</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(apelacion, index) in previo.apelaciones" :key="index" v-if="apelacion !== null && (usuario || index === previo.comision)">
                    <td class="col-md-2">{{ etiquetas.comision[index] }}</td>
                    <td class="col-md-2">
                        <a :href="'/api/apelaciones/' + apelacion.id + '/adjunto'" v-if="apelacion.nombre_archivo" type="button" class="btn btn-xs btn-default btn-block">
                            <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> {{ apelacion.nombre_archivo }}
                        </a>
                        <div v-else>No se adjuntó archivo</div>
                    </td>
                    <td class="col-md-4">{{ apelacion.comentario }}</td>
                    <td class="col-md-4" v-if="usuario">
                        <div v-if="apelacion.resuelta">{{ apelacion.respuesta }}</div>
                        <i v-else>Aún no se ha resuelto esta apelación...</i>
                    </td>
                    <td class="col-md-4" v-else>     
                        <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.respuesta"></textarea>                   
                    </td>
                </tr>
                <tr class="panel-footer" v-if="previo.apelar">
                    <td class="col-md-2">
                        <select v-model="apelacion.comision" class="form-control">
                            <option v-for="tipo in comision" :key="tipo" :value="tipo"
                                v-if="previo.apelaciones[tipo] === null">
                                {{ etiquetas.comision[tipo] }}
                            </option>
                        </select>
                    </td>
                    <td class="col-md-2">
                        <label for="input" class="btn btn-info btn-block input-file">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> {{ apelacion.archivo !== undefined ? apelacion.archivo.name : 'Seleccionar archivo...' }}
                        </label>
                        <input id="input" type="file" ref="archivo" v-on:change="obtenerArchivo">
                    </td>
                    <td class="col-md-4">
                        <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.comentario"></textarea>
                    </td>
                    <td class="col-md-4"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        props: ['previo', 'usuario'],
        data: function() {
            return {
                /**
                 * Objeto inicial. Se actualiza con los datos de la apelación
                 * existente, si hubiese.
                 */
                apelacion: {
                    comentario: '',
                    respuesta: '',
                    comision: 0,
                    archivo: undefined
                }
            }
        },
        created: function() {
            if(!this.previo.apelado) return
            const comision = this.previo.comision
            this.apelacion = this.previo.apelaciones[comision]
        },
        methods: {
            /**
             * Obtiene el archivo seleccionado por el usuario.
             */
            obtenerArchivo: function() {
                this.apelacion.archivo = this.$refs.archivo.files[0]
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