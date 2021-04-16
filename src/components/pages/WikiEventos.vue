<template>
  <div class="wiki-eventos">
    <!-- //TODO: Trasladar filtros y datagrid a componente -->
    <div class="filter-search-container">
      <div
        class="filter-search-form"
        :class="{ 'filter-dropdown': filtersDropdown }"
      >
        <div>
          <button class="filter-search-button">
            <i class="fas fa-search"></i>
          </button>
          <!-- //TODO: Necesita un mejor placeholder. Quizá un subtítulo? -->
          <input
            class="filter-search-input"
            type="search"
            placeholder="Escribe para buscar"
          />
          <div
            class="filter-search-options"
            :class="{ 'filter-dropdown': filtersDropdown }"
            @click="openFiltersDropdown"
          >
            <div>
              <i class="fas fa-cogs"></i>
            </div>
          </div>

          <!-- // * Desplegable de filtros -->
          <div class="filter-options-container" v-if="filtersDropdown">
            <!-- //TODO: Eso se podría cambiar a un v-for -->
            <div class="filter-option">
              <label for="area">Área:</label>
              <input
                type="text"
                name="area"
                placeholder="Área temática general"
              />
            </div>
            <div class="filter-option">
              <label for="etapa">Etapa:</label>
              <input
                type="text"
                name="etapa"
                placeholder="Etapa educativa, si procede"
              />
            </div>
            <div class="filter-option">
              <label for="nivel">Nivel:</label>
              <input
                type="text"
                name="nivel"
                placeholder="Nivel de complejidad"
              />
            </div>
            <div class="filter-option">
              <label for="tema">Tema:</label>
              <input
                type="text"
                name="tema"
                placeholder="Tema concreto de la pregunta"
              />
            </div>
            <button class="filter-option-button">Buscar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla principal de eventos -->
    <h2>Resultados de la búsqueda</h2>
    <div class="table-container">
      <div class="flex-table header">
        <div class="flex-row">
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
        :id="'row' + index"
        :key="index"
      >
        <div class="flex-row first"><input type="checkbox" /></div>
        <div class="flex-row">{{ capitalize(evento.area) }}</div>
        <div class="flex-row">{{ capitalize(evento.etapa) }}</div>
        <div class="flex-row">{{ capitalize(evento.nivel) }}</div>
        <div class="flex-row">{{ capitalize(evento.tema) }}</div>
        <div class="flex-row">{{ evento.codigo }}</div>
      </div>
    </div>
    <button class="datagrid-button" @click="descargarExcel">
      Descargar selección
    </button>
  </div>
</template>

<script>
import Evento from '../Evento.vue';
import Preguntas from '../Preguntas.vue';
import { downloadAsExcel } from './js/jsonToExcel.js';

