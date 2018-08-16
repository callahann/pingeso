<template>
    <div>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <img :src="'/images/usach.png'" class="navbar-brand">
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="padding-left: 10em">
                    <!-- Left Side Of Navbar -->
                    <router-link :to="{ name: 'inicio' }" class="btn navbar-btn" role="button" active-class>Inicio</router-link>
                    <router-link :to="{ name: 'informes' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol < rol.admin">Informes de Actividades</router-link>
                    <div class="btn-group" v-if="auth.rol === rol.director || auth.rol === rol.admin">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Administrar <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><router-link :to="{ name: 'editar-departamento', params: { accion: 'Editar', elemento: copy(auth.departamento) } }" class="btn navbar-btn" v-if="auth.rol === rol.director">Departamento</router-link></li>
                            <li><router-link :to="{ name: 'periodos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.director">Periodos</router-link></li>
                            <li><router-link :to="{ name: 'comision-superior' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Comisión Superior</router-link></li>
                            <li><router-link :to="{ name: 'departamentos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Departamentos</router-link></li>
                            <li><router-link :to="{ name: 'factores' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Factores</router-link></li>
                            <li><router-link :to="{ name: 'facultades' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Facultades</router-link></li>
                            <li><router-link :to="{ name: 'editar-formulas' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Formulas</router-link></li>
                            <li><router-link :to="{ name: 'jerarquias' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Jerarquias</router-link></li>
                            <li><router-link :to="{ name: 'jornadas' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Jornadas</router-link></li>
                            <li><router-link :to="{ name: 'rangos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol === rol.admin">Rangos</router-link></li>
                            <li><router-link :to="{ name: 'usuarios' }" class="btn navbar-btn" role="button" active-class>Usuarios</router-link></li>
                        </ul>
                    </div>
                    <a href="/logout" class="btn navbar-btn pull-right" role="button" active-class>Cerrar sesión</a>
                    <p class="badge navbar-p pull-right">{{ auth.nombres.split(" ")[0] }} {{ auth.apellido_paterno }} <b>({{ etiquetas.rol[auth.rol] }})</b></p>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="col-md-12">
                <div v-if="alert.abierto" :class="'alert alert-' + alert.class">
                    <a href="#" class="close" aria-label="close" v-on:click="alert.abierto = false">[Cerrar &times;]</a>
                    <a href="#" class="close" aria-label="close"
                        v-for="boton in alert.botones" :key="boton.texto"
                        v-on:click="boton.enlace">[{{ boton.texto }}] </a>
                    <p :html="alert.mensaje"></p>
                </div>
            </div>
            <router-view v-on:alert="mensaje($event)"></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                alert: {
                    mensaje: '',
                    class: '',
                    abierto: false
                }
            }
        },
        methods: {
            mensaje: function(alert) {
                this.alert = Object.assign({}, this.alert, alert);
                this.alert.abierto = true;
            }
        }
    }
</script>

