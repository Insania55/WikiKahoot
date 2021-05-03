<template>
  <div class="wiki-eventos">
    <EventFilters
      :filters-dropdown="filtersDropdown"
      @cerrar-filtros="filtersDropdown = !filtersDropdown"
    >
    </EventFilters>
    <AppPaginatedTable
      :data="bddEventos"
      :headerFields="camposHeader"
      :totalPages="3"
      :total="5"
      :perPage="5"
      :currentPage="1"
    >
    </AppPaginatedTable>
    <!-- Tabla principal de eventos -->
    <!-- <h2 class="table-title">Resultados de la búsqueda</h2>
    <div class="table-container">
      <div class="flex-table header">
        <div class="flex-row">
          <span>Seleccionar todos</span>

          <input type="checkbox" @click="seleccionarTodos" />
        </div>
        <div
          class="flex-row"
          v-for="(header, index) in camposHeader"
          :key="index"
        >
          <h3>{{ header }}</h3>
        </div>
      </div>
      <div
        class="flex-table row"
        v-for="(evento, index) in bddEventos"
        :key="index"
      >
        <div class="flex-row first"><input type="checkbox" /></div>
        <div class="flex-row">{{ evento.pregunta }}</div>
        <div class="flex-row">{{ evento.respuesta1 }}</div>
        <div class="flex-row">{{ evento.respuesta2 }}</div>
        <div class="flex-row">{{ evento.respuesta3 }}</div>
        <div class="flex-row">{{ evento.respuesta4 }}</div>
        <div class="flex-row">{{ evento.respuestaCorrecta }}</div>
        <div class="flex-row">{{ evento.timeLimit }}</div>
        <div class="flex-row">
          <a :href="evento.imgLink" target="_blank">{{ evento.imgLink }}</a>
        </div>
      </div>
    </div>

    <div class="button-container">
      <button @click="descargarExcel" class="download-button">
        Descargar selección
      </button>
    </div> -->
  </div>
</template>

<script>
import Evento from '../Evento.vue';
// import Preguntas from '../Preguntas.vue';
import EventFilters from '../EventFilters.vue';
import AppPaginatedTable from '../AppPaginatedTable.vue';
import { downloadAsExcel } from '../js/jsonToExcel.js';

