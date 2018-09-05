<template>
    <div class="col-md-12 col-lg-12">
        <input type="text" v-model="search" placeholder="Buscar usuarios"/>
        <br></br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Cargo</th>
                    <th>Departamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for = "user in filtrar">
                    <td>{{user.nombres}} {{user.apellido_paterno}}</td>
                    <td>{{user.email}}</td>
                    <td v-if="user.rol === 0"> Académico</td>
                    <td v-if="user.rol === 1"> Director Departamento</td>
                    <td v-if="user.rol === 2"> Administrador</td>
                    <td>{{user.departamento.nombre}}</td>
                    <td>
                        <button v-if="desactivar == false" v-on:click.prevent="agregar(user.id, tipo_usuario)" class="btn btn-xs btn-success">
                            <span class="glyphicon glyphicon-check" aria-hidden="true">Agregar</span>
                        </button>
                        <button v-else class="btn btn-xs btn-success disabled">
                            <span class="glyphicon glyphicon-check" aria-hidden="true">Agregar</span>
                        </button>       
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="panel-footer">
                
        </div>
    </div> 
</template>

<script>
    import axios from 'axios';
    export default {
        props: ['id_comision', 'tipo_usuario', 'id_entidad', 'tipo_entidad'],       
        created: function() {
            axios.get('/api/usuarios/comision/'
             + this.tipo_usuario+'/'+this.id_entidad+'/'+ this.tipo_entidad)
            .then(response => {
                this.users = response.data;
                console.log(this.users);
            });
        },
        computed: {
            filtrar: function(){
                return this.users.filter((user)=>
                {
                    return user.nombres.toLowerCase().match(this.search.toLowerCase());
                });
            }

        },
        methods: {
            agregar(user_id, tipo){
                axios.get('/api/usuarios/' + user_id)
                .then(response => {
                    this.seleccionado = response.data;
                    this.seleccionado.id_comision = this.id_comision;
                    this.seleccionado.rol_comision = this.tipo_usuario;
                    axios.put('/api/usuarios/comision/agregar/' + user_id, this.seleccionado)
                    .then(response => {
                        axios.get('/api/usuarios/comision/'
                        + this.tipo_usuario+'/'+this.id_entidad+'/'+ this.tipo_entidad)
                        .then(response => {
                            this.users = response.data;
                            this.desactivar = true;

                        });
                    });
                });      

            }
        },
        data () {
            return {
            users: [],
            search: '',
            desactivar: false
            }
        }
  }
</script>