<template>
  <div class="current-download-page">
    <AppPaginatedTable
      :data="downloadData"
      title="Descarga actual"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(downloadData.length / itemsPerPage)"
      :total="downloadData.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="consolear"
      @current-download="consolear"
      borrable
      selectCheckbox
    >
    </AppPaginatedTable>
    <!-- <button @click="getDowloadedData">Consolear</button> -->
    <!-- //TODO: Botón para volver a la página anterior -->
  </div>
</template>

<script>
import AppPaginatedTable from "./AppPaginatedTable.vue";

export default {
  name: "DatosDescargados",
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
      currentPage: 1,
      itemsPerPage: 50,
    };
  },
  components: {
    AppPaginatedTable,
  },
  computed: {
    downloadData() {
      return this.$store.state.downloadData;
    },
  },
  methods: {
    consolear(ev) {
      console.log(ev);
    },
  },
};
</script>

<style lang="scss">
.current-download-page {
  .app-paginated-table {
    margin-top: 1em;
  }
}
</style>