export default {
  name: 'WikiEventos',
  data() {
    return {
      camposHeader: [
        'Pregunta',
        'Respuesta 1',
        'Respuesta 2',
        'Respuesta 3',
        'Respuesta 4',
        'Respuesta correcta',
        'Tiempo límite',
        'Enlace a imagen',
      ],
      filtersDropdown: false,
      spreadsheetColumns: [
        { label: 'Question', value: 'pregunta' },
        { label: 'Answer 1 - max 75 characters', value: 'respuesta1' },
        { label: 'Answer 2 - max 75 characters', value: 'respuesta2' },
        { label: 'Answer 3 - max 75 characters', value: 'respuesta3' },
        { label: 'Answer 4 - max 75 characters', value: 'respuesta4' },
        {
          label: 'Time limit (sec) – 5, 10, 20, 30, 60, 90, 120, or 240 secs',
          value: 'timeLimit',
        },
        {
          label: 'Correct answer(s) - choose at least one',
          value: 'respuestaCorrecta',
        },
      ],
      //TODO: Esto habrá que obtenerlo dependiendo de los datos que se seleccionen en la tabla
      dataToDownload: [
        // * Objeto de testeo
        {
          pregunta: 'Esta sería la pregunta',
          respuesta1: 'Respuesta 1',
          respuesta2: 'Respuesta 2',
          respuesta3: 'Respuesta 3',
          respuesta4: 'Respuesta 4',
          timeLimit: 60,
          respuestaCorrecta: '2',
        },
      ],
      bddEventos: [
        {
          pregunta:
            '¿Qué propiedad de CSS es la más apropiada para poner en negrita la letra?',
          respuesta1: 'font-weight',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: ':D',
          timeLimit: 60,
          respuestaCorrecta: 1,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
          // revisado: false,
          // fecha: new Date().toLocaleString()
        },
        {
          pregunta: '¿Quién creó Mortadelo y Filemón?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Francisco Ibáñez',
          respuesta4: ':D',
          timeLimit: 120,
          respuestaCorrecta: 2,
        },
        {
          pregunta: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          pregunta: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          pregunta: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          pregunta: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
      ],
    };
  },
  components: {
    Evento,
    // Preguntas,
    EventFilters,
    AppPaginatedTable,
  },
  methods: {
    // TODO: Crear botón para añadir a la lista de descarga, aparte del botón de descargar
    anyadirEvento(
      pregunta,
      respuesta1,
      respuesta2,
      respuesta3,
      respuesta4,
      respuestaCorrecta,
      timeLimit
    ) {
      this.dataToDownload.push({
        pregunta,
        respuesta1,
        respuesta2,
        respuesta3,
        respuesta4,
        respuestaCorrecta,
        timeLimit,
      });
    },
    paginatedData() {
      let start = this.currentPage;
      return this.bddEventos.slice();
    },
    descargarExcel() {
      document.querySelectorAll('.flex-table.row').forEach((fila) => {
        // ? Si el checkbox de dicha fila está en estado 'checked' significa que lo han seleccionado para descargar
        if (fila.firstChild.firstChild.checked === true) {
          this.anyadirEvento(
            fila.children[1].textContent,
            fila.children[2].textContent,
            fila.children[3].textContent,
            fila.children[4].textContent,
            fila.children[5].textContent,
            fila.children[6].textContent,
            fila.children[7].textContent
          );
        }
      });
      let anyChecked = false;
      document.querySelectorAll('input[type=checkbox]').forEach((checkbox) => {
        if (checkbox.checked === true) anyChecked = true;
      });

      // TODO: Si no hay ninguno seleccionado y se intenta descargar, en vez de no hacer nada, mostrar un mensaje de error
      if (anyChecked === false) return;

      downloadAsExcel(this.spreadsheetColumns, this.dataToDownload);
      this.dataToDownload = [];
    },
    seleccionarTodos() {
      let checkboxes = document.querySelectorAll('input[type=checkbox]');
      let allSelected = checkboxes[0].checked === true;
      if (allSelected) {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = true;
        });
      } else {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
      }
    },
    openFiltersDropdown() {
      this.filtersDropdown = !this.filtersDropdown;
    },
  },
};
</script>

