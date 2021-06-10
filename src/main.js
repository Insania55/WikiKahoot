import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Vuelidate from 'vuelidate';

Vue.use(Vuelidate);
Vue.config.productionTip = false;

// * Permite la comunicación (emitir/recibir eventos) entre componentes hermanos, sin importar la estructura de carpetas
let eventHub = new Vue();
Vue.mixin({
	data: function() {
		return {
			eventHub,
		};
	},
});

new Vue({
	store,
	router,
	render: h => h(App),
}).$mount('#app');
