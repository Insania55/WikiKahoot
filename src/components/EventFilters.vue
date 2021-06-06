<template>
  <div class="event-filters">
    <div class="filter-search-container">
      <div
        class="filter-search-form"
        :class="{ 'filter-dropdown': filtersDropdown }"
      >
        <div>
          <button @click="handleData" class="filter-search-button">
            <i class="fas fa-search"></i>
          </button>

          <input
            v-model="searchData.codigo"
            @keydown.enter="handleData"
            class="filter-search-input"
            type="search"
            placeholder="Busca por código de evento"
          />
          <div class="filter-search-options">
            <button @click="cerrarFiltros">
              {{ filtersDropdown ? "Cerrar filtros" : "Filtros" }}
            </button>
            <!-- <i @click="cerrarFiltros" class="fas fa-cogs"></i> -->
          </div>

          <!-- // * Desplegable de filtros -->
          <div class="filter-options-container" v-if="filtersDropdown">
            <form @submit.prevent="saveFilteredData">
              <div class="option-container">
                <AppSelect
                  ref="etapa"
                  :options="this.$store.state.optionsEtapa"
                  label="Etapa"
                  placeholder="Busca una etapa.."
                  @input="setData($event, 'etapa')"
                  @selected-value="setData($event, 'etapa')"
                  isAsync
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="nivel"
                  :options="this.$store.state.optionsNivel"
                  label="Nivel"
                  placeholder="Busca un nivel.."
                  @input="setData($event, 'nivel')"
                  @selected-value="setData($event, 'nivel')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="area"
                  :options="this.$store.state.optionsArea"
                  label="Área"
                  placeholder="Busca un área.."
                  @input="setData($event, 'area')"
                  @selected-value="setData($event, 'area')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="tema"
                  :options="this.$store.state.optionsTema"
                  label="Tema"
                  :placeholder="
                    !isTemaCargado
                      ? 'Selecciona primero un área'
                      : 'Busca un tema..'
                  "
                  :disabled="!isTemaCargado"
                  @input="setData($event, 'tema')"
                  @selected-value="setData($event, 'tema')"
                ></AppSelect>
              </div>
              <div class="button-container">
                <AppButton @click.prevent="saveFilteredData" green
                  >Buscar</AppButton
                >
                <AppButton @click.prevent="resetInputs" normal
                  >Borrar</AppButton
                >
                <AppButton @click.prevent="opcionesParaFiltrar" normal
                  >Probar</AppButton
                >
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AppSelect from "./AppSelect.vue";
import AppButton from "./AppButton.vue";
import * as api from "./js/api.js";

