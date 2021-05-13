// Llamadas al backend
import axios from 'axios';

const BASE_URL = 'http://localhost/WikiKahoot/backend';

export const getEtapas = () => {
	return axios.get(`${BASE_URL}/etapas`);
};

export const getNiveles = () => {
	return axios.get(`${BASE_URL}/nivel`);
};

export const getAreas = () => {
	return axios.get(`${BASE_URL}/area`);
};
