<template>
  <div class="event-filters">
    <div class="filter-search-container">
      <div
        class="filter-search-form"
        :class="{ 'filter-dropdown': filtersDropdown }"
      >
        <div>
          <button @click="searchByCodigo" class="filter-search-button">
            <i class="fas fa-search"></i>
          </button>

          <input
            v-model="searchData.codigo"
            @keydown.enter="searchByCodigo"
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
                  :options="optionsEtapa"
                  label="Etapa"
                  placeholder="Busca una etapa.."
                  @input="setData($event, 'etapa')"
                  @selected-value="setData($event, 'etapa')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="nivel"
                  :options="optionsNivel"
                  label="Nivel"
                  placeholder="Busca un nivel.."
                  @input="setData($event, 'nivel')"
                  @selected-value="setData($event, 'nivel')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="area"
                  :options="optionsArea"
                  label="Área"
                  placeholder="Busca un área.."
                  @input="setData($event, 'area')"
                  @selected-value="setData($event, 'area')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="tema"
                  :options="optionsTema"
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
                <button @click.prevent="saveData" class="filter-option-button">
                  Buscar
                </button>
                <button
                  @click.prevent="resetInputs"
                  class="filter-option-button"
                >
                  Borrar
                </button>
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
import * as api from "./js/api.js";

export default {
  name: "EventFilters",
  components: { AppSelect },
  data() {
    return {
      searchData: {
        codigo: "",
        etapa: "",
        nivel: "",
        area: "",
        tema: "",
      },
      optionsEtapa: [],
      optionsNivel: [
        {
          name: "Fácil",
          value: "facil",
        },
        {
          name: "Intermedio",
          value: "intermedio",
        },
        {
          name: "Difícil",
          value: "dificil",
        },
      ],
      optionsArea: [],
      optionsTema: [
        {
          name: "Gormiti",
          value: "gormiti",
        },
        {
          name: "2ª Guerra Mundial",
          value: "segunda guerra mundial",
        },
        {
          name: "Barça",
          value: "barça",
        },
      ],
    };
  },
  props: {
    filtersDropdown: {
      type: Boolean,
      default: true,
    },
  },
  created() {
    this.loadEtapas();
    this.loadAreas();
  },
  computed: {
    isTemaCargado: function () {
      return this.searchData.area !== "" && this.searchData.area !== undefined;
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
    loadEtapas() {
      api
        .getEtapas()
        .then((response) => {
          if (response.status === 200 && response.data.length > 0) {
            const selectEtapas = response.data.reduce((acc, value) => {
              acc.push({ value: value.IdEtapa, text: value.Nombre });
              return acc;
            }, []);
            this.optionsEtapa = selectEtapas;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadAreas() {
      api
        .getAreas()
        .then((response) => {
          if (response.status === 200 && response.data.length > 0) {
            const selectAreas = response.data.reduce((acc, value) => {
              acc.push({ value: value.IdArea, text: value.Nombre });
              return acc;
            }, []);
            this.optionsArea = selectAreas;
          }
        })
        .catch((error) => {
          console.log(error);
        });
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
    //TODO: Generar llamada a backend para buscar las preguntas asociadas a un código de evento
    searchByCodigo() {
      console.log("Se ha intentado buscar por código");
    },
  },
};
</script>

<style lang="scss">
.event-filters {
  $--color-main-container: #bbb;
  $--color-dark-font: #2c3e50;
  $--select-border: #444;
  $--select-arrow: $--select-border;

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
      transition: all 0.3s ease;

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

      .filter-search-options {
        position: absolute;
        text-align: right;
        top: 5px;
        right: 9px;
        // TODO: Estilar mejor este botón
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

  //* Filtros desplegados
  .filter-dropdown {
    width: 40% !important;
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
  // TODO: Refactorizar estos botones y pasarlos a componente
  .button-container {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
    margin-top: 1.5rem;

    button {
      display: inline-block;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-weight: bold;
      text-align: center;
      min-height: 42px;
      min-width: 7.5rem;
      padding: 0px 16px 4px;
      position: relative;
      line-height: 0.9rem;
      background: rgb(242, 242, 242) none repeat scroll 0% 0%;
      box-shadow: rgba(0, 0, 0, 0.25) 0px -4px inset;
      margin-right: 1em;

      &:hover:enabled {
        min-height: 40px;
        margin-top: 2px;
        background-color: rgb(223, 223, 223);
        box-shadow: rgba(0, 0, 0, 0.25) 0px -2px inset;
        padding-bottom: 2px;
      }

      &:active:enabled {
        min-height: 38px;
        margin-top: 4px;
        padding-bottom: 0px;
        box-shadow: none;
        background-color: rgb(202, 202, 202);
      }

      &:last-child {
        background: rgb(38, 137, 12) none repeat scroll 0% 0%;
        color: white;

        &:hover:enabled {
          background-color: rgb(35, 126, 11);
        }

        &:active:enabled {
          background-color: rgb(32, 115, 10);
        }

        &[disabled] {
          cursor: not-allowed;
          background-color: rgb(204, 204, 204);
          color: white;
          box-shadow: none;
          padding-bottom: 0;

          &:hover {
            background-color: rgb(150, 150, 150);
          }
        }
      }
    }
  }
}
</style>