export default {
  name: 'WikiEventos',
  data() {
    return {
      camposHeader: ['Area', 'Etapa', 'Nivel', 'Tema', 'Codigo'],
      eventos: [],
      filtersDropdown: false,
      //TODO: Esto habrá que obtenerlo dependiendo de los datos que se seleccionen en la tabla
      dataToDownload: [
        {
          numero: 1,
          algo: 'Traducciones',
          mas: 'De',
          cosa: 'History',
          numerico: 2,
        },
        {
          numero: 1,
          algo: 'Traducciones',
          mas: 'De',
          cosa: 'History',
          numerico: 2,
        },
        {
          numero: 1,
          algo: 'Traducciones',
          mas: 'De',
          cosa: 'History',
          numerico: 2,
        },
      ],

      bddEventos: [
        {
          codigo: 0,
          area: 'anime',
          etapa: 'none',
          nivel: 'begginer',
          tema: 'shonen',
          fecha: new Date().toLocaleString,
          revisado: false,
        },
        {
          codigo: 1,
          area: 'anime',
          etapa: 'none',
          nivel: 'advanced',
          tema: 'misterio',
          fecha: new Date().toLocaleString,
          revisado: false,
        },
      ],
    };
  },
  components: {
    Evento,
    Preguntas,
  },
  methods: {
    crearEvento() {},
    descargarExcel() {
      downloadAsExcel(this.dataToDownload);
    },

    seleccionarTodos() {
      let checkboxes = document.querySelectorAll('input[type=checkbox');
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
    capitalize(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    openFiltersDropdown() {
      this.filtersDropdown = !this.filtersDropdown;
    },
  },
};
</script>

<style lang="scss">
.wiki-eventos {
  $table-header: #1976d2;
  $table-header-border: #1565c0;
  $table-border: #d9d9d9;
  $row-bg: #f4f2f1;

  margin: 0 1.5rem;

  .filter-search-container {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-bottom: 1.2rem;

    .filter-search-form {
      position: relative;
      width: 350px;
      min-height: 32px;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
      background: lightsteelblue;
      border-radius: 8px;
      transition: all 0.3s ease;

      .filter-search-button {
        position: absolute;
        top: 5px;
        left: 9px;
        height: 18px;
        width: 20px;
        padding: 0;
        margin: 0;
        border: none;
        background: none;
        outline: none !important;
        cursor: pointer;
      }

      .filter-search-input {
        position: absolute;
        top: 5px;
        left: 31px;
        font-size: 15px;
        background: none;
        color: black;
        width: 92%;
        height: 20px;
        border: none;
        appearance: none;
        font-weight: 700;
      }

      .filter-search-options {
        position: absolute;
        text-align: right;
        top: 5px;
        right: 9px;
      }
    }

    .filter-dropdown {
      width: 100%;
    }

    .filter-options-container {
      flex-direction: row;
      flex-wrap: wrap;
      margin: 37px 9px 9px;
      justify-content: flex-start;
      width: 98%;

      .filter-option {
        padding: 1rem;
      }
    }
  }

  .table-container {
    display: block;
    margin: 2em auto;
    width: 90%;
    max-width: 600px;
  }

  .flex-table {
    display: flex;
    flex-flow: row nowrap;
    border-left: solid 1px $table-border;
    transition: 0.5s;

    &.header {
      background: limegreen;

      > {
        padding: 1em;
      }
    }

    &:first-of-type {
      border-top: solid 1px $table-header-border;
      border-left: solid 1px $table-header-border;
    }
    &:first-of-type .flex-row {
      background: $table-header;
      color: white;
      border-color: $table-header-border;

      // * Para centrar el checkbox
      display: flex;
      justify-content: center;
    }
    &.row:nth-child(odd) .flex-row {
      background: $row-bg;
    }
    &:hover {
      background: #f5f5f5;
      transition: 500ms;
    }
  }

  .flex-row {
    width: calc(100% / 6);
    text-align: center;
    padding: 0.5em 0.5em;
    border-right: solid 1px $table-border;
    border-bottom: solid 1px $table-border;
  }

  // ? Para rows anidados. No se utiliza, pero puede ser útil
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
  //     border-bottom: solid 1px $table-border;
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
        border-bottom: solid 1px $table-border;
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
        border-bottom: solid 1px $table-border;
      }
    }

    .column {
      width: 100%;
      .flex-row {
        border-bottom: solid 1px $table-border;
      }
    }

    .flex-cell {
      width: 100%; //1px = border right
    }
  }
  .evento {
    color: seagreen;
  }

  // .flex-cell {
  //   width: calc(100% / 3); //1px = border right
  //   text-align: center;
  //   padding: 0.5em 0.5em;
  //   border-right: solid 1px $table-border;
  //   //flex: 1 1 33.3%;
  //   &:last-child {
  //     // border-right: 0;
  //   }
}

@media all and (max-width: 767px) {
  // ? Esto no sirve pero queda guay, se podría usar?
  // .flex-row {
  //   width: auto; //1px = border right

  //   &.first {
  //     width: 100%;
  //   }
  // }

  .column {
    width: 100%;
  }
}
</style>
