<template>
    <div>
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <datos-personales></datos-personales>
            </div>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading panel-tabs">
                        <ul class="nav nav-tabs text-center">
                            <li class="active"><a data-toggle="tab" href="#docencia">Docencia</a></li>
                            <li><a data-toggle="tab" href="#invdes">Investigación y desarrollo</a></li>
                            <li><a data-toggle="tab" href="#asistec">Asistencia técnica</a></li>
                            <li><a data-toggle="tab" href="#perf">Perfeccionamiento</a></li>
                            <li><a data-toggle="tab" href="#adminacad">Administración académica</a></li>
                            <li><a data-toggle="tab" href="#extension">Extensión</a></li>
                            <li><a data-toggle="tab" href="#edcont">Educación continua</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="docencia" class="tab-pane fade in active">
                            <lista-items></lista-items>
                        </div>
                        <div id="invdes" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
                        <div id="asistec" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
                        <div id="perf" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
                        <div id="adminacad" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
                        <div id="extension" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
                        <div id="edcont" class="tab-pane fade">
                            <lista-items></lista-items>
                        </div>
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