export default {
  name: "EventFilters",
  components: { AppSelect, AppButton },
  data() {
    return {
      searchData: {
        codigo: "",
        etapa: "",
        nivel: "",
        area: "",
        tema: "",
      },

      eventHeaders: [],
      filteredData: null,
    };
  },
  props: {
    filtersDropdown: {
      type: Boolean,
      default: true,
    },
  },
  async created() {
    try {
      await this.$store.dispatch("loadEtapas");
      await this.$store.dispatch("loadAreas");
      await this.$store.dispatch("loadNiveles");
    } catch (error) {
      console.log(error);
    }
  },
  computed: {
    isTemaCargado: function () {
      return this.searchData.area !== "" && this.searchData.area !== undefined;
    },
  },
  watch: {
    "searchData.area": function () {
      this.$store.dispatch("loadTemas", this.searchData.area.value);
    },
  },
  methods: {
    opcionesParaFiltrar: function () {
      let optionsFiltro = [
        { nombre: "FK_IdEtapa", value: this.searchData.etapa.value },
        { nombre: "FK_IdNivel", value: this.searchData.nivel.value },
        { nombre: "FK_IdArea", value: this.searchData.area.value },
        { nombre: "FK_IdTema", value: this.searchData.tema.value },
      ];
      let nani = optionsFiltro.filter((item) => {
        return item.value;
      });

      console.log(nani);
    },
    setData(value, target) {
      this.searchData[target] = value;
    },
    //TODO: Generar llamada al backend consiguiendo los datos filtrados asociados al valor de la búsqueda
    saveFilteredData() {
      //let data = this.searchData;
      console.log("Se ha intentado enviar el formulario");
    },
    async handleData() {
      await this.getEventHeaders();
      await this.getPreguntasById();
    },
    async getEventHeaders() {
      try {
        let codigoEvento = this.searchData.codigo;
        if (codigoEvento !== undefined || codigoEvento !== "") {
          await api
            .getEventoById(codigoEvento)
            .then((response) => {
              console.log(response);
              if (response.status === 200 && response.data.length > 0) {
                this.eventHeaders = response.data;
                this.$emit("header-data", this.eventHeaders);
              }
            })
            .catch((error) => {
              console.log(error);
            });
        } else {
          console.log("Código es undefined o null");
        }
      } catch (e) {
        console.error(e);
      }
    },
    async getPreguntasById() {
      try {
        let codigoEvento = this.searchData.codigo;
        if (codigoEvento !== undefined && codigoEvento !== "") {
          await api
            .getPreguntas(codigoEvento)
            .then((response) => {
              if (response.status === 200 && response.data.length > 0) {
                this.filteredData = response.data;
                this.$emit("data", this.filteredData);
              }
            })
            .catch((error) => {
              console.log(error);
            });
        } else {
          console.log("Código es undefined o null", codigoEvento);
        }
      } catch (error) {
        console.error(error);
      }
    },
    cerrarFiltros() {
      this.$emit("cerrar-filtros");
    },
    resetInputs() {
      this.$refs["etapa"].searchTerm = "";
      this.$refs["nivel"].searchTerm = "";
      this.$refs["area"].searchTerm = "";
      this.$refs["tema"].searchTerm = "";
      this.searchData.etapa = "";
      this.searchData.nivel = "";
      this.searchData.area = "";
      this.searchData.tema = "";
    },
  },
};
</script>

<style lang="scss">
.event-filters {
  $--color-main-container: #bcc;
  $--color-dark-font: #232d38;
  $filter-container-width: 32vw;

  .filter-search-container {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 0.5rem 0;
    margin-bottom: 2.5em;

    // * Barra de filtros sin desplegar
    .filter-search-form {
      position: relative;
      width: 350px;
      min-height: 36px;
      box-shadow: 0 2px 6px 0 rgba(32, 33, 36, 0.28);
      background: $--color-main-container;
      color: $--color-dark-font;
      border-radius: 5px;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;

      // * Icono de lupa
      .filter-search-button {
        position: absolute;
        top: 9px;
        left: 8px;
        height: 18px;
        width: 20px;
        border: none;
        background: none;
        cursor: pointer;
        color: inherit;
      }

      .filter-search-input {
        position: absolute;
        top: 9px;
        left: 35px;
        font-size: 15px;
        background: none;
        color: rgb(15, 34, 34);
        max-width: 250px;
        width: 220px;
        border: none;
        appearance: none;
        font-weight: 500;
        font-family: "Montserrat";
      }

      // * Botón 'Filtros'
      .filter-search-options {
        position: absolute;
        top: 5px;
        right: 9px;

        > button {
          position: relative;
          cursor: pointer;
          padding: 4px 8px;
          background-color: rgba(0, 0, 0, 0.2);
          border: 1px solid rgba(0, 0, 0, 0.5);
          border-radius: 6px;
          font-family: "Montserrat";
          font-weight: 600;
          // color: #0b0d0f;
          color: inherit;
        }
      }
    }
  }

  //* Filtros desplegados
  .filter-dropdown {
    width: $filter-container-width !important;
  }

  .filter-options-container {
    margin-left: 1.2rem;
    justify-content: flex-start;

    .option-container {
      position: relative;
      margin-top: 2.5em;
      display: flex;
      align-items: center;

      label {
        margin-right: 0.5rem;
      }
    }
  }

  .button-container {
    display: flex;
    justify-content: left;
    margin-bottom: 2rem;
    margin-top: 1.8rem;

    :first-child {
      margin-right: 0.6em;
    }
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter,
  .fade-leave-to {
    opacity: 0;
  }
}
</style>
