import xlsx from 'json-as-xlsx';

const columns = [
  { label: 'Numero', value: 'numero' },
  { label: 'Esto', value: 'mas' },
  { label: 'Value', value: 'cosa' },
  { label: 'Funciona', value: 'algo' },
  { label: 'This shit', value: (row) => row.numerico + row.numero },
];

const settings = {
  sheetName: 'FirstSheet',
  fileName: 'MySpreadsheet',
  extraLength: 3,
  writeOptions: {},
};

const download = true;

export function downloadAsExcel(data) {
  xlsx(columns, data, settings, download);
}
