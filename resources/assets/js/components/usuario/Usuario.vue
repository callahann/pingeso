<template>
    <div>
        <ol class="breadcrumb" v-if="editable">
            <li><router-link :to="{ name: 'inicio'}">Inicio</router-link></li>
            <li><router-link :to="{ name: 'usuarios'}">Listado</router-link></li>
            <li class="active">Usuario</li>
        </ol>
        <div v-if="mensaje === 1" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">[Cerrar &times;]</a>
            <a href="#" class="close" aria-label="close" v-on:click="volver('usuarios')">[Volver] </a>
            <strong>Bien!</strong> Se han guardado los cambios.
        </div>
        <div v-if="mensaje === -1" class="alert alert-danger">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = 0">&times;</a>
            <strong>Oh no!</strong> Ha ocurrido un error.
        </div>
        <cargando v-if="cargando > 0"></cargando>
        <div class="panel panel-default" v-else>
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
                        <select v-if="editable" class="form-control" id="facultad" v-model="facultad">
                            <option v-for="facultad in facultades"
                                :key="facultad.id"
                                :value="facultad">
                                {{ facultad.nombre }}
                            </option>
                        </select>
                        <p v-else>{{ usuario.facultad.nombre }}</p>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="depto">Departamento:</label>
                        <select v-if="editable" class="form-control" id="depto"
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
                        <select v-if="editable" class="form-control" id="rol"
                            v-model="usuario.rol">
                            <option v-for="rol in roles" :key="rol.id" :value="rol">{{ rol.nombre }}</option>
                        </select>
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
    export default {
        props: ['editable'],
        data: function() {
            return {
                usuario: {
                },
                facultad: {},
                facultades: [],
                jerarquias: [],
                jornadas: [],
                roles: [],
                cargando: 5,
                mensaje: 0
            }
        },
        created: function() {            
            this.$http
                .get('/api/usuarios/' + this.$route.params.id)
                .then(response => { 
                    let f = Object.assign({}, response.data.departamento.facultad)
                    delete response.data.departamento['facultad']
                    this.usuario = response.data

                    this.facultades.forEach((facultad) => {
                        if(facultad.id === f.id) this.facultad = Object.assign({}, facultad, this.facultad)
                    })

                    this.cargando--
                })
                .catch(e => {
                    console.log(e)
                    this.cargando--
                })

            this.$http
                .get('/api/facultades')
                .then(response => { 
                    this.facultades = response.data
                    this.cargando--
                })
                .catch(e => {
                    console.log(e)
                    this.cargando--
                })

            this.$http
                .get('/api/jerarquias')
                .then(response => { 
                    this.jerarquias = response.data
                    this.cargando--
                })
                .catch(e => {
                    console.log(e)
                    this.cargando--
                })

            this.$http
                .get('/api/jornadas')
                .then(response => { 
                    this.jornadas = response.data
                    this.cargando--
                })
                .catch(e => {
                    console.log(e)
                    this.cargando--
                })

            this.$http
                .get('/api/roles')
                .then(response => { 
                    this.roles = response.data
                    this.cargando--
                })
                .catch(e => {
                    console.log(e)
                    this.cargando--
                })
        },
        methods: {
            enviar: function() {
                this.$http
                    .post('/api/usuarios', this.usuario)
                    .then(response => { 
                        console.log(this.volver('usuarios', 'Se ha registrado el usuario correctamente.'))
                    })
                    .catch(e => {
                        console.log(e)
                        this.mensaje = -1
                    })
            },
            actualizar: function() {
                this.$http
                    .put('/api/usuarios/' + this.$route.params.id, this.usuario)
                    .then(response => { 
                        this.usuario = Object.assign({}, response.data, this.usuario)
                        this.mensaje = 1
                    })
                    .catch(e => {
                        console.log(e)
                        this.mensaje = -1
                    })
            },
        }
    }
</script>
