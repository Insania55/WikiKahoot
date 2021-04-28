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
            <form>
              <div class="option-container">
                <label>Etapa</label>
                <input
                  v-model="staticData.etapa"
                  class="chosen-value"
                  @click="desplegableEtapa = !desplegableEtapa"
                  @focus="cambiarFocus"
                  @focusout="desplegableEtapa = false"
                  type="text"
                  placeholder="Escribe y filtra"
                />
                <ul class="value-list" :class="{ open: desplegableEtapa }">
                  <li
                    v-for="(option, index) in optionsEtapa"
                    :key="index"
                    @click="
                      seleccionarDato('etapa', option.name),
                        (desplegableEtapa = false)
                    "
                  >
                    {{ option.name }}
                  </li>
                </ul>
              </div>

              <div class="option-container">
                <label>Nivel</label>
                <input
                  @click="desplegableNivel = !desplegableNivel"
                  class="chosen-value"
                  type="text"
                  v-model="staticData.nivel"
                  @focus="cambiarFocus"
                  @focusout="desplegableNivel = false"
                  placeholder="Escribe y filtra"
                />
                <ul class="value-list" :class="{ open: desplegableNivel }">
                  <li
                    v-for="(option, index) in optionsNivel"
                    :key="index"
                    @click="
                      seleccionarDato('nivel', option.name),
                        (desplegableNivel = false)
                    "
                  >
                    {{ option.name }}
                  </li>
                </ul>
              </div>

              <div class="option-container">
                <label>Área</label>
                <input
                  v-model="staticData.area"
                  class="chosen-value"
                  @click="desplegableArea = !desplegableArea"
                  @focus="cambiarFocus"
                  @focusout="desplegableArea = false"
                  type="text"
                  placeholder="Escribe y filtra"
                />
                <ul class="value-list" :class="{ open: desplegableArea }">
                  <li
                    v-for="(option, index) in filteredOptions(
                      optionsArea,
                      currentInput
                    )"
                    :key="index"
                    @click="
                      seleccionarDato('area', option.name),
                        (desplegableArea = false)
                    "
                  >
                    {{ option.name }}
                  </li>
                </ul>
              </div>

              <!-- //TODO: Estilarlo para posicionarlo mejor en el contenedor  -->
              <div class="option-container">
                <label>Tema</label>
                <input
                  v-model="staticData.tema"
                  class="chosen-value"
                  :disabled="!isTemaCargado"
                  @click="desplegableTema = !desplegableTema"
                  @focus="cambiarFocus"
                  @focusout="desplegableTema = false"
                  type="text"
                  placeholder="Escribe y filtra"
                />
                <ul class="value-list" :class="{ open: desplegableTema }">
                  <li
                    v-for="(option, index) in optionsTema"
                    :key="index"
                    @click="
                      seleccionarDato('tema', option.name),
                        (desplegableTema = false)
                    "
                  >
                    {{ option.name }}
                  </li>
                </ul>
              </div>
              <div class="button-containr">
                <button class="filter-option-button">Buscar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EventFilters',
  data() {
    return {
      //TODO: staticData deberían ser las opciones y esto los searchTerm
      staticData: {
        etapa: '',
        area: '',
        tema: '',
        nivel: '',
      },
      desplegableEtapa: false,
      desplegableNivel: false,
      desplegableArea: false,
      desplegableTema: false,
      currentInput: null,
      filterOptions: [
        {
          label: 'Área',
          name: 'area',
          placeholder: '           Área temática general',
        },
        {
          label: 'Etapa',
          name: 'etapa',
          placeholder: '             Etapa educativa. si procede',
        },
        {
          label: 'Nivel',
          name: 'nivel',
          placeholder: '           Nivel de complejidad',
        },
        {
          label: 'Tema',
          name: 'tema',
          placeholder: '           Tema concreto de la pregunta',
        },
      ],
      optionsEtapa: [
        {
          name: 'Primaria',
          value: 'primaria',
        },
        {
          name: 'Secundaria',
          value: 'secundaria',
        },
        {
          name: 'Bachiller',
          value: 'bachiller',
        },
      ],
      optionsNivel: [
        {
          name: 'Fácil',
          value: 'facil',
        },
        {
          name: 'Intermedio',
          value: 'intermedio',
        },
        {
          name: 'Difícil',
          value: 'dificil',
        },
      ],
      optionsArea: [
        {
          name: 'Anime',
          value: 'anime',
        },
        {
          name: 'Historia',
          value: 'historia',
        },
        {
          name: 'Furbo',
          value: 'furbo',
        },
      ],
      optionsTema: [
        {
          name: 'Gormiti',
          value: 'gormiti',
        },
        {
          name: '2ª Guerra Mundial',
          value: 'segunda guerra mundial',
        },
        {
          name: 'Barça',
          value: 'barça',
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
    isTemaCargado: function() {
      return (
        this.staticData.etapa !== '' &&
        this.staticData.nivel !== '' &&
        this.staticData.area !== ''
      );
    },
    //TODO: Conseguir filtrar los inputs... este método debe tener un array con opciones por defecto, hasta que se empiece a filtrar
    filteredOptions: function(options, currentInput) {
      // console.log(currentInput);
      return options;
      // return options.filter((element) => {
      // return element.value.toLowerCase().match(searchTerm.toLowerCase());
      // });
    },
  },
  methods: {
    cambiarFocus(value) {
      this.currentInput = value.target;
    },
    seleccionarDato(target, data) {
      this.staticData[target] = data;
    },
    cerrarFiltros() {
      this.$emit('cerrar-filtros');
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

  .filter-dropdown {
    width: 85% !important;
  }

  .filter-options-container {
    margin: 37px 14px 1rem;
    justify-content: flex-start;
    width: 98%;

    .button-containr {
      margin-top: 1em;
    }

    button {
      font-family: 'Fredoka One', cursive;
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

    .value-list {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 999;
      width: 100%;
      margin-left: 4rem;
    }
    //TODO: Refactorizar a código SCSS
    .chosen-value {
      font-family: 'Ek Mukta';
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 4px;
      font-size: 1.1rem;
      background-color: #fafcfd;
      border: 3px solid transparent;
      -webkit-transition: 0.3s ease-in-out;
      transition: 0.3s ease-in-out;
    }
    .chosen-value::-webkit-input-placeholder {
      color: #333;
    }
    .chosen-value:hover {
      background-color: #ff908b;
      cursor: pointer;
    }
    .chosen-value:hover::-webkit-input-placeholder {
      color: #333;
    }
    .chosen-value:focus,
    .chosen-value.open {
      box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
      outline: 0;
      background-color: #ff908b;
      color: #000;
    }
    .chosen-value:focus::-webkit-input-placeholder,
    .chosen-value.open::-webkit-input-placeholder {
      color: #000;
    }

    .value-list {
      list-style: none;
      margin-top: 2rem;
      box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      max-height: 0;
      -webkit-transition: 0.3s ease-in-out;
      transition: 0.3s ease-in-out;
    }
    .value-list.open {
      max-height: 320px;
      overflow: auto;
    }
    .value-list li {
      position: relative;
      height: 4rem;
      background-color: #fafcfd;
      padding: 1rem;
      font-size: 1.1rem;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
      cursor: pointer;
      -webkit-transition: background-color 0.3s;
      transition: background-color 0.3s;
      opacity: 1;
    }
    .value-list li:hover {
      background-color: #ff908b;
    }
    .value-list li.closed {
      max-height: 0;
      overflow: hidden;
      padding: 0;
      opacity: 0;
    }
  }
}
</style>
