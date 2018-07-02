import Vue from 'vue'
import VueRouter from 'vue-router'
import { EtapasEnum } from './const'
import store from './vuex/store'

Vue.use(VueRouter)

import Inicio from './components/Inicio'
import ListaInformes from './components/informe/Lista'
import Formulario from './components/informe/formulario/Formulario'
import ListaUsuarios from './components/usuario/Lista'
import Usuario from './components/usuario/Usuario'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/inicio',
            name: 'inicio',
            component: Inicio,
        },
        {
            path: '/usuarios',
            name: 'usuarios',
            component: ListaUsuarios,
            meta: { adminUsuarios: true }
        },
        {
            path: '/usuarios/crear',
            name: 'nuevo-usuario',
            component: Usuario,
            props: { editable: true },
            meta: { adminUsuarios: true }
        },
        {
            path: '/usuarios/:id',
            name: 'editar-usuario',
            component: Usuario,
            props: { editable: true },
            meta: { adminUsuarios: true }
        },
        {
            path: '/informes',
            name: 'informes',
            component: ListaInformes,
            props: true
        },
        {
            path: '/informes/declarar',
            name: 'nuevo-informe',
            component: Formulario,
            props: { etapa: EtapasEnum.declarando }
        },
        {
            path: '/informes/:id',
            name: 'etapa-informe',
            component: Formulario,
            props: true
        }
    ],
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.adminUsuarios)) {
        if (store.state.auth.rol.id < 3) {
            next({
                path: '/inicio',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

export { router }