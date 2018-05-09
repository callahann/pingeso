<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">Datos personales</div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="apellido_paterno">Apellido paterno:</label>
                        <input type="text" class="form-control" id="apellido_paterno">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="apellido_materno">Apellido materno:</label>
                        <input type="text" class="form-control" id="apellido_materno">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombres:</label>
                        <input type="text" class="form-control" id="nombres">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="facultad">Facultad:</label>
                        <select class="form-control" id="facultad">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="depto">Departamento:</label>
                        <select class="form-control" id="depto">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="jerarquia">Jerarquía:</label>
                        <select class="form-control" id="jerarquia">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="jornada">Jornada:</label>
                        <select class="form-control" id="jornada">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
