<template>
    <div class="panel panel-default">
        <div class="panel-heading panel-title text-center">Datos personales</div>
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="apellido_paterno">Apellido paterno:</label>
                    <input v-if="editable" type="text" class="form-control" id="apellido_paterno"
                        v-model="datosPersonales.apellido_paterno">
                    <p v-else>{{ datosPersonales.apellido_paterno }}</p>
                </div>
                <div class="form-group col-md-3">
                    <label for="apellido_materno">Apellido materno:</label>
                    <input v-if="editable" type="text" class="form-control" id="apellido_materno"
                        v-model="datosPersonales.apellido_materno">
                    <p v-else>{{ datosPersonales.apellido_materno }}</p>
                </div>
                <div class="form-group col-md-6">
                    <label for="nombres">Nombres:</label>
                    <input v-if="editable" type="text" class="form-control" id="nombres"
                        v-model="datosPersonales.nombres">
                    <p v-else>{{ datosPersonales.nombres }}</p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="facultad">Facultad:</label>
                    <select v-if="editable" class="form-control" id="facultad" 
                        v-model="datosPersonales.facultad">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                    <p v-else>{{ datosPersonales.facultad }}</p>
                </div>
                <div class="form-group col-md-3">
                    <label for="depto">Departamento:</label>
                    <select v-if="editable" class="form-control" id="depto"
                        v-model="datosPersonales.departamento">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                    <p v-else>{{ datosPersonales.departamento }}</p>
                </div>
                <div class="form-group col-md-3">
                    <label for="jerarquia">Jerarquía:</label>
                    <select v-if="editable" class="form-control" id="jerarquia"
                        v-model="datosPersonales.jerarquia">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                    <p v-else>{{ datosPersonales.jerarquia }}</p>
                </div>
                <div class="form-group col-md-3">
                    <label for="jornada">Jornada:</label>
                    <select v-if="editable" class="form-control" id="jornada"
                        v-model="datosPersonales.jornada">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                    <p v-else>{{ datosPersonales.jornada }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['editable'],
        watch: {
            datosPersonales: function(newDatosPersonales) {
                this.$emit('actualizar', newDatosPersonales);
            }
        }
    }
</script>
