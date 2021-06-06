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
      <h2>- Resultados de la búsqueda -</h2>
      <ul v-if="eventosFiltrados.length !== 0">
        <li>
          <span>Etapa</span>
          <span>{{ eventNames.nombreEtapa }}</span>
        </li>
        <li>
          <span>Área</span>
          <span>{{ eventNames.nombreArea }}</span>
        </li>
        <li>
          <span>Nivel</span>
          <span>{{ eventNames.nombreNivel }}</span>
        </li>
        <li>
          <span>Tema</span>
          <span>{{ eventNames.nombreTema }}</span>
        </li>

        <li>
          <span>Nº Preguntas</span>
          <span>{{ eventosFiltrados.length }}</span>
        </li>
      </ul>
    </div>

    <AppPaginatedTable
      :data="eventosFiltrados.length === 0 ? filteredData : eventosFiltrados"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(eventosFiltrados.length / itemsPerPage)"
      :total="eventosFiltrados.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
      :selectCheckbox="true"
    >
    </AppPaginatedTable>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>
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
  },
  methods: {
    getFilterData(data) {
      this.eventosFiltrados = data;
      // * Mantenemos en la store los datos filtrados
      this.$store.commit("saveFilteredData", data);
    },
    getHeaderData(data) {
      this.eventNames = data[0];
    },
    sendCurrentData() {
      console.log("Enviando datos", this.dataToDownload);
    },
    onPageChange(page) {
      this.currentPage = page;
    },
    openFiltersDropdown() {
      this.filtersDropdown = !this.filtersDropdown;
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
      align-items: center;
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
}
</style>
