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
      @data="saveFilterData"
      @header-data="saveHeaderData"
    >
    </EventFilters>
    <AppPaginatedTable
      :data="bddEventos"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(bddEventos.length / itemsPerPage)"
      :total="bddEventos.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
      @current-download="saveDownloadData"
      :selectCheckbox="true"
    >
    </AppPaginatedTable>
    <h2>Resultados de la búsqueda</h2>
    <ul class="event-name-list">
      <li>Área: {{}}</li>
      <li>Etapa: {{}}</li>
      <li>Nivel: {{}}</li>
      <li>Tema: {{}}</li>
    </ul>
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
      bddEventos: [
        // {
        //   enunciado:
        //     "¿Qué propiedad de CSS es la más apropiada para poner en negrita la letra?",
        //   respuesta1: "font-weight",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: ":D",
        //   timeLimit: 60,
        //   respuestaCorrecta: "1,2",
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        //   // revisado: false,
        //   // fecha: new Date().toLocaleString()
        // },
        // {
        //   enunciado: "¿Quién creó Mortadelo y Filemón?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Francisco Ibáñez",
        //   respuesta4: ":D",
        //   timeLimit: 120,
        //   respuestaCorrecta: 2,
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado:
        //     "¿En qué año se descubrió América? Vamos venga dímelo no podré vivir si no me lo dices venga vamos",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
        // {
        //   enunciado: "¿En qué año se descubrió América?",
        //   respuesta1: "Idk",
        //   respuesta2: "No lo sé",
        //   respuesta3: "Who knows",
        //   respuesta4: "1492",
        //   timeLimit: 90,
        //   respuestaCorrecta: 4,
        //   imgLink: "https://unsplash.com/photos/fHXP17AxOEk",
        // },
      ],
    };
  },
  components: {
    EventFilters,
    AppPaginatedTable,
  },

  methods: {
    saveFilterData(data) {
      this.eventosFiltrados = data;
      console.log(this.eventosFiltrados);
    },
    saveHeaderData(data) {
      this.eventNames = data;
      console.log(this.eventNames);
    },
    saveDownloadData(ev) {
      this.dataToDownload.push(ev);
      console.log("dataToDownload", this.dataToDownload);
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
  background: #fff;
  // &::before {
  //   content: "";
  //   // background-image: url("../../assets/logoBackground.png");
  //   background-color: #fff;
  //   background-image: linear-gradient(
  //     0deg,
  //     #61b038 20%,
  //     #6fb8e5
  //   ); // background-position: center;
  //   // background-size: cover;
  //   background-repeat: no-repeat;
  //   position: absolute;
  //   top: 0px;
  //   right: 0px;
  //   bottom: 0px;
  //   left: 0px;
  //   opacity: 0.4;
  //   background-blend-mode: darken;
  // }
}
</style>
