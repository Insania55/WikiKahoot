import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// Actualmente la página accede a los componentes mediante ruta, en caso de complicarse más la estructura sería interesante la opción de Vue "named routes"
const routes = [
	{
		path: '/',
		component: () => import('../components/pages/WikiHome.vue'),
	},
	{
		path: '/consultar',
		component: () => import('../components/pages/WikiEventos.vue'),
	},
	{
		path: '/creacionEventos',
		component: () => import('../components/pages/WikiCreacion.vue'),
	},
	{
		path: '/ayuda',
		component: () => import('../components/pages/WikiHelp.vue'),
	},
	{
		path: '/about',
		component: () => import('../components/pages/WikiAbout.vue'),
	},
	{
		path: '/consultar/consultarSeleccion',
		component: () => import('../components/CurrentDownload.vue'),
	},
];

const router = new VueRouter({
	mode: 'history',
	base: process.env.BASE_URL,
	routes,
});

export default router;
