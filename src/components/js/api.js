import axios from 'axios';

const BASE_URL = 'http://localhost/WikiKahoot/backend';
// * Llamadas al backend

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

export const anyadirPregunta = (
	FK_Eventos,
	Pregunta,
	Respuesta1,
	Respuesta2,
	Respuesta3,
	Respuesta4,
	Correcta,
	Tiempo,
	Imagen,
	Fecha
) => {
	return axios({
		method: 'post',
		url: `${BASE_URL}/pregunta`,
		data: {
			FK_Eventos,
			Pregunta,
			Respuesta1,
			Respuesta2,
			Respuesta3,
			Respuesta4,
			Correcta,
			Imagen,
			Tiempo,
			Fecha,
		},
	});
};

export const getEventoById = eventID => {
	return axios.get(`${BASE_URL}/evento?codEvento=${eventID}`);
};

export const getPreguntas = codigoEvento => {
	return axios.get(`${BASE_URL}/pregunta?codEvento=${codigoEvento}`);
};

export const getEventoByTwoEntries = (str, str2, id, id2) => {
	return axios.get(
		`${BASE_URL}/evento?str=${str}?id=${id}?str2=${str2}?id2=${id2}`
	);
};

export const getEventoByThreeEntries = (str, str2, id, id2) => {
	return axios.get(
		`${BASE_URL}/evento?str=${str}?id=${id}?str2=${str2}?id2=${id2}`
	);
};

export const getEventoByFourEntries = (id, id2, id3, id4) => {
	return axios.get(
		`${BASE_URL}/evento?id1=${id}?id2=${id2}?id3=${id3}?id4=${id4}`
	);
};
