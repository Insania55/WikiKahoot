<template>
  <div class="wiki-eventos">
    <!-- //TODO: Trasladar filtros y datagrid a componente -->
    <div class="filter-search-container">
      <div class="filter-search-form">
        <button class="filter-search-button">
          <i class="fas fa-search"></i>
        </button>
        <!-- //TODO: Necesita un mejor placeholder. Quizá un subtítulo? -->
        <input
          class="filter-searching"
          type="search"
          placeholder="Escribe para buscar"
        />
        <div
          class="open-filters"
          :class="{ 'filter-dropdown': filtersDropdown }"
          @click="openFiltersDropdown"
        >
          <i class="fas fa-cogs"></i>
        </div>
      </div>
    </div>

    <!-- Tabla principal de eventos -->
    <h2>Lista de eventos</h2>
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

    <transition name="fade">
      <div class="modal" v-if="filtersDropdown">
        <h1>Filtros</h1>
        <span>Contenido del modal</span>
      </div>
    </transition>
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
      !this.filtersDropdown;
    },
  },
};
</script>

<style lang="scss">
.wiki-eventos {
  .filter-search-container {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;

    .filter-dropdown {
      background: salmon;
    }
  }

  $table-header: #1976d2;
  $table-header-border: #1565c0;
  $table-border: #d9d9d9;
  $row-bg: #f4f2f1;

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
