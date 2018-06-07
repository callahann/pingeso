import axios from 'axios';
export default {
    props: ['etapa'],
    data: function() {
        return {
            informe: {},
            cargando: true,
            mensaje: 0
        }
    },
    created: function() {
        axios
            .get('/api/declaraciones/' + this.$route.params.id)
            .then(response => { 
                console.log("Se ha obtenido la data. Copiando localmente...");
                Object.assign(this.informe, response.data);

                if(this.etapa >= this.etapas.evaluando) {
                    this.apelacion.id_declaracion = this.informe.id;
                    this.obtenerApelacion();
                }
                    
                this.cargando = false;
            })
            .catch(e => {
                console.log(e);
                this.cargando = false;
            });
    },
    methods: {
        actualizar: function() {
            axios
                .put('/api/declaraciones/' + this.$route.params.id, this.informe)
                .then(response => { 
                    console.log("Se han actualizado los datos!");
                    this.mensaje = 1;
                })
                .catch(e => {
                    console.log(e);
                    this.mensaje = -1; 
                });
        },
        volver: function(mensaje = undefined) {
            this.$router.push({
                name: 'informes',
                params: { 
                    mensaje: mensaje
                }
            });
            return mensaje;
        }
    }
}