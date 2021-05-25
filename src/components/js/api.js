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

export const createEvento = (idEtapa, idNivel, idArea, idTema, fecha) => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/evento`,
		data: {
			FK_IdEtapa: idEtapa,
			FK_IdNivel: idNivel,
			FK_IdArea: idArea,
			FK_IdTema: idTema,
			Fecha: fecha,
		},
	});
};

export const getEventoByTwoEntries = (str, str2, id, id2) => {
	return axios({
		method: 'get',
		url: `${BASE_URL}/evento?str=${str}?id=${id}?str2=${str2}?id2=${id2}`,
	});
};
