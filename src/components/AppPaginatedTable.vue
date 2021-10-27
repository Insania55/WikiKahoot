<template>
  <div class="app-paginated-table">
    <div v-if="selectCheckbox" class="seleccionar-todos-container">
      <span>Seleccionar fila</span>
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
      <!-- <transition-group name="table-fade"> -->
      <!-- // 'id' es el ID del evento en la BDD, lo generamos para identificar el row y poder borrarlo después -->
      <!-- TODO Idear una forma para no tener error de keys repetidas -->
      <div
        class="flex-table row"
        v-for="evento in paginatedData"
        :key="evento.Respuesta1 + Date.now()"
        :id="'row' + evento.id"
      >
        <div v-if="selectCheckbox" class="flex-row first">
          <input type="checkbox" />
        </div>
        <div class="flex-row enunciado">{{ evento.Pregunta }}</div>
        <div class="flex-row r1">{{ evento.Respuesta1 }}</div>
        <div class="flex-row r2">{{ evento.Respuesta2 }}</div>
        <div class="flex-row r3">{{ evento.Respuesta3 }}</div>
        <div class="flex-row r4">{{ evento.Respuesta4 }}</div>
        <div class="flex-row respuesta-correcta">
          {{ evento.Correcta }}
        </div>
        <div class="flex-row tiempo-limite">{{ evento.Tiempo }}</div>
        <div class="flex-row img-link">
          <a :href="evento.Imagen" target="_blank"
            ><i v-if="evento.Imagen" class="far fa-image"></i
          ></a>
        </div>
      </div>
      <!-- </transition-group> -->
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
      <AppButton @click="anyadirDescarga" normal
        >Añadir a la descarga
      </AppButton>
      <AppButton
        @click="descargarExcel"
        :disabled="storedData.length === 0"
        :green="storedData.length !== 0"
        >Descargar selección
        <template #icon><i class="far fa-file-excel"></i></template>
      </AppButton>
    </div>
    <div v-if="selectCheckbox && !borrable" class="button-container">
      <AppButton
        href="/consultar/consultarSeleccion"
        :disabled="storedData.length === 0"
        :normal="storedData.length !== 0"
        >Editar descarga actual</AppButton
      >
    </div>
    <div v-if="borrable" class="button-container">
      <AppButton href="/consultar" normal>Volver atrás</AppButton>
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
      // TODO Cambiarlo a prop o refactorizarlo
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
        { label: "Question", value: "Pregunta" },
        { label: "Answer 1 - max 75 characters", value: "Respuesta1" },
        { label: "Answer 2 - max 75 characters", value: "Respuesta2" },
        { label: "Answer 3 - max 75 characters", value: "Respuesta3" },
        { label: "Answer 4 - max 75 characters", value: "Respuesta4" },
        {
          label: "Time limit (sec) – 5, 10, 20, 30, 60, 90, 120, or 240 secs",
          value: "Tiempo",
        },
        {
          label: "Correct answer(s) - choose at least one",
          value: "Correcta",
        },
      ],
    };
  },
  computed: {
    storedData() {
      return this.$store.state.storedData;
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
  mounted() {
    // Event listener para borrar los checkbox seleccionados en caso de que se quiera
    if (this.selectCheckbox) {
      this.eventHub.$on("reset-checkboxes", () => {
        this.selectAllCheckbox(false);
      });
    }
  },
  beforeDestroy() {
    // Eliminamos el listener antes de destruir el componente
    if (this.selectCheckbox) {
      this.eventHub.$off("reset-checkboxes", this.selectAllCheckbox(false));
    }
  },
  methods: {
    anyadirEvento(
      Pregunta,
      Respuesta1,
      Respuesta2,
      Respuesta3,
      Respuesta4,
      Correcta,
      Tiempo,
      Imagen,
      id
    ) {
      this.dataToDownload.push({
        Pregunta,
        Respuesta1,
        Respuesta2,
        Respuesta3,
        Respuesta4,
        Correcta,
        Tiempo,
        Imagen,
        id,
      });
    },

    async anyadirDescarga() {
      // ? Probablemente todos estos querySelectorAll de la página se harían mejor utilizando $refs
      document.querySelectorAll(".flex-table.row").forEach((fila) => {
        // Si el checkbox de dicha fila está en estado 'checked' significa que lo han seleccionado para descargar el elemento
        if (fila.firstChild.firstChild.checked === true) {
          this.anyadirEvento(
            fila.children[1].textContent.trim(),
            fila.children[2].textContent.trim(),
            fila.children[3].textContent.trim(),
            fila.children[4].textContent.trim(),
            fila.children[5].textContent.trim(),
            fila.children[6].textContent.trim(),
            fila.children[7].textContent,
            // Sin esto, se añaden imágenes apuntando a esa dirección cuando no hay imagen añadida
            fila.children[8].firstChild.href ===
              "http://localhost:8080/consultar"
              ? ""
              : fila.children[8].firstChild.href,
            this.$store.state.downloadItemId
          );
          // Aumentamos un ID para asignar a cada elemento de la descarga un ID diferente
          this.$store.commit("newId");
        }
      });

      // Controlamos con Vuex los datos descargados, almacenándolos en el estado global de la app
      await this.dataToDownload.forEach((element) => {
        this.$store.commit("addToStoredData", element);
      });

      this.selectAllCheckbox(false);
      // TODO Si no hay ninguna columna seleccionada para añadir a la descarga, mostrar el mensaje de error (o no mostrar nada)
      // this.$emit("notify-error", "Nada que añadir a la descarga");
      this.$emit("notify-success", "Preguntas añadidas a la descarga.");
    },

    descargarExcel() {
      if (this.storedData.length !== 0) {
        let spreadsheet = {
          sheet: "Preguntas-WikiKahoot",
          columns: this.spreadsheetColumns,
          content: this.storedData,
        };

        try {
          downloadAsExcel(spreadsheet);
        } catch (error) {
          console.error(error);
          return;
        }

        this.selectAllCheckbox(false);
        this.dataToDownload = [];
        this.$store.commit("setStoredData", []);
      } else {
        this.$emit("notify-error", "Todavía no hay datos para descargar");
      }
    },
    selectAllCheckbox(seleccionarTodos = true) {
      let checker = this.$refs.checkboxManager;
      let checkboxes = document.querySelectorAll(
        "input[type=checkbox]:first-child"
      );

      if (!seleccionarTodos) {
        checker.checked = false;
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
        return;
      }
      if (seleccionarTodos && checker.checked) {
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
        // Si el checkbox de dicha fila está en estado 'checked' significa que lo han seleccionado para descargar
        if (fila.firstChild.firstChild.checked === true) {
          // Conseguimos el número del id de dicha fila (Teniendo en cuenta que las id son row1, row4, row123...)
          let id = fila.id.split("w")[1];
          this.$store.dispatch("deleteItem", id);
        }
      });
      this.selectAllCheckbox(false);
    },

    onClickFirstPage() {
      this.$emit("page-changed", 1);
      if (this.selectCheckbox) this.selectAllCheckbox(false);
    },
    onClickLastPage() {
      this.$emit("page-changed", this.totalPages);
      if (this.selectCheckbox) this.selectAllCheckbox(false);
    },
    onClickNextPage() {
      this.$emit("page-changed", this.currentPage + 1);
      if (this.selectCheckbox) this.selectAllCheckbox(false);
    },
    onClickPreviousPage() {
      this.$emit("page-changed", this.currentPage - 1);
      if (this.selectCheckbox) this.selectAllCheckbox(false);
    },
    onClickPage(page) {
      this.$emit("page-changed", page);
      if (this.selectCheckbox) this.selectAllCheckbox(false);
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

.table-container {
  display: block;
  margin: 0 3em;
  margin-bottom: 5em;
  max-width: 110vw;
  // ! Tener en cuenta que la mayoría de margins/paddings son relativos al tamaño de fuente (em/rem), por lo que cambiar esto hará que todo se vaya a la verga
  font-size: 0.8rem;
}

.seleccionar-todos-container {
  width: 100px;
  font-family: "Montserrat";
  font-size: 0.9em;
  font-weight: bold;
  text-align: center;
  display: flex;
  flex-flow: column nowrap;
  // position: absolute;
  // left: 30px;
  // top: 320px;
  // bottom: 2;
  margin-left: 0.45rem;
  margin-bottom: 10px;
}

.flex-table {
  display: flex;
  flex-flow: row nowrap;
  border-left: solid 1px $--color-table-border;
  transition: 0.5s;

  &.header {
    font-size: 0.9rem;
    line-height: 1rem;
    font-family: Montserrat;

    .flex-row {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;

      color: white;
      background: $--color-table-header;
      border-color: $--color-table-header-border;
      padding: 0.4rem;
      font-weight: 500;
    }
  }

  &.row {
    .flex-row {
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: #fff;
      font-family: "open sans";
      padding: 0.8rem;

      &.img-link i {
        font-size: 0.9rem;
      }
    }
    &:nth-child(odd) .flex-row {
      background: $--color-row-bg;
    }

    //TODO Conseguir que este hover funcione
    // &:hover {
    //   transition: all 0.5s;
    //   background-color: $--color-row-bg;
    // }
  }
}

// En total tiene que sumar un 100% o el layout no cuadrará (está feo, feísimo, horrendo, pero es lo que hay)
.enunciado {
  width: 30%;
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
  width: 6.5%;
}

.flex-row {
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

.table-fade-enter-active,
.table-fade-leave-active {
  transition: opacity 0.4s;
}
.table-fade-enter, .table-fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
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
