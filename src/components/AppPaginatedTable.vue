<template>
  <div class="app-paginator">
    <h2 class="table-title">Resultados de la búsqueda</h2>
    <div class="table-container">
      <div class="flex-table header">
        <div v-if="selectCheckbox" class="flex-row">
          <span>Seleccionar todos</span>
          <input
            ref="checkboxManager"
            type="checkbox"
            @click="selectAllCheckbox(true)"
          />
        </div>
        <div
          class="flex-row"
          v-for="(header, index) in headerFields"
          :key="index"
        >
          {{ header }}
        </div>
      </div>

      <div
        class="flex-table row"
        v-for="(evento, index) in paginatedData"
        :key="index"
      >
        <div v-if="selectCheckbox" class="flex-row first">
          <input type="checkbox" />
        </div>
        <div class="flex-row">{{ evento.enunciado }}</div>
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
      <ul class="pagination" v-if="data.length > 5 || currentPage > 1">
        <li class="pagination-item">
          <button @click="onClickFirstPage" :disabled="isInFirstPage">
            <i class="fas fa-chevron-left"></i>
            <i class="fas fa-chevron-left"></i>
          </button>
        </li>
        <li class="pagination-item">
          <button @click="onClickFirstPage" :disabled="isInFirstPage">
            <i class="fas fa-chevron-left"></i>
          </button>
        </li>

        <li class="pagination-item" v-for="(page, index) in pages" :key="index">
          <button
            @click="onClickPage(page.number)"
            :class="{ active: isPageActive(page.number) }"
            :disabled="page.isDisabled"
          >
            {{ page.number }}
          </button>
        </li>
        <li class="pagination-item">
          <button @click="onClickNextPage" :disabled="isInLastPage">
            <i class="fas fa-chevron-right"></i>
          </button>
        </li>
        <li class="pagination-item">
          <button @click="onClickLastPage" :disabled="isInLastPage">
            <i class="fas fa-chevron-right"></i>
            <i class="fas fa-chevron-right"></i>
          </button>
        </li>
      </ul>
    </div>
    <div class="button-container">
      <button @click="anyadirDescarga" class="add-button">
        Añadir a la descarga
      </button>
      <button
        :disabled="dataToDownload.length === 0"
        @click="descargarExcel"
        class="download-button"
      >
        Descargar selección
      </button>
    </div>
  </div>
</template>

<script>
import { downloadAsExcel } from './js/jsonToExcel.js';

