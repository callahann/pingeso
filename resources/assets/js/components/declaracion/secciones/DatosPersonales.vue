<template>
    <div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="apellido_paterno">Apellido paterno:</label>
                <input type="text" class="form-control" id="apellido_paterno"
                    v-model="datosPersonales.apellidoPaterno" :disabled="!editable">
            </div>
            <div class="form-group col-md-3">
                <label for="apellido_materno">Apellido materno:</label>
                <input type="text" class="form-control" id="apellido_materno"
                    v-model="datosPersonales.apellidoMaterno" :disabled="!editable">
            </div>
            <div class="form-group col-md-6">
                <label for="nombres">Nombres:</label>
                <input type="text" class="form-control" id="nombres"
                    v-model="datosPersonales.nombres" :disabled="!editable">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="facultad">Facultad:</label>
                <select class="form-control" id="facultad" 
                    v-model="datosPersonales.facultad" :disabled="!editable">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="depto">Departamento:</label>
                <select class="form-control" id="depto"
                    v-model="datosPersonales.departamento" :disabled="!editable">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="jerarquia">Jerarquía:</label>
                <select class="form-control" id="jerarquia"
                    v-model="datosPersonales.jerarquia" :disabled="!editable">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="jornada">Jornada:</label>
                <select class="form-control" id="jornada"
                    v-model="datosPersonales.jornada" :disabled="!editable">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['editable'],
        data: function() {
            return {
                datosPersonales: {
                    apellidoPaterno: 'Álvarez',
                    apellidoMaterno: 'Molina',
                    nombres: 'Mario Francisco',
                    facultad: 'Ingeniería',
                    departamento: 'Informática',
                    jerarquia: 'Cargo',
                    jornada: 'Jornada'
                }
            }
        },
        watch: {
            datosPersonales: function(newDatosPersonales) {
                this.$emit('actualizar', newDatosPersonales);
            }
        }
    }
</script>
