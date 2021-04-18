import xlsx from 'json-as-xlsx';

const settings = {
  sheetName: 'FirstSheet',
  fileName: 'MySpreadsheet',
  extraLength: 3,
  writeOptions: {},
};

const download = true;

export function downloadAsExcel(columns, data) {
  xlsx(columns, data, settings, download);
}
