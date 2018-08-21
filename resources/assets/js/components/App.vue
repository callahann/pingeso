<template>
    <div>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button class="btn navbar-btn" v-on:click="$router.back()" v-show="$route.name !== 'inicio'">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <!-- Branding Image -->
                    <router-link :to="{ name: 'inicio' }">
                        <img :src="'/images/usach.png'" class="navbar-brand">
                    </router-link>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse" style="padding-left: 10em">
                    <!-- Left Side Of Navbar -->
                    <a href="/logout" class="btn navbar-btn pull-right" role="button" active-class>Cerrar sesión</a>
                    <p class="badge navbar-p pull-right">{{ auth.nombres.split(" ")[0] }} {{ auth.apellido_paterno }} <b>({{ etiquetas.rol[auth.rol] }})</b></p>
                </div>
            </div>
        </nav>
        <div class="container">
            <div v-if="alert.abierto" :class="'alert alert-' + alert.class">
                <a href="#" class="close" aria-label="close" v-on:click="alert.abierto = false">[Cerrar &times;]</a>
                <div v-html="alert.mensaje"></div>
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
                },
                interval: undefined
            }
        },
        created: function() {
            this.$root.$on('dismiss', () => {
                this.dismiss()
            })

            this.$root.$on('alert', alert => {
                this.dismiss()

                this.alert = Object.assign({}, this.alert, alert)
                this.alert.abierto = true
                
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;

                this.interval = setInterval(() => {
                    this.alert.abierto = false
                    clearInterval(this.interval)
                }, 5000)
            })
        },
        methods: {
            dismiss: function() {
                if(this.interval) clearInterval(this.interval)
                this.alert.abierto = false
            }
        }
    }
</script>

