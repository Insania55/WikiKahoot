<template>
  <div class="event-filters">
    <div class="filter-search-container">
      <div
        class="filter-search-form"
        :class="{ 'filter-dropdown': filtersDropdown }"
      >
        <div>
          <button class="filter-search-button">
            <i class="fas fa-search"></i>
          </button>

          <input
            class="filter-search-input"
            type="search"
            placeholder="Escribe para buscar"
          />
          <div class="filter-search-options">
            <button @click="cerrarFiltros">Abrir filtros</button>
            <!-- <i @click="cerrarFiltros" class="fas fa-cogs"></i> -->
          </div>

          <!-- // * Desplegable de filtros -->
          <div class="filter-options-container" v-if="filtersDropdown">
            <form @submit.prevent="cerrarFiltros">
              <div class="option-container">
                <AppSelect
                  :options="optionsEtapa"
                  label="Etapa"
                  placeholder="Busca una etapa.."
                  @input="setData($event, 'etapa')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  :options="optionsNivel"
                  label="Nivel"
                  placeholder="Busca un nivel.."
                  @input="setData($event, 'nivel')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  :options="optionsArea"
                  label="Área"
                  placeholder="Busca un área.."
                  @input="setData($event, 'area')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  :options="optionsTema"
                  label="Tema"
                  :placeholder="
                    isDisabled ? 'Rellena los otros datos' : 'Busca un tema..'
                  "
                  :disabled="isDisabled"
                  @input="setData($event, 'tema')"
                ></AppSelect>
              </div>
              <div class="button-containr">
                <button class="filter-option-button">Buscar</button>
              </div>
              <!-- //TODO: Funcionalidad para resetear los inputs -->
              <div class="button-containr">
                <button class="filter-option-button">Borrar</button>
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
export default {
  name: "EventFilters",
  components: { AppSelect },
  data() {
    return {
      searchData: {
        etapa: "",
        area: "",
        tema: "",
        nivel: "",
      },
      filterOptions: [
        {
          label: "Área",
          name: "area",
          placeholder: "           Área temática general",
        },
        {
          label: "Etapa",
          name: "etapa",
          placeholder: "             Etapa educativa. si procede",
        },
        {
          label: "Nivel",
          name: "nivel",
          placeholder: "           Nivel de complejidad",
        },
        {
          label: "Tema",
          name: "tema",
          placeholder: "           Tema concreto de la pregunta",
        },
      ],
      optionsEtapa: [
        {
          name: "Primaria",
          value: "primaria",
        },
        {
          name: "Secundaria",
          value: "secundaria",
        },
        {
          name: "Bachiller",
          value: "bachiller",
        },
      ],
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
      optionsArea: [
        {
          name: "Anime",
          value: "anime",
        },
        {
          name: "Historia",
          value: "historia",
        },
        {
          name: "Furbo",
          value: "furbo",
        },
      ],
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
  computed: {
    isTemaCargado: function () {
      return (
        this.searchData.etapa !== "" &&
        this.searchData.nivel !== "" &&
        this.searchData.area !== ""
      );
    },
    isDisabled() {
      return this.isTemaCargado ? false : true;
    },
  },
  methods: {
    setData(value, target) {
      this.searchData[target] = value;
    },
    cerrarFiltros() {
      this.$emit("cerrar-filtros");
    },
  },
};
</script>

<style lang="scss">
.event-filters {
  $--color-filter-container: salmon;
  $--color-dark-font: #2c3e50;
  $--select-border: #444;
  $--select-arrow: $--select-border;

  .filter-search-container {
    display: flex;
    flex-flow: row nowrap;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 1rem;

    // * Barra de filtros sin desplegar
    .filter-search-form {
      position: relative;
      width: 350px;
      min-height: 32px;
      box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
      background: $--color-filter-container;
      color: $--color-dark-font;
      border-radius: 8px;
      transition: all 0.3s ease;

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
          padding: 3px 5px;
          background: transparent;
          border: unset;
          border-radius: 5px;
          box-shadow: 1px 1px 2px;
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

    .button-containr {
      margin-top: 1em;
    }

    button {
      font-family: "Fredoka One", cursive;
      display: inline-block;
      border: none;
      padding: 0.8rem;
      background-color: transparent;
      cursor: pointer;
      border-radius: 4px;
      background: $--color-dark-font;
      margin-bottom: 2em;
      margin-left: 1.2em;

      &:active {
        transform: translateY(2px);
        background: rgba(30, 143, 255, 0.9);
      }
    }
    .option-container {
      position: relative;
      width: 40%;
      margin-top: 8vh;
      display: flex;
      align-items: center;

      label {
        margin-right: 0.5rem;
      }
    }
  }
}
</style>
