import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import * as api from '../components/js/api.js';

Vue.use(Vuex);

export default new Vuex.Store({
	plugins: [
		createPersistedState({
			storage: window.sessionStorage,
		}),
	],
	state: {
		storedData: [],
		downloadItemId: 0,
		filteredData: [],
		filteredHeaders: [],
		optionsEtapa: [],
		optionsNivel: [],
		optionsArea: [],
		optionsTema: [],
	},
	mutations: {
		setStoredData(state, data) {
			state.storedData = data;
		},
		addToStoredData(state, data) {
			state.storedData.push(data);
		},
		setEtapas(state, data) {
			state.optionsEtapa = data;
		},
		setNiveles(state, data) {
			state.optionsNivel = data;
		},
		setAreas(state, data) {
			state.optionsArea = data;
		},
		setTemas(state, data) {
			state.optionsTema = data;
		},
		saveFilteredData(state, data) {
			state.filteredData = data;
		},
		saveFilteredHeaders(state, data) {
			state.filteredHeaders = data;
		},
		newId(state) {
			state.downloadItemId++;
		},
		//TODO Trasladar a archivo JS aparte
		scrollToView(target) {
			target.onclick = document.documentElement.scrollIntoView({
				behavior: 'smooth',
			});
		},
	},
	actions: {
		deleteItem({ commit, state }, id) {
			let arrayFiltrado = state.storedData.filter(el => el.id != id);
			commit('setStoredData', arrayFiltrado);
		},
		loadEtapas({ commit }) {
			api.getEtapas()
				.then(response => {
					if (response.status === 200 && response.data.length > 0) {
						const selectEtapas = response.data.reduce(
							(acc, value) => {
								acc.push({
									value: value.IdEtapa,
									text: value.Nombre,
								});
								return acc;
							},
							[]
						);
						commit('setEtapas', selectEtapas);
					}
				})
				.catch(error => {
					console.error(
						'Fallo en la petición para cargar las etapas',
						error
					);
				});
		},
		loadNiveles({ commit }) {
			api.getNiveles()
				.then(response => {
					if (response.status === 200 && response.data.length > 0) {
						const selectNiveles = response.data.reduce(
							(acc, value) => {
								acc.push({
									value: value.IdNivel,
									text: value.Nombre,
								});
								return acc;
							},
							[]
						);
						commit('setNiveles', selectNiveles);
					}
				})
				.catch(error => {
					console.error(
						'Fallo en la petición para cargar los niveles',
						error
					);
				});
		},
		loadAreas({ commit }) {
			api.getAreas()
				.then(response => {
					if (response.status === 200 && response.data.length > 0) {
						const selectAreas = response.data.reduce(
							(acc, value) => {
								acc.push({
									value: value.IdArea,
									text: value.Nombre,
								});
								return acc;
							},
							[]
						);
						commit('setAreas', selectAreas);
					}
				})
				.catch(error => {
					console.error(
						'Fallo en la petición para cargar las áreas',
						error
					);
				});
		},
		loadTemas({ commit }, idArea) {
			if (idArea !== undefined && idArea !== null) {
				api.getTemas(idArea)
					.then(response => {
						if (
							response.status === 200 &&
							response.data.length > 0
						) {
							const selectTemas = response.data.reduce(
								(acc, value) => {
									acc.push({
										value: value.IdTema,
										text: value.Nombre,
									});
									return acc;
								},
								[]
							);
							commit('setTemas', selectTemas);
						}
					})
					.catch(error => {
						console.error(
							'Fallo en la petición para cargar los temas',
							error
						);
					});
			}
		},
	},
});
