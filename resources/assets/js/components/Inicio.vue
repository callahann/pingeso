<template>
    <div class="col-md-12">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Bienvenid@ {{ auth.nombres.split(' ')[0] }} {{ auth.apellido_paterno }}</h3>
                        <p>Usted tiene el rol de <b>{{ etiquetas.rol[auth.rol] }}</b></p>
                        <p v-if="auth.comision !== null">Además, pertenece a <b>{{ etiquetas.comision[auth.comision.tipo] }}</b> {{ auth.comision.tipo === comision.departamental ? 'del departamento de ' + auth.departamento.nombre : auth.comision.tipo === comision.facultad ? 'de la ' + auth.departamento.facultad.nombre : '' }}</p>
                    </div>
                </div>
                <div class="panel panel-default" v-if="auth.rol === rol.director">
                    <div class="panel-heading panel-title text-center">Administrar</div>
                    <div class="panel-body dash">
                        <router-link :to="{ name: 'editar-departamento', params: { accion: 'Editar', elemento: copy(auth.departamento) } }"
                            class="btn dash-btn dash-btn-grid col-md-4" v-tooltip:bottom="'Departamento'">
                            <i class="fas fa-building"></i>
                        </router-link>
                        <router-link :to="{ name: 'periodos' }" class="btn dash-btn dash-btn-grid col-md-4" v-tooltip:bottom="'Periodos'">
                            <i class="far fa-calendar-alt"></i>
                        </router-link>
                        <router-link :to="{ name: 'usuarios' }" class="btn dash-btn dash-btn-grid col-md-4" v-tooltip:bottom="'Usuarios'">
                            <i class="fas fa-user-cog"></i>
                        </router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div v-if="declarar(true)" class="alert alert-warning">
                    <strong>¡Atención!</strong> Puede enviar su declaración hasta el {{ new Date(auth.departamento.periodo.hasta).toStringWithTime() }}
                </div>
                <div class="panel panel-default" v-if="auth.rol === rol.admin">
                    <div class="panel-heading panel-title text-center">Administrar</div>
                    <div class="panel-body dash">
                        <router-link :to="{ name: 'comision-superior' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-users"></i>&ensp;Comisión superior
                        </router-link>
                        <router-link :to="{ name: 'departamentos' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-building"></i>&ensp;Departamentos
                        </router-link>
                        <router-link :to="{ name: 'factores' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-superscript"></i>&ensp;Factores
                        </router-link>
                        <router-link :to="{ name: 'facultades' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-university"></i>&ensp;Facultades
                        </router-link>
                        <router-link :to="{ name: 'editar-formulas' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-calculator"></i>&ensp;Fórmulas
                        </router-link>
                        <router-link :to="{ name: 'jerarquias' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-sitemap"></i>&ensp;Jerarquías
                        </router-link>
                        <router-link :to="{ name: 'jornadas' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-user-clock"></i>&ensp;Jornadas
                        </router-link>
                        <router-link :to="{ name: 'rangos' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-signal"></i>&ensp;Rangos
                        </router-link>
                        <router-link :to="{ name: 'usuarios' }" class="btn dash-btn col-md-6">
                            <i class="fas fa-user-cog"></i>&ensp;Usuarios
                        </router-link>
                    </div>
                </div>
                <div class="panel panel-default" v-else>
                    <div class="panel-heading panel-tabs" v-if="auth.comision != null">
                        <ul class="nav nav-tabs text-center">
                            <li class="active"><a data-toggle="tab" href="#usuario">Usuario</a></li>
                            <li><a data-toggle="tab" href="#comision">Comisión</a></li>
                        </ul>
                    </div>
                    <div class="panel-heading panel-title text-center" v-else>
                        Informes de actividades
                    </div>
                    <div class="tab-content">
                        <div id="usuario" class="tab-pane fade in active">
                            <lista-informes :informes="informes.usuario" :declarar="declarar()"></lista-informes>
                        </div>
                        <div id="comision" class="tab-pane fade in">
                            <lista-informes :informes="informes.comision" :declarar="false"></lista-informes>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import ListaInformes from './informe/Lista'
    import { mapState } from 'vuex'

    export default {
        props: ['mensaje'],
        components: {
            'lista-informes': ListaInformes
        },
        methods: {
            declarar: function(enviar = false) {
                if(this.auth.rol > this.rol.academico || this.auth.departamento.periodo === null) return false

                const periodo = this.auth.departamento.periodo
                if(periodo.etapa > 1) return false

                const ahora = Date.now()
                const desde = Date.parse(periodo.desde)
                const hasta = Date.parse(periodo.hasta)
                if(desde > ahora || ahora > hasta) return false

                const informe = this.informes.usuario.find(informe => {
                    return informe.periodo.id === periodo.id
                })
                return informe === undefined || (enviar && informe.estado <= 1)
            }
        },
        computed: mapState(['informes'])
    }
</script>