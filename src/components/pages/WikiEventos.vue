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
      :total-pages="Math.ceil(bddEventos.length / itemsPerPage)"
      :total="bddEventos.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
      :selectCheckbox="true"
    >
    </AppPaginatedTable>
  </div>
</template>

<script>
import Evento from '../Evento.vue';
// import Preguntas from '../Preguntas.vue';
import EventFilters from '../EventFilters.vue';
import AppPaginatedTable from '../AppPaginatedTable.vue';

export default {
  name: 'WikiEventos',
  data() {
    return {
      camposHeader: [
        'Enunciado',
        'Respuesta 1',
        'Respuesta 2',
        'Respuesta 3',
        'Respuesta 4',
        'Respuesta correcta',
        'Tiempo límite',
        'Enlace a imagen',
      ],
      filtersDropdown: false,
      currentPage: 1,
      itemsPerPage: 5,
      dataToDownload: [],
      bddEventos: [
        {
          enunciado:
            '¿Qué propiedad de CSS es la más apropiada para poner en negrita la letra?',
          respuesta1: 'font-weight',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: ':D',
          timeLimit: 60,
          respuestaCorrecta: '1,2',
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
          // revisado: false,
          // fecha: new Date().toLocaleString()
        },
        {
          enunciado: '¿Quién creó Mortadelo y Filemón?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Francisco Ibáñez',
          respuesta4: ':D',
          timeLimit: 120,
          respuestaCorrecta: 2,
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
          respuesta1: 'Idk',
          respuesta2: 'No lo sé',
          respuesta3: 'Who knows',
          respuesta4: '1492',
          timeLimit: 90,
          respuestaCorrecta: 4,
          imgLink: 'https://unsplash.com/photos/fHXP17AxOEk',
        },
        {
          enunciado: '¿En qué año se descubrió América?',
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
    EventFilters,
    AppPaginatedTable,
    // Preguntas,
  },
  methods: {
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
}
</style>
