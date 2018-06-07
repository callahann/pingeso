<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title">
            Apelación
        </div>
        <div class="panel-body">
            <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.comentario" v-if="editable"></textarea>
            <p v-else>{{ apelacion.comentario }}</p>
        </div>
        <div class="panel-footer">
            <label for="archivo">Archivo: </label>
            <input type="file" ref="archivo" v-on:change="obtenerArchivo" class="form-control btn btn-info">
        </div>
    </div>
</template>
<script>
    export default {
        props: ['previo', 'editable'],
        data: function() {
            return {
                apelacion: {
                    comentario: '',
                    archivo: ''
                }
            }
        },
        created: function() {
            Object.assign(this.apelacion, this.previo);
        },
        methods: {
            obtenerArchivo: function() {
                this.apelacion.archivo = this.$refs.archivo.files[0];
            }
        },
        watch: {
            apelacion:  {
                handler(e) {
                    this.$emit('actualizar', e);
                },
                deep: true
            }
        }
    }
</script>