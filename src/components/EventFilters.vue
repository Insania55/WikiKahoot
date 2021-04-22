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
          <!-- //TODO: Necesita un mejor placeholder. Quizá un subtítulo? -->
          <input
            class="filter-search-input"
            type="search"
            placeholder="Escribe para buscar"
          />
          <div class="filter-search-options">
            <div>
              <i @click="cerrarFiltros" class="fas fa-cogs"></i>
            </div>
          </div>

          <!-- // * Desplegable de filtros -->
          <div class="filter-options-container" v-if="filtersDropdown">
            <div
              v-for="(option, index) in filterOptions"
              :key="index"
              class="filter-option"
            >
              <label class="input" :for="option.name">
                <input
                  class="w-100"
                  type="text"
                  :name="option.name"
                  :placeholder="option.placeholder"
                />
                <span class="input-label">{{ option.label }}</span>
              </label>
            </div>
            <button class="filter-option-button">Buscar</button>
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
      //TODO: Ponerle a los placeholder un margin con CSS y no esta guarrada
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
    };
  },
  props: {
    filtersDropdown: false,
  },
  methods: {
    cerrarFiltros() {
      this.$emit('cerrar-filtros');
    },
  },
};
</script>

<style lang="scss">
.event-filters {
  $--color-filter-container: slategrey;
  $--color-accent: goldenrod;

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
        color: black;
        width: 92%;
        height: 20px;
        border: none;
        appearance: none;
        font-weight: 700;
      }

      .filter-search-options {
        position: absolute;
        text-align: right;
        top: 5px;
        right: 9px;

        > div {
          position: relative;
          display: inline-block;
          margin: 0 1px;
          cursor: pointer;
        }
      }
    }
  }

  .filter-dropdown {
    width: 85%;
  }

  .filter-options-container {
    flex-direction: row;
    flex-wrap: wrap;
    margin: 37px 14px 1rem;
    justify-content: flex-start;
    width: 98%;

    .filter-option {
      padding: 1rem;
      display: flex;
      flex-flow: column nowrap;
      justify-content: flex-start;

      .input {
        position: relative;

        .input-label {
          position: absolute;
          left: 0;
          top: 0;
          padding: 6px 4px;
          margin: 9px 4px;

          background: $--color-filter-container;
          white-space: nowrap;
          transform: translate(0, 0);
          transform-origin: 0, 0;
          transition: transform 120ms ease-in;
          font-weight: bold;
          line-height: 1.2;
        }

        > input {
          display: block;
          width: 80%;
          border: 3px solid currentColor;
          padding: 1rem 0.5rem;
          color: currentColor;
          background: transparent;
          border-radius: 4px;

          &:focus,
          &:not(:placeholder-shown) {
            & + .input-label {
              transform: translate(0.3rem, -65%) scale(1);
              color: $--color-accent;
            }
          }
        }
      }
    }
  }
}
</style>
