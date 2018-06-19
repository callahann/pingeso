<template>
    <div class="col-md-12">
        <h1>Sistema de evaluación y calificación de desempeño académico</h1>
        <h2>Bienvenido, {{nombre}}</h2>
        <div>
            <blockquote>
                <h3>Plataforma de gestión de distribución de tiempo académica, cuyas principales funciones son:</h3>
                <ul>
                    <li>Crear convenio de académico.</li>
                    <li>Renegociar convenios.</li>
                    <li>Revisión de convenios a la finalización del periodo lectivo.</li>
                    <li>Edición de la evaluación de la distribución de tiempo académica.</li>
                    <li>Pre-evaluación de convenios.</li>
                    <li>Justificación sobre las actividades.</li>
                </ul>
            </blockquote>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        
        data: function() {
            return {
                nombre: 'nombre'
                
            }
        },
        created: function() {
            axios.get('/user/name')
            .then(response=> {
              this.nombre = response.data;
              console.log(this.nombre);
            })
            .catch(e => {
                this.cargando = false;
                console.log(e);
            });
        }
    }
</script>