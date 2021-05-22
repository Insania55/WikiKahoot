import axios from 'axios';

const BASE_URL = 'http://localhost/WikiKahoot/backend';
// Llamadas al backend

export const getEtapas = () => {
	return axios.get(`${BASE_URL}/etapa`);
};

export const getNiveles = () => {
	return axios.get(`${BASE_URL}/nivel`);
};

export const getAreas = () => {
	return axios.get(`${BASE_URL}/area`);
};

export const getTemas = idArea => {
	return axios.get(`${BASE_URL}/tema?idArea=${idArea}`);
};

export const getEventoById = eventID => {
	return axios.get(`${BASE_URL}/evento?codEvento=${eventID}`);
};

export const createEtapa = nombre => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/etapa`,
		data: nombre,
	});
};

export const createNivel = nombre => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/nivel`,
		data: nombre,
	});
};

export const createArea = nombre => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/area`,
		data: nombre,
	});
};

export const createTema = nombre => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/tema`,
		data: nombre,
	});
};
