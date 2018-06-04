<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title">
            Apelación
        </div>
        <div class="panel-body">
            <textarea class="col-md-12 form-control" rows=3 v-model="apelacion.descripcion" v-if="editable"></textarea>
            <p v-else>{{ apelacion.descripcion }}</p>
        </div>
        <div class="panel-footer">
            <label for="archivo">Archivo: </label>
            <input type="file" id="archivo" class="form-control">
        </div>
    </div>
</template>
<script>
    export default {
        props: ['previo', 'editable'],
        data: function() {
            return {
                apelacion: {
                    descripcion: '',
                    nombre_archivo: null
                }
            }
        },
        created: function() {
            Object.assign(this.apelacion, this.previo);
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