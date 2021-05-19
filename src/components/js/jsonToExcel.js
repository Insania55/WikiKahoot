import xlsx from 'json-as-xlsx';

const settings = {
	sheetName: 'wiki-kahoot',
	fileName: 'hojaCalculoKahoot',
	extraLength: 3,
	writeOptions: {},
};

const download = true;

export function downloadAsExcel(columns, data) {
	// ? Damos un nombre distintivo  a cada ficha
	settings.fileName += `${+new Date()}`;
	xlsx(columns, data, settings, download);
}
