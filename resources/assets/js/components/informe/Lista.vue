<template>
    <div class="col-md-8 col-md-offset-2">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div v-if="declarar(true)" class="alert alert-warning">
            <strong>Atención: </strong> Puede enviar su declaración hasta el <b>{{ hasta }}</b>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Informes de actividades
            </div>
            <div v-if="informes.length === 0" class="text-center">
                <h3>No se ha ingresado nuevos informes de actividades</h3>
            </div>
            <table v-else class="table table-striped">
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Creado el</th>
                        <th v-if="auth.rol.id > 1">Declarante</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="informe in informes" v-bind:key="informe.id">
                        <td>{{ informe.periodo.nombre }}</td>
                        <td>{{ new Date(informe.created_at).toString() }}</td>
                        <td v-if="auth.rol.id > 1">{{ informe.usuario.apellido_paterno }} {{ informe.usuario.apellido_materno }} {{ informe.usuario.nombres }}</td>
                        <td>{{ estados.etiquetas[informe.estado] }}</td>
                        <td class="col-md-2" v-if="informe.periodo.actual">
                            <a v-if="auth.rol.id === rol.academico && informe.periodo.etapa === etapas.declarando && informe.estado <= estados.revisar">
                                <router-link
                                    class="btn btn-xs btn-info btn-block"
                                    :to="{ name: 'editar-informe', params: { id: informe.id }}">     
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&ensp;Editar
                                </router-link>
                                <a class="btn btn-xs btn-success btn-block" v-on:click="enviar(informe)">     
                                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar
                                </a>
                            </a>
                            <router-link v-if="auth.rol.id === rol.director && informe.periodo.etapa === etapas.declarando && informe.estado === estados.enviado"
                                class="btn btn-xs btn-info btn-block"
                                :to="{ name: 'aprobar-informe', params: { id: informe.id }}">     
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Ver
                            </router-link>
                            <router-link v-if="auth.rol.id === rol.academico && informe.estado === estados.aprobado && informe.periodo.etapa === etapas.realizado"
                                class="btn btn-xs btn-info btn-block"
                                :to="{ name: 'realizado-informe', params: { id: informe.id }}">     
                                Informar realizado
                            </router-link>
                            <router-link v-if="auth.rol.id === rol.comision && (informe.periodo.etapa === etapas.evaluando || (informe.periodo.etapa === etapas.apelando && tieneApelacion(informe)))"
                                class="btn btn-xs btn-info btn-block"
                                :to="{ name: 'evaluar-informe', params: { id: informe.id }}">     
                                Evaluar
                            </router-link>
                            <router-link v-if="auth.rol.id === rol.academico && informe.estado === estados.aprobado && informe.periodo.etapa === 5"
                                class="btn btn-xs btn-info btn-block"
                                :to="{ name: 'apelar-informe', params: { id: informe.id }}">     
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Ver calificación
                            </router-link>
                        </td>
                        <td v-else>
                            <router-link v-if="auth.rol.id === rol.academico && informe.estado === estados.aprobado && informe.periodo.etapa === 5"
                                class="btn btn-xs btn-info btn-block"
                                :to="{ name: 'apelar-informe', params: { id: informe.id }}">     
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Ver calificación
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success text-right" :to="{ name: 'nuevo-informe'}" v-if="declarar()">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar informe
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'
    import { SEND_DECLARACION } from '../../vuex/actions'

    export default {
        props: ['mensaje'],
        methods: {
            callback: function(ok = true, payload) {
                if(ok) this.mensaje = 'Se ha enviado la declaración al Director de Departamento'
            },
            declarar: function(enviar = false) {
                if(this.auth.rol.id > this.rol.academico || this.auth.departamento.periodo === null) return false

                const periodo = this.auth.departamento.periodo
                if(periodo.etapa > 1) return false

                const ahora = Date.now()
                const desde = Date.parse(periodo.desde)
                const hasta = Date.parse(periodo.hasta)
                if(desde > ahora || ahora > hasta) return false

                const informe = this.informes.find(informe => {
                    return informe.periodo.id === periodo.id
                })
                return informe === undefined || (enviar && informe.estado <= 1)
            },
            enviar: function(informe) {
                if(confirm('¿Está seguro que desea enviar esta declaración?')) {
                    this.$store.dispatch(SEND_DECLARACION, { informe, cb: this.callback })
                }
            },
            tieneApelacion: function(informe) {
                return informe.apelaciones.find(apelacion => {
                    return apelacion.actual
                }) !== undefined
            }
        },
        computed: {
            ...mapState(['informes']),
            hasta: function() {
                const hastaStr = this.auth.departamento.periodo.hasta
                const hasta = new Date(hastaStr)
                return hasta.toStringWithTime()
            }
        }
    }
</script>
