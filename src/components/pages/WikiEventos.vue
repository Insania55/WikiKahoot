<template>
  <div class="wiki-eventos">
    <header>
      <h2 class="title">Filtrado de eventos</h2>
      <span
        >Busca por código de evento, o despliega los
        <strong>filtros</strong> para buscar por criterios más avanzados</span
      >
    </header>
    <EventFilters
      :filters-dropdown="filtersDropdown"
      @cerrar-filtros="filtersDropdown = !filtersDropdown"
      @data="getFilterData"
      @header-data="getHeaderData"
    >
    </EventFilters>

    <div class="event-names-container">
      <h2>Resultados de la búsqueda</h2>
      <ul v-if="eventosFiltrados.length !== 0 || filteredData.length !== 0">
        <li>
          <span>Etapa</span>
          <span>{{
            eventNames.length !== 0
              ? eventNames.nombreEtapa
              : filteredHeaders.nombreEtapa
          }}</span>
        </li>
        <li>
          <span>Nivel</span>
          <span>{{
            eventNames.length !== 0
              ? eventNames.nombreNivel
              : filteredHeaders.nombreNivel
          }}</span>
        </li>
        <li>
          <span>Área</span>
          <span>{{
            eventNames.length !== 0
              ? eventNames.nombreArea
              : filteredHeaders.nombreArea
          }}</span>
        </li>
        <li>
          <span>Tema</span>
          <span>{{
            eventNames.length !== 0
              ? eventNames.nombreTema
              : filteredHeaders.nombreTema
          }}</span>
        </li>
        <li>
          <span>Nº Preguntas</span>
          <span>{{ eventosFiltrados.length || filteredData.length }}</span>
        </li>
      </ul>
    </div>

    <!-- // * Si no tenemos datos en eventosFiltrados, conseguimos los datos de la store (si los hay) -->
    <AppPaginatedTable
      :data="eventosFiltrados.length === 0 ? filteredData : eventosFiltrados"
      :headerFields="camposHeader"
      :total-pages="
        eventosFiltrados.length === 0
          ? Math.ceil(filteredData.length / itemsPerPage)
          : Math.ceil(eventosFiltrados.length / itemsPerPage)
      "
      :total="
        eventosFiltrados.length === 0
          ? filteredData.length
          : eventosFiltrados.length
      "
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
      :selectCheckbox="true"
      @notify-success="notifySuccess"
      @notify-error="notifyError"
    >
    </AppPaginatedTable>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>

    <transition name="diluir">
      <div v-if="error" class="alert-box error">
        <span><i class="fas fa-times"></i>{{ errorMsg }}</span>
      </div>
    </transition>

    <transition name="diluir">
      <div v-if="success" class="alert-box success">
        <span><i class="fas fa-check"></i>{{ successMsg }}</span>
      </div>
    </transition>
  </div>
</template>

<script>
import EventFilters from "../EventFilters.vue";
import AppPaginatedTable from "../AppPaginatedTable.vue";

export default {
  name: "WikiEventos",
  data() {
    return {
      camposHeader: [
        "Enunciado",
        "Respuesta 1",
        "Respuesta 2",
        "Respuesta 3",
        "Respuesta 4",
        "Respuesta correcta",
        "Tiempo límite",
        "Imagen",
      ],
      filtersDropdown: false,
      currentPage: 1,
      itemsPerPage: 50,
      dataToDownload: [],
      eventNames: [],
      eventosFiltrados: [],
      error: false,
      success: false,
      errorMsg: "",
      successMsg: "",
    };
  },
  components: {
    EventFilters,
    AppPaginatedTable,
  },
  computed: {
    filteredData() {
      return this.$store.state.filteredData;
    },
    filteredHeaders() {
      return this.$store.state.filteredHeaders;
    },
  },
  methods: {
    getFilterData(data) {
      if (Array.isArray(data)) {
        this.eventosFiltrados = data;
        // * Mantenemos en la store los datos filtrados
        this.$store.commit("saveFilteredData", data);
        // * Al recibir datos de búsqueda, reseteamos el índice del paginador
        this.currentPage = 1;
      } else {
        this.notifyError(data.msg);
      }
    },
    getHeaderData(data) {
      this.eventNames = data;
      // * Mantenemos en la store los headers filtrados
      this.$store.commit("saveFilteredHeaders", data);
    },
    onPageChange(page) {
      this.currentPage = page;
    },
    openFiltersDropdown() {
      this.filtersDropdown = !this.filtersDropdown;
    },
    notifyError(msg) {
      this.errorMsg = msg;
      this.error = true;
      this.timeout = setTimeout(() => {
        this.error = false;
      }, 1500);
    },
    notifySuccess(msg) {
      this.successMsg = msg;
      this.success = true;
      this.timeout = setTimeout(() => {
        this.success = false;
      }, 1500);
    },
  },
};
</script>

<style lang="scss">
.wiki-eventos {
  header {
    margin-bottom: 2em;
    text-align: center;
    .title {
      padding: 0.5em 0;
    }
  }

  .event-names-container {
    display: flex;
    text-align: center;
    justify-content: center;
    flex-direction: column;

    h2 {
      margin-bottom: 1rem;
    }

    ul {
      width: 40vw;
      font-family: "Open sans";
      display: flex;
      justify-content: space-around;
      box-shadow: 0 3px 6px 1px rgba(32, 33, 36, 0.28);
      border-radius: 5px;
      margin: 0 auto;
      padding: 0.4rem;

      li {
        display: flex;
        flex-direction: column;
        list-style-type: none;
        margin: 0.6rem;
      }
    }

    span:first-child {
      font-weight: bold;
      font-size: 17px;
      padding-top: 5px;
      text-decoration: underline;
      margin-bottom: 0.4rem;
      color: #15527a;
    }
  }

  .alert-box {
    position: fixed;
    bottom: 0;
    right: 5rem;
    border: 1px solid transparent;
    border-radius: 4px;
    margin: 1rem;
    padding: 1rem 3rem;
    font-family: "open sans";
    font-weight: 500;

    i {
      margin-right: 6px;
    }

    &.error {
      color: #a94442;
      background-color: #f2dede;
      border-color: #ebccd1;
    }

    &.success {
      color: #3c763d;
      background-color: #dff0d8;
      border-color: #d6e9c6;
    }

    &.warning {
      color: #8a6d3b;
      background-color: #fcf8e3;
      border-color: #faebcc;
    }
  }

  .diluir-enter-active {
    transition: opacity 0.3s ease;
  }
  .diluir-leave-active {
    transition: opacity 0.7s ease;
  }
  .diluir-enter, .diluir-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    // transition: all 0.4s ease-in;
  }
}
</style>
