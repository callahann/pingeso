<template>
    <div class="col-md-8 col-md-offset-2">
        <div v-if="mensaje !== undefined" class="alert alert-success">
            <a href="#" class="close" aria-label="close" v-on:click="mensaje = undefined">&times;</a>
            {{ mensaje }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading panel-title text-center">
                Administración de usuarios
            </div>
            <div class="text-center" v-if="cargando">
                <h3>
                    <i class="fas fa-circle-notch fa-spin"></i> 
                    Cargando...
                </h3>
            </div>
            <div v-else>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Apellido paterno</th>
                            <th>Apellido materno</th>
                            <th>Nombres</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="usuario in usuarios" v-bind:key="usuario.id">
                            <td class="col-md-4">{{ usuario.apellido_paterno }}</td>
                            <td class="col-md-4">{{ usuario.apellido_materno }}</td>
                            <td class="col-md-6">{{ usuario.nombres }}</td>
                            <td class="col-md-6">{{ usuario.rol.nombre }}</td>
                            <td class="col-md-2">
                                <router-link class="btn btn-xs btn-info btn-block" :to="{ name: 'editar-usuario', params: { id: usuario.id }}">     
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <router-link class="btn btn-success" :to="{ name: 'nuevo-usuario'}">     
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar usuario
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        props: ['mensaje'],
        data: function() {
            return {
                usuarios: [],
                cargando: true,
            }
        },
        created: function() {
            axios.get('/api/usuarios')
                .then(response => {
                    this.usuarios = response.data;
                    this.cargando = false;
                })
                .catch(e => {
                    this.cargando = false;
                    console.log(e);
                });
        }
    }
</script>
