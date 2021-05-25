<template>
  <div class="app-paginated-table">
    <h2 class="table-title">{{ title }}</h2>
    <div v-if="selectCheckbox" class="seleccionar-todos-container">
      <span class="seleccionar-todos-txt">Seleccionar fila</span>
      <i class="fas fa-arrow-down"></i>
    </div>
    <div class="table-container">
      <div class="flex-table header">
        <div v-if="selectCheckbox" class="flex-row first">
          <input
            ref="checkboxManager"
            type="checkbox"
            @click="selectAllCheckbox()"
          />
        </div>
        <div
          class="flex-row"
          :class="clasesHeader[index]"
          v-for="(header, index) in headerFields"
          :key="index"
        >
          {{ header }}
        </div>
      </div>
      <transition-group name="fade">
        <div
          class="flex-table row"
          v-for="(evento, index) in paginatedData"
          :key="index"
          :id="'row' + evento.id"
        >
          <div v-if="selectCheckbox" class="flex-row first">
            <input type="checkbox" />
          </div>
          <div class="flex-row enunciado">{{ evento.enunciado }}</div>
          <div class="flex-row r1">{{ evento.respuesta1 }}</div>
          <div class="flex-row r2">{{ evento.respuesta2 }}</div>
          <div class="flex-row r3">{{ evento.respuesta3 }}</div>
          <div class="flex-row r4">{{ evento.respuesta4 }}</div>
          <div class="flex-row respuesta-correcta">
            {{ evento.respuestaCorrecta }}
          </div>
          <div class="flex-row tiempo-limite">{{ evento.timeLimit }}</div>
          <div class="flex-row img-link">
            <a :href="evento.imgLink" target="_blank"
              ><i v-if="evento.imgLink" class="far fa-image"></i
            ></a>
          </div>
        </div>
      </transition-group>
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

    <div v-if="selectCheckbox && !borrable" class="button-container">
      <!-- //TODO: Notificar al usuario de que se ha añadido el elemento a la descarga -->
      <AppButton @click="anyadirDescarga" normal
        >Añadir a la descarga</AppButton
      >
      <AppButton
        @click="descargarExcel"
        :disabled="downloadData.length === 0"
        :green="downloadData.length !== 0"
        >Descargar selección</AppButton
      >
    </div>
    <div v-if="selectCheckbox && !borrable" class="button-container">
      <AppButton
        href="/descargarPreguntas/consultarSeleccion"
        :disabled="downloadData.length === 0"
        :normal="downloadData.length !== 0"
        >Editar descarga actual</AppButton
      >
    </div>
    <div v-if="borrable" class="button-container">
      <AppButton href="/descargarPreguntas" normal>Volver atrás</AppButton>
      <AppButton @click="borrarSeleccion" normal>Borrar selección</AppButton>
    </div>
  </div>
</template>

<script>
import { downloadAsExcel } from "./js/jsonToExcel.js";
import AppButton from "./AppButton.vue";