<style lang="scss">
.wiki-eventos {
  $--color-table-header: #1976d2;
  $--color-table-header-border: #1565c0;
  $--color-table-border: #d9d9d9;
  $--color-row-bg: #f4f2f1;

  .hidden {
    visibility: hidden;
  }

  .table-title {
    text-align: center;
  }

  .paginate-links {
    width: 100%;
    list-style: none;
    text-align: center;
    margin-bottom: 2em;
  }

  .paginate-links li {
    display: inline;
    background-color: #e43a48;
    color: white;
    padding: 0.5rem;
    margin-left: 0.3rem;
    margin-right: 0.3rem;
    cursor: pointer;
    border-radius: 3px;
  }

  .paginate-result {
    width: 100%;
    text-align: center;
    margin-bottom: 1rem;
  }

  .table-container {
    display: block;
    margin: 2em auto;
    width: 100%;
    max-width: 90vw;
  }

  .flex-table {
    display: flex;
    flex-flow: row nowrap;
    border-left: solid 1px $--color-table-border;
    transition: 0.5s;

    &.header {
      background: limegreen;

      > {
        padding: 1em;
      }
    }

    &:first-of-type {
      border-top: solid 1px $--color-table-header-border;
      border-left: solid 1px $--color-table-header-border;
    }
    &:first-of-type .flex-row {
      background: $--color-table-header;
      border-color: $--color-table-header-border;
      color: white;

      // * Para centrar el checkbox
      display: flex;
      justify-content: center;
      flex-flow: column;
    }
    &.row:nth-child(odd) .flex-row {
      background: $--color-row-bg;
    }
    &:hover {
      background: #f5f5f5;
      transition: 500ms;
    }

    &.row {
      .flex-row {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow-x: auto;
        display: grid;
        place-items: center;

        // ? Para el tooltip, de momento no se puede implementar pero puede ser útil
        // position: relative;
        // display: inline-block;
        // border-bottom: 1px dotted black;

        // &:hover > #text {
        //   visibility: visible;
        //   opacity: 1;
        // }

        // &:not(.first) > * {
        //   visibility: hidden;
        //   width: 120px;
        //   background-color: #555;
        //   color: #fff;
        //   text-align: center;
        //   border-radius: 6px;
        //   padding: 5px 0;
        //   position: absolute;
        //   z-index: 1;
        //   bottom: 125%;
        //   left: 50%;
        //   margin-left: -60px;
        //   opacity: 0;
        //   transition: opacity 0.3s;

        //   &::after {
        //     content: '';
        //     position: absolute;
        //     top: 100%;
        //     left: 50%;
        //     margin-left: -5px;
        //     border-width: 5px;
        //     border-style: solid;
        //     border-color: #555 transparent transparent transparent;
        //   }
        // }
      }
    }
  }

  .button-container {
    text-align: center;
  }

  .download-button {
    font-family: 'Fredoka One', cursive;
    display: inline-block;
    border: none;
    padding: 0.5rem;
    background-color: transparent;
    cursor: pointer;
    border-radius: 2px;
    background: dodgerblue;
    margin-bottom: 2em;

    &:active {
      transform: translateY(2px);
      background: rgba(30, 143, 255, 0.9);
    }
  }

  .flex-row {
    text-align: center;

    // ? Esto está sucio pero es lo que hay
    &:first-child,
    &:nth-child(7),
    &:nth-child(8),
    &:nth-child(9) {
      width: 10%;
    }

    &:nth-child(3),
    &:nth-child(4),
    &:nth-child(5),
    &:nth-child(6) {
      width: 15%;
    }
    &:nth-child(2) {
      width: 25%;
    }
    padding: 0.5em;
    border-right: solid 1px $--color-table-border;
    border-bottom: solid 1px $--color-table-border;
  }

  // ? Para rows anidados. No se utiliza, pero puede sernos útil
  // .rowspan {
  //   display: flex;
  //   flex-flow: row wrap;
  //   align-items: flex-start;
  //   justify-content: center;
  // }
  // .column {
  //   display: flex;
  //   flex-flow: column wrap;
  //   width: 75%;
  //   padding: 0;
  //   .flex-row {
  //     display: flex;
  //     flex-flow: row wrap;
  //     width: 100%;
  //     padding: 0;
  //     border: 0;
  //     border-bottom: solid 1px $--color-table-border;
  //     &:hover {
  //       background: #f5f5f5;
  //       transition: 500ms;
  //     }
  //   }
  // }

  @media all and (max-width: 430px) {
    .flex-table {
      .flex-row {
        border-bottom: 0;
      }
      .flex-row:last-of-type {
        border-bottom: solid 1px $--color-table-border;
      }
    }

    .header {
      .flex-row {
        border-bottom: solid 1px;
      }
    }

    .flex-row {
      width: 100%; //1px = border right

      &.first {
        width: 100%;
        border-bottom: solid 1px $--color-table-border;
      }
    }

    .column {
      width: 100%;
      .flex-row {
        border-bottom: solid 1px $--color-table-border;
      }
    }

    .flex-cell {
      width: 100%; //1px = border right
    }
  }

  // .flex-cell {
  //   width: calc(100% / 3); //1px = border right
  //   text-align: center;
  //   padding: 0.5em 0.5em;
  //   border-right: solid 1px $--color-table-border;
  //   //flex: 1 1 33.3%;
  //   &:last-child {
  //     // border-right: 0;
  //   }
}

@media all and (max-width: 767px) {
  .column {
    width: 100%;
  }
}
</style>