export default {
  name: 'paginated-table',
  props: {
    data: {
      type: Array,
      required: true,
    },
    headerFields: {
      type: Array,
      required: true,
    },
    maxVisibleButtons: {
      type: Number,
      required: false,
      default: 3,
    },
    totalPages: {
      type: Number,
      required: true,
    },
    total: {
      type: Number,
      required: true,
    },
    perPage: {
      type: Number,
      required: true,
    },
    currentPage: {
      type: Number,
      required: true,
    },
    selectCheckbox: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dataToDownload: [],
      spreadsheetColumns: [
        { label: 'Question', value: 'enunciado' },
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
    };
  },
  computed: {
    paginatedData() {
      let start = (this.currentPage - 1) * this.perPage;
      let end = start + this.perPage;
      return this.data.slice(start, end);
    },
    startPage() {
      if (this.currentPage === 1) return 1;
      if (this.currentPage === this.totalPages)
        return (
          this.totalPages -
          this.maxVisibleButtons +
          (this.maxVisibleButtons - 1)
        );
      return this.currentPage - 1;
    },
    endPage() {
      return Math.min(
        this.startPage + this.maxVisibleButtons - 1,
        this.totalPages
      );
    },
    pages() {
      let range = [];
      for (let index = this.startPage; index <= this.endPage; index++) {
        range.push({
          number: index,
          isDisabled: index === this.currentPage,
        });
      }
      return range;
    },
    isInFirstPage() {
      return this.currentPage === 1;
    },
    isInLastPage() {
      return this.currentPage === this.totalPages;
    },
  },
  methods: {
    anyadirEvento(
      enunciado,
      respuesta1,
      respuesta2,
      respuesta3,
      respuesta4,
      respuestaCorrecta,
      timeLimit
    ) {
      this.dataToDownload.push({
        enunciado,
        respuesta1,
        respuesta2,
        respuesta3,
        respuesta4,
        respuestaCorrecta,
        timeLimit,
      });
    },
    //TODO: Que muestre un mensaje confirmando que se ha añadido a la descarga (o no)
    anyadirDescarga() {
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
    },
    descargarExcel() {
      if (this.dataToDownload.length !== 0) {
        downloadAsExcel(this.spreadsheetColumns, this.dataToDownload);
        this.selectAllCheckbox(false);
        this.dataToDownload = [];
      }
    },
    selectAllCheckbox(state) {
      // ? Si se pasa true, se seleccionan todos, de lo contrario se desmarcan
      let checker = this.$refs.checkboxManager;
      let checkboxes = document.querySelectorAll(
        'input[type=checkbox]:first-child'
      );

      if (!state) {
        checker.checked = false;
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
        return;
      }
      if (state && checker.checked) {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = true;
        });
      } else {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
      }
    },
    onClickFirstPage() {
      this.$emit('page-changed', 1);
      this.selectAllCheckbox(false);
    },
    onClickLastPage() {
      this.$emit('page-changed', this.totalPages);
      this.selectAllCheckbox(false);
    },
    onClickNextPage() {
      this.$emit('page-changed', this.currentPage + 1);
      this.selectAllCheckbox(false);
    },
    onClickPreviousPage() {
      this.$emit('page-changed', this.currentPage - 1);
      this.selectAllCheckbox(false);
    },
    onClickPage(page) {
      this.$emit('page-changed', page);
      this.selectAllCheckbox(false);
    },
    isPageActive(page) {
      return this.currentPage === page;
    },
  },
};
</script>

<style lang="scss">
$--color-table-header: #1976d2;
$--color-table-header-border: #1565c0;
$--color-table-border: #d9d9d9;
$--color-row-bg: #f4f2f1;

.hidden {
  display: none;
}

.table-title {
  text-align: center;
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
    }
  }
}

.button-container {
  display: flex;
  justify-content: center;
  margin-bottom: 2em;

  button {
    display: inline-block;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: 'Montserrat', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-weight: bold;
    text-align: center;
    min-height: 42px;
    min-width: 7.5rem;
    padding: 0px 16px 4px;
    position: relative;
    line-height: 0.9rem;
    background: rgb(242, 242, 242) none repeat scroll 0% 0%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px -4px inset;
    margin-right: 1em;

    &:hover:enabled {
      min-height: 40px;
      margin-top: 2px;
      background-color: rgb(223, 223, 223);
      box-shadow: rgba(0, 0, 0, 0.25) 0px -2px inset;
      padding-bottom: 2px;
    }

    &:last-child {
      background: rgb(38, 137, 12) none repeat scroll 0% 0%;
      color: white;

      &:hover:enabled {
        background-color: rgb(35, 126, 11);
      }

      &[disabled] {
        cursor: not-allowed;
        background-color: rgb(204, 204, 204);
        color: white;
        box-shadow: none;
        padding-bottom: 0;

        &:hover {
          background-color: rgb(150, 150, 150);
        }
      }
    }
  }
}

.flex-row {
  text-align: center;

  // ? Control de widths. Esto está sucio pero de momento es lo que hay
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

.pagination {
  display: flex;
  justify-content: center;
  margin: 1em 0 0 0;
  list-style-type: none;
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

.pagination-item {
  button {
    padding: 0.25rem 0.5rem;
    font-size: 1.1rem;
    border: none;
    background: none;

    &:hover {
      cursor: pointer;
      background-color: silver;
      &[disabled='disabled'] {
        color: silver;
        cursor: default;

        &:hover {
          cursor: default;
          background-color: transparent;

          &.active {
            color: red;
          }
        }
      }
    }
  }
}
</style>
