import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);

export default new Vuex.Store({
	plugins: [
		createPersistedState({
			storage: window.sessionStorage,
		}),
	],
	state: {
		downloadData: [],
		downloadItemId: 0,
	},
	mutations: {
		setDownloadedData(state, data) {
			state.downloadData = data;
		},
		newId(state) {
			state.downloadItemId++;
		},
	},
	actions: {
		deleteItem({ commit, state }, id) {
			let arrayFiltrado = state.downloadData.filter(el => el.id != id);
			commit('setDownloadedData', arrayFiltrado);
		},
		getDownloadedData({ commit }) {},
	},
});
