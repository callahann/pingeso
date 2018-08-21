<template>
    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'usuarios'}">Listado</router-link></li>
            <li class="active">Usuario</li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                {{ !editable ? 'Datos personales' : usuario.id === undefined ? 'Agregar usuario' : 'Modificar usuario' }}
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="apellido_paterno">Apellido paterno:</label>
                        <input v-if="editable" type="text" class="form-control" id="apellido_paterno"
                            v-model="usuario.apellido_paterno">
                        <p v-else>{{ usuario.apellido_paterno }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="apellido_materno">Apellido materno:</label>
                        <input v-if="editable" type="text" class="form-control" id="apellido_materno"
                            v-model="usuario.apellido_materno">
                        <p v-else>{{ usuario.apellido_materno }}</p>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombres:</label>
                        <input v-if="editable" type="text" class="form-control" id="nombres"
                            v-model="usuario.nombres">
                        <p v-else>{{ usuario.nombres }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="facultad">Facultad:</label>
                        <select v-if="editable && auth.rol === rol.admin"
                            class="form-control" id="facultad"
                            v-model="facultad">
                            <option v-for="facultad in facultades"
                                :key="facultad.id"
                                :value="facultad">
                                {{ facultad.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ usuario.departamento.facultad.nombre }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="depto">Departamento:</label>
                        <select v-if="editable && auth.rol === rol.admin"
                            class="form-control" id="depto"
                            v-model="usuario.departamento">
                            <option v-if="facultad.departamentos !== undefined" 
                                v-for="departamento in facultad.departamentos"
                                :key="departamento.id"
                                :value="departamento">
                                {{ departamento.nombre }}
                            </option>
                            <option disabled value="" v-else>Seleccione una facultad...</option>
                        </select>
                        <p v-else>{{ usuario.departamento.nombre }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="jerarquia">Jerarquía:</label>
                        <select v-if="editable" class="form-control" id="jerarquia"
                            v-model="usuario.jerarquia">
                            <option v-for="jerarquia in jerarquias"
                                :key="jerarquia.id"
                                :value="jerarquia">
                                {{ jerarquia.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ usuario.jerarquia.nombre }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="jornada">Jornada:</label>
                        <select v-if="editable" class="form-control" id="jornada"
                            v-model="usuario.jornada">
                            <option v-for="jornada in jornadas"
                                :key="jornada.id"
                                :value="jornada">
                                {{ jornada.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ usuario.jornada.nombre }}</p>
                    </div>
                </div>
                <div class="row" v-if="editable">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail:</label>
                        <input id="email" type="text" class="form-control" placeholder="Correo institucional (@usach.cl)"
                            v-model="usuario.email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rol">Rol:</label>
                        <select v-if="auth.rol === rol.admin" class="form-control" id="rol"
                            v-model="usuario.rol">
                            <option v-for="rol in roles" :key="rol" :value="rol">{{ etiquetas.rol[rol] }}</option>
                        </select>
                        <p v-else>{{ etiquetas.rol[usuario.rol] }}</p>
                    </div>
                </div>
            </div>
            <div v-if="editable" class="panel-footer">
                <button v-if="usuario.id === undefined" type="button" class="btn btn-success" v-on:click="enviar">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span> Registrar
                </button>
                <button v-else type="button" class="btn btn-info" v-on:click="actualizar">
                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Guardar cambios
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import { INSERT_USUARIO, UPDATE_USUARIO } from '../../vuex/actions'
    import { mapState } from 'vuex'

    export default {
        props: ['editable', 'declarante'],
        data: function() {
            return {
                usuario: {
                    departamento: {
                        facultad: undefined
                    }
                },
                facultad: {},
                mensaje: 0
            }
        },
        created: function() {
            const usuario = this.editable && this.$route.params.id ? 
                            this.usuarios.find(usuario => {
                                console.log(usuario)
                                return usuario.id == this.$route.params.id
                            }) : this.declarante
            
            if(usuario) {
                this.usuario = Object.assign({}, this.usuario, this.copy(usuario))
                this.facultad = Object.assign({}, this.facultad, this.copy(usuario.departamento.facultad))
            } else if(this.auth.rol === this.rol.director) {
                const departamento = this.auth.departamento
                Vue.set(this.usuario, 'departamento', departamento)
                Vue.set(this.usuario, 'rol', 0)
                this.facultad = Object.assign({}, this.facultad, this.copy(this.auth.departamento.facultad))
            }
        },
        methods: {
            /**
             * Callback para mostrar un mensaje luego de obtener respuesta
             * desde la API.
             * @param ok Indica si la operación se realizó correctamente
             * @param payload Data (respuesta) obtenida desde la API
             */
            callback: function(ok = false, payload) {
                this.$root.$emit('alert', {
                    mensaje: ok ? payload.mensaje : '<strong>Oh no!</strong> Ha ocurrido un error.',
                    class: ok ? 'success' : 'danger'
                })
                this.usuario = Object.assign({}, this.usuario, payload.data)
            },
            enviar: function() {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha creado el usuario.' }
                this.$store.dispatch(INSERT_USUARIO, { usuario: this.usuario, cb: this.callback, payload })
            },
            actualizar: function() {
                const payload = { mensaje: '<strong>¡Bien!</strong> Se ha guardado los cambios.' }
                this.$store.dispatch(UPDATE_USUARIO, { usuario: this.usuario, cb: this.callback, payload })
            },
        },
        computed: mapState(['facultades', 'jerarquias', 'jornadas', 'usuarios'])
    }
</script>
