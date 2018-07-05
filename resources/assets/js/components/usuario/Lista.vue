<template>
    <div :class="{ 'col-md-12': auth.rol.id >= 3, 'col-md-8 col-md-offset-2': auth.rol.id <= 2 }">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de usuarios
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Apellido paterno</th>
                        <th class="text-center">Apellido materno</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center" v-if="auth.rol.id > 2">Facultad</th>
                        <th class="text-center" v-if="auth.rol.id > 2">Departamento</th>
                        <th class="text-center" v-if="auth.rol.id === 4">Rol</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="usuario in usuarios" v-bind:key="usuario.id">
                        <td>{{ usuario.apellido_paterno }}</td>
                        <td>{{ usuario.apellido_materno }}</td>
                        <td>{{ usuario.nombres }}</td>
                        <td v-if="auth.rol.id > 2">{{ usuario.departamento.facultad.nombre }}</td>
                        <td v-if="auth.rol.id > 2">{{ usuario.departamento.nombre }}</td>
                        <td v-if="auth.rol.id === 4">{{ usuario.rol.nombre }}</td>
                        <td class="col-md-2">
                            <router-link class="btn btn-xs btn-info btn-block" :to="{ name: 'editar-usuario', params: { id: usuario.id }}">     
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'nuevo-usuario'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar usuario
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapState } from 'vuex'

    export default {
        props: ['mensaje'],
        computed: mapState(['usuarios'])
    }
</script>
