<template>
    <div>
        <div class="panel-body">
            <div v-if="items.length == 0" class="text-center">
                <h3>No se han agregado items aún. Presione el botón "+"</h3>
            </div>
            <div v-else>
                <div class="items-heading text-center">
                    <!-- Primera fila -->
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <h4>Primer semestre</h4>
                    </div>
                    <div class="col-md-4">
                        <h4>Segundo semestre</h4>
                    </div>
                    <div class="col-md-1"></div>
                    <!-- Segunda fila -->
                    <div class="col-md-3">
                        <h4>Descripción</h4>
                    </div>
                    <div class="col-md-2">
                        <h4>Hrs. semana</h4>
                    </div>
                    <div class="col-md-2">
                        <h4>Hrs. semestre</h4>
                    </div>
                    <div class="col-md-2">
                        <h4>Hrs. semana</h4>
                    </div>
                    <div class="col-md-2">
                        <h4>Hrs. semestre</h4>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div v-for="(item, index) in items" v-bind:key="item.id">
                    <div class="form-group">
                        <div class="col-md-3">
                            <input class="form-control" v-model="item.descripcion">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" min=1 v-model.number="item.primero.horasSemana">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" min=1 v-model.number="item.primero.horasSemestre">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" min=1 v-model.number="item.segundo.horasSemana">
                        </div>
                        <div class="col-md-2">
                            <input type="number" class="form-control" min=1 v-model.number="item.segundo.horasSemestre">
                        </div>
                        <button type="button" class="btn btn-danger col-md-1"
                            v-on:click="quitarItem(index)"
                            v-bind:class="{ disabled: items.length == 1 }">
                            <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-right">
            <button type="button" class="btn btn-success" v-on:click="nuevoItem">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                id: 1,
                items: []
            }
        },
        methods: {
            nuevoItem: function() {
                this.items.push(
                    {
                        id: this.id++,
                        descripcion: '',
                        primero: {
                            horasSemana: 1,
                            horasSemestre: 1,
                        },
                        segundo: {
                            horasSemana: 1,
                            horasSemestre: 1,
                        }
                    }
                );
            },
            quitarItem: function(index) {
                this.items.splice(index, 1);
            }
        },
        watch: {
            items: function(newItems) {
                this.$emit('actualizar', newItems);
            }
        }
    }
</script>
