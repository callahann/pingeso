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
                    <router-link :to="{ name: 'informes' }" class="btn navbar-btn" role="button" active-class>Informes de Actividades</router-link>
                    <router-link :to="{ name: 'usuarios' }" class="btn navbar-btn" role="button" active-class v-if="auth.rol.id >= 3">Usuarios</router-link>
                    <a href="/logout" class="btn navbar-btn pull-right" role="button" active-class>Cerrar sesión</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>

