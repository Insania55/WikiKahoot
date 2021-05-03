<template>
  <div class="app-paginator">
    <h2 class="table-title">Resultados de la búsqueda</h2>
    <div class="table-container">
      <div class="flex-table header">
        <div class="flex-row">
          <span>Seleccionar todos</span>
          <input type="checkbox" @click="selectAllCheckbox" />
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
      <div class="button-container">
        <button @click="descargarExcel" class="download-button">
          Descargar selección
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { downloadAsExcel } from './js/jsonToExcel.js';

export default {
  name: 'app-paginator',
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
      for (let index = 0; index < this.endPage; index++) {
        range.push({
          number: i,
          isDisabled: i === this.currentPage,
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
    onClickFirstPage() {
      this.$emit('page-changed', 1);
    },
    onClickPreviousPage() {
      this.$emit('page-changed', this.currentPage - 1);
    },
    onClickPage(page) {
      this.$emit('page-changed', page);
    },
    onClickLastPage() {
      this.$emit('page-changed', this.totalPages);
    },
    isPageActive(page) {
      return this.currentPage == page;
    },
    onPageChange(page) {
      this.currentPage = page;
    },
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
    selectAllCheckbox() {
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
  },
  data() {
    return {
      dataToDownload: [],
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
    };
  },
};
</script>

<style></style>
