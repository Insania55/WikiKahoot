<template>
  <div class="event-filters">
    <div class="filter-search-container">
      <div
        class="filter-search-form"
        :class="{ 'filter-dropdown': filtersDropdown }"
      >
        <div>
          <button @click="getEventoById" class="filter-search-button">
            <i class="fas fa-search"></i>
          </button>

          <input
            v-model="searchData.codigo"
            @keydown.enter="getEventoById"
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
            <form @submit.prevent="saveData">
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
                <AppButton @click.prevent="saveData" green>Buscar</AppButton>
                <AppButton @click.prevent="resetInputs" normal
                  >Borrar</AppButton
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
      filteredData: [],
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
    setData(value, target) {
      this.searchData[target] = value;
    },
    //TODO: Generar llamada al backend consiguiendo los datos filtrados asociados al valor de la búsqueda
    saveData() {
      //let data = this.searchData;
      console.log("Se ha intentado enviar el formulario");
    },
    //TODO: Terminar esto
    async getEventoById() {
      try {
        let codigoEvento = this.searchData.codigo;
        console.log(codigoEvento);
        if (codigoEvento !== undefined || codigoEvento !== "") {
          await api
            .getEventoById(codigoEvento)
            .then((response) => {
              if (response.status === 200 && response.data.length > 0) {
                console.log(response.data);
                // this.filteredData = selectTema;
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
  $--color-dark-font: #2c3e50;
  $--select-border: #444;
  $--select-arrow: $--select-border;
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
      min-height: 34px;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
      background: $--color-main-container;
      color: $--color-dark-font;
      border-radius: 5px;
      transition: all 0.2s ease;

      // Lupa
      .filter-search-button {
        position: absolute;
        top: 5px;
        left: 9px;
        height: 18px;
        width: 20px;
        padding: 0;
        border: none;
        background: none;
        cursor: pointer;
        color: inherit;
      }

      .filter-search-input {
        position: absolute;
        top: 5px;
        left: 31px;
        font-size: 15px;
        background: none;
        color: rgb(15, 34, 34);
        width: 92%;
        height: 20px;
        color: #001;
        border: none;
        appearance: none;
        font-weight: 700;
      }

      // Botón de 'Abrir filtros'
      .filter-search-options {
        position: absolute;
        text-align: right;
        top: 5px;
        right: 9px;

        > button {
          position: relative;
          display: inline-block;
          cursor: pointer;
          padding: 3px 8px;
          max-height: 30px;
          background: transparent;
          border: 1px solid black;
          border-radius: 5px;
          box-shadow: 0px 1px 1px;
        }
      }
    }
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.5s;
  }
  .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
  }

  //* Filtros desplegados
  .filter-dropdown {
    width: $filter-container-width !important;
  }

  .filter-options-container {
    margin: 37px 20px 1rem;
    justify-content: flex-start;
    // width: 100%;

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
}
</style>
