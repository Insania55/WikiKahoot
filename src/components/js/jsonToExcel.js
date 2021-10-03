import xlsx from 'json-as-xlsx';

const settings = {
	fileName: 'hojaCalculoKahoot',
	extraLength: 3,
	writeOptions: {},
};

export function downloadAsExcel(data) {
	// Damos un nombre distintivo  a cada ficha
	settings.fileName += `${+new Date()}`;
	xlsx([data], settings);
}
