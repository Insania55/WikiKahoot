import json2xlsx from 'json2xlsx';

let columns = [
  {label: 'Numero', value: 'numero'},
 { label: 'Esto', value: 'mas',}
 { label: 'Value', value: 'cosa',}
 { label: 'Funciona', value: 'algo',}
 { label: 'O qué', value: row => }
]

const data = [
  {
    numero: 0,
    algo: 'Traducciones',
    mas: 'De',
    cosa: 'History',
    numero: 2,
  },
  {
    numero: 0,
    algo: 'Traducciones',
    mas: 'De',
    cosa: 'History',
    numero: 2,
  },
  {
    numero: 0,
    algo: 'Traducciones',
    mas: 'De',
    cosa: 'History',
    numero: 2,
  },
];

export function downloadAsExcel() {
  var xls = json2xlsx(data);

  fs.writeFileSync(filename, xls, 'binary', (err) => {
    if (err) {
      console.log('writeFileSync :', err);
    }
    console.log(filename + ' file is saved!');
  });
}
// const EXCEL_TYPE =
//   'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';

// function saveAsExcel(buffer, filename) {
//   const data = new Blob([buffer], { type: EXCEL_TYPE });
//   saveAs(data, filename + '_export_' + new Date().getTime() + '.xlsx');
// }

// export function downloadAsExcel() {
//   const worksheet = XLSX.utils.json_to_sheet(data);

//   let fileReader = new FileReader();
//   fileReader.readAsBinaryString(selectedFile);
//   fileReader.onload = event => {
//     let data = event.target.result;
//   }
//   const workbook = {
//     Sheets: {
//       data: worksheet,
//     },
//     SheetNames: ['data'],
//   };
//   const excelBuffer = XLSX.write(workbook, {
//     bookType: 'xlsx',
//     type: 'array',
//   });
//   console.log(excelBuffer);
//   saveAsExcel(excelBuffer, 'archivoOffice');
// }
