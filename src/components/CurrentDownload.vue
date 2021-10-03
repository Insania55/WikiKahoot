<template>
  <div class="current-download-page">
    <!-- TODO Quitar los console.log de prueba, seguramente los métodos se puedan utilizar para algo -->
    <AppPaginatedTable
      :data="storedData"
      title="Descarga actual"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(storedData.length / itemsPerPage)"
      :total="storedData.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="consolear"
      @current-download="consolear"
      borrable
      selectCheckbox
    >
    </AppPaginatedTable>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>
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
    storedData() {
      return this.$store.state.storedData;
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