export default {
  name: "paginated-table",
  components: {
    AppButton,
  },
  props: {
    data: {
      type: Array,
      required: true,
    },
    title: {
      type: String,
      required: false,
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
    borrable: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dataToDownload: [],
      // TODO: Esto habría que cambiarlo a prop o refactorizarlo
      clasesHeader: [
        "enunciado",
        "r1",
        "r2",
        "r3",
        "r4",
        "respuesta-correcta",
        "tiempo-limite",
        "img-link",
      ],
      spreadsheetColumns: [
        { label: "Question", value: "enunciado" },
        { label: "Answer 1 - max 75 characters", value: "respuesta1" },
        { label: "Answer 2 - max 75 characters", value: "respuesta2" },
        { label: "Answer 3 - max 75 characters", value: "respuesta3" },
        { label: "Answer 4 - max 75 characters", value: "respuesta4" },
        {
          label: "Time limit (sec) – 5, 10, 20, 30, 60, 90, 120, or 240 secs",
          value: "timeLimit",
        },
        {
          label: "Correct answer(s) - choose at least one",
          value: "respuestaCorrecta",
        },
      ],
    };
  },
  computed: {
    downloadData() {
      return this.$store.state.downloadData;
    },
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
      timeLimit,
      imgLink,
      id
    ) {
      this.dataToDownload.push({
        enunciado,
        respuesta1,
        respuesta2,
        respuesta3,
        respuesta4,
        respuestaCorrecta,
        timeLimit,
        imgLink,
        id,
      });
    },
    //TODO: Que muestre un mensaje confirmando que se ha añadido a la descarga (o no)
    anyadirDescarga() {
      document.querySelectorAll(".flex-table.row").forEach((fila) => {
        // ? Si el checkbox de dicha fila está en estado 'checked' significa que lo han seleccionado para descargar
        if (fila.firstChild.firstChild.checked === true) {
          this.anyadirEvento(
            fila.children[1].textContent.trim(),
            fila.children[2].textContent.trim(),
            fila.children[3].textContent.trim(),
            fila.children[4].textContent.trim(),
            fila.children[5].textContent.trim(),
            fila.children[6].textContent.trim(),
            fila.children[7].textContent,
            fila.children[8].firstChild.href,
            this.$store.state.downloadItemId
          );
        }
        this.$store.commit("newId");
      });
      // ? Controlamos los datos descargados con Vuex para almacenarlos en el estado de la app
      this.$store.commit("setDownloadedData", this.dataToDownload);
      this.selectAllCheckbox(false);
    },

    descargarExcel() {
      if (this.downloadData.length !== 0) {
        downloadAsExcel(this.spreadsheetColumns, this.downloadData);
        this.selectAllCheckbox(false);
        this.dataToDownload = [];
        this.$store.commit("setDownloadedData", []);
      }
    },
    selectAllCheckbox(state = true) {
      // ? Si se pasa true, se seleccionan todos, de lo contrario se desmarcan
      let checker = this.$refs.checkboxManager;
      let checkboxes = document.querySelectorAll(
        "input[type=checkbox]:first-child"
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
    borrarSeleccion() {
      document.querySelectorAll(".flex-table.row").forEach((fila) => {
        // ? Si el checkbox de dicha fila está en estado 'checked' significa que lo han seleccionado para descargar
        if (fila.firstChild.firstChild.checked === true) {
          // ? Conseguimos el número del id de dicha fila  (Teniendo en cuenta que las id son row1, row4, row123...)
          let id = fila.id.split("w")[1];
          this.$store.dispatch("deleteItem", id);
        }
      });
      this.selectAllCheckbox(false);
    },
    onClickFirstPage() {
      this.$emit("page-changed", 1);
      this.selectAllCheckbox(false);
    },
    onClickLastPage() {
      this.$emit("page-changed", this.totalPages);
      this.selectAllCheckbox(false);
    },
    onClickNextPage() {
      this.$emit("page-changed", this.currentPage + 1);
      this.selectAllCheckbox(false);
    },
    onClickPreviousPage() {
      this.$emit("page-changed", this.currentPage - 1);
      this.selectAllCheckbox(false);
    },
    onClickPage(page) {
      this.$emit("page-changed", page);
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
  margin: 1em 3em 2em 3em;
  max-width: 100vw;
  font-size: 0.8rem;
  // width: 100%;
}

.seleccionar-todos-container {
  width: 100px;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  text-align: center;
  margin-left: 0.45rem;
  font-weight: bold;
  font-family: "Montserrat";
  font-size: 0.9em;
  // justify-content: center;
}

.flex-table {
  display: flex;
  flex-flow: row nowrap;
  border-left: solid 1px $--color-table-border;
  transition: 0.5s;

  &.header {
    .flex-row {
      display: flex;
      justify-content: center;
      align-items: center;

      max-height: max-content;
      font-weight: bold;
      text-align: center;
      color: white;
      background: $--color-table-header;
      border-color: $--color-table-header-border;
    }
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
      display: grid;
      place-items: center;
      text-align: center;
      padding: 0.5rem;
      background: #fff;
      // white-space: nowrap;
      // overflow: hidden;
      // text-overflow: ellipsis;
      // max-height: 4em;
      .img-link {
        font-size: 1.1rem;
      }
    }
  }
}

// En total tiene que sumar un 100% o cosas raras empiezan a suceder
.enunciado {
  width: 35%;
}

.r1,
.r2,
.r3,
.r4 {
  width: 12.5%;
}

.first {
  width: 2%;
}

.img-link {
  width: 5%;
}

.respuesta-correcta,
.tiempo-limite {
  width: 4%;
}

.flex-row {
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
      &[disabled="disabled"] {
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.button-container {
  display: flex;
  justify-content: center;
  margin-bottom: 2rem;
  margin-top: 1.8rem;

  :first-child {
    margin-right: 0.5em;
  }
}
</style>
