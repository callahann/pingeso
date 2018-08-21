<template>
    <div>
        <div v-if="informes.length === 0" class="text-center">
            <h3>No se ha ingresado nuevos informes de actividades</h3>
        </div>
        <table v-else class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">Periodo</th>
                    <th class="text-center">Creado el</th>
                    <th class="text-center" v-if="auth.rol > rol.academico">Declarante</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="informe in informes" v-bind:key="informe.id">
                    <td class="text-center">{{ informe.periodo.nombre }}</td>
                    <td class="text-center">{{ new Date(informe.created_at).toString() }}</td>
                    <td v-if="auth.rol > rol.academico">{{ informe.usuario.apellido_paterno }} {{ informe.usuario.apellido_materno }} {{ informe.usuario.nombres }}</td>
                    <td class="text-center">{{ etiquetas.estado[informe.estado] }}</td>
                    <td>
                        <a v-if="auth.rol === rol.academico && informe.periodo.etapa === etapas.declarando && informe.estado <= estados.revisar">
                            <router-link
                                class="btn btn-xs btn-info"
                                :to="{ name: 'editar-informe', params: { id: informe.id }}">     
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&ensp;Editar
                            </router-link>
                            <a class="btn btn-xs btn-success" v-on:click="enviar(informe)">     
                                <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&ensp;Enviar
                            </a>
                        </a>
                        <router-link v-if="auth.rol === rol.director && informe.periodo.etapa === etapas.declarando && informe.estado === estados.enviado"
                            class="btn btn-xs btn-info"
                            :to="{ name: 'aprobar-informe', params: { id: informe.id }}">     
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Ver
                        </router-link>
                        <router-link v-if="auth.rol === rol.academico && informe.estado === estados.aprobado && informe.periodo.etapa === etapas.realizado"
                            class="btn btn-xs btn-info"
                            :to="{ name: 'realizado-informe', params: { id: informe.id }}">     
                            Informar realizado
                        </router-link>
                        <router-link v-if="evaluar(informe)"
                            class="btn btn-xs btn-info"
                            :to="{ name: 'evaluar-informe', params: { id: informe.id }}">     
                            Evaluar
                        </router-link>
                        <router-link v-if="auth.rol === rol.academico && informe.estado === estados.aprobado && informe.periodo.etapa === 5"
                            class="btn btn-xs btn-info"
                            :to="{ name: 'apelar-informe', params: { id: informe.id }}">     
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>&ensp;Ver calificación
                        </router-link>
                        <a href="#" class="btn btn-xs btn-default" v-on:click="descargar(informe)">
                            <span class="glyphicon glyphicon-download-alt"></span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
            <router-link class="btn btn-success text-right" :to="{ name: 'nuevo-informe'}" v-if="declarar">     
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar informe
            </router-link>
        </div>
    </div>
</template>
<script>
    import { SEND_DECLARACION } from '../../vuex/actions'

    export default {
        props: ['declarar', 'informes'],
        methods: {
            callback: function(ok = true, payload) {
                this.$root.$emit('alert', {
                    mensaje: ok ? 'Se ha enviado la declaración al Director de Departamento.' : '<strong>Oh no!</strong> Ha ocurrido un error.',
                    class: ok ? 'success' : 'danger'
                })
            },
            enviar: function(informe) {
                if(confirm('¿Está seguro que desea enviar esta declaración?')) {
                    this.$store.dispatch(SEND_DECLARACION, { informe, cb: this.callback })
                }
            },
            evaluar: function(informe) {
                const comision = this.auth.comision
                const usuario = informe.usuario
                const etapa = informe.periodo.etapa
                return usuario.id !== this.auth.id && comision !== null && (
                        (comision.tipo === this.comision.departamental && etapa === this.etapas.evaluando) || 
                        (informe.apelacion.apelado && comision.tipo === informe.apelacion.comision)
                    )
            },
            descargar: function(informe) {
                axios({
                  url: 'api/pdf/'+informe.id,
                  method: 'GET',
                  responseType: 'blob', // important
                }).then((response) => {
                  var nombre = informe.usuario.apellido_paterno+informe.usuario.apellido_materno+'_'+String(informe.created_at).split(' ')[0]
                  const url = window.URL.createObjectURL(new Blob([response.data]));
                  const link = document.createElement('a');
                  link.href = url;
                  link.setAttribute('download', nombre+'.pdf');
                  document.body.appendChild(link);
                  link.click();
                  link.remove();
                });
            }
        }
    }
</script>
