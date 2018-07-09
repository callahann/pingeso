<template>
    <div>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <input type="number" class="col-md-2 from-control" v-model.number="auth.rol.id"/>
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <img :src="'/images/usach.png'" class="navbar-brand">
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="padding-left: 10em">
                    <!-- Left Side Of Navbar -->
                    <router-link :to="{ name: 'inicio' }" class="btn navbar-btn" role="button" active-class>Inicio</router-link>
                    <router-link :to="{ name: 'informes' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id < 4">Informes de Actividades</router-link>
                    <router-link :to="{ name: 'usuarios' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 2 || auth.rol.id === 4">Usuarios</router-link>
                    <router-link :to="{ name: 'facultades' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Facultades</router-link>
                    <router-link :to="{ name: 'departamentos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Departamentos</router-link>
                    <router-link :to="{ name: 'rangos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Rangos</router-link>
                    <router-link :to="{ name: 'jerarquias' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Jerarquias</router-link>
                    <router-link :to="{ name: 'jornadas' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Jornadas</router-link>
                    <router-link :to="{ name: 'factores' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Factores</router-link>
                    <router-link :to="{ name: 'periodos' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id === 4">Periodos</router-link>


                    <a href="/logout" class="btn navbar-btn pull-right" role="button" active-class>Cerrar sesión</a>
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

