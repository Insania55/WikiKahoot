import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '../components/pages/WikiHome.vue';

Vue.use(VueRouter);

const routes = [
	{
		path: '/',
		name: 'Home',
		component: Home,
	},
	{
		path: '/descargarPreguntas',
		name: 'Descargar',
		// route level code-splitting
		// this generates a separate chunk (about.[hash].js) for this route
		// which is lazy-loaded when the route is visited.
		component: () =>
			import(
				/* webpackChunkName: "about" */ '../components/pages/WikiEventos.vue'
			),
	},
	{
		path: '/creacionEventos',
		name: 'Creación de eventos',
		component: () => import('../components/pages/WikiCreacion.vue'),
	},
	{
		path: '/ayuda',
		name: 'Ayuda',
		component: () => import('../components/pages/WikiHelp.vue'),
	},
	{
		path: '/descargarPreguntas/consultarSeleccion',
		name: 'Descarga actual',
		component: () => import('../components/CurrentDownload.vue'),
	},
];

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes,
});

export default router;
