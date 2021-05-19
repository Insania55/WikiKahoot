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
