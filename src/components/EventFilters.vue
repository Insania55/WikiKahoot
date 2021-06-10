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
                  @input="setData($event, 'nombreEtapa')"
                  @selected-value="setData($event, 'nombreEtapa')"
                  isAsync
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="nivel"
                  :options="this.$store.state.optionsNivel"
                  label="Nivel"
                  placeholder="Busca un nivel.."
                  @input="setData($event, 'nombreNivel')"
                  @selected-value="setData($event, 'nombreNivel')"
                ></AppSelect>
              </div>

              <div class="option-container">
                <AppSelect
                  ref="area"
                  :options="this.$store.state.optionsArea"
                  label="Área"
                  placeholder="Busca un área.."
                  @input="setData($event, 'nombreArea')"
                  @selected-value="setData($event, 'nombreArea')"
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
                  @input="setData($event, 'nombreTema')"
                  @selected-value="setData($event, 'nombreTema')"
                ></AppSelect>
              </div>
              <div class="button-container">
                <AppButton @click.prevent="saveFilteredData" green
                  >Buscar</AppButton
                >
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
        nombreEtapa: "",
        nombreNivel: "",
        nombreArea: "",
        nombreTema: "",
      },
      eventHeaders: [],
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
      // * Agrupamos las llamadas a la API en un array de promesas y las resolvemos de forma concurrente
      let data = Promise.all([
        this.$store.dispatch("loadEtapas"),
        this.$store.dispatch("loadAreas"),
        this.$store.dispatch("loadNiveles"),
      ]);
      return await data;
    } catch (error) {
      console.error(error);
    }
  },
  computed: {
    isTemaCargado: function () {
      return (
        this.searchData.nombreArea !== "" &&
        this.searchData.nombreArea !== undefined
      );
    },
  },
  watch: {
    "searchData.nombreArea": function () {
      this.$store.dispatch("loadTemas", this.searchData.nombreArea.value);
    },
  },
  methods: {
    valoresFiltrados: function () {
      let optionsFiltro = [
        { nombre: "FK_IdEtapa", value: this.searchData.nombreEtapa.value },
        { nombre: "FK_IdNivel", value: this.searchData.nombreNivel.value },
        { nombre: "FK_IdArea", value: this.searchData.nombreArea.value },
        { nombre: "FK_IdTema", value: this.searchData.nombreTema.value },
      ];
      return optionsFiltro.filter((item) => {
        return item.value;
      });
    },
    headersText: function () {
      return {
        nombreEtapa: this.searchData.nombreEtapa.text,
        nombreNivel: this.searchData.nombreNivel.text,
        nombreArea: this.searchData.nombreArea.text,
        nombreTema: this.searchData.nombreTema.text,
      };
    },
    setData: function (value, target) {
      this.searchData[target] = value;
    },

    async handleData() {
      this.eventHub.$emit("reset-checkboxes");
      return await Promise.all([
        this.getPreguntasById(),
        this.getEventHeaders(),
      ]);
    },
    async getEventHeaders() {
      try {
        let codigoEvento = this.searchData.codigo;
        if (codigoEvento !== undefined || codigoEvento !== "") {
          api
            .getEventoById(codigoEvento)
            .then((response) => {
              if (response.status === 200 && response.data.length > 0) {
                this.eventHeaders = response.data[0];
                this.$emit("header-data", this.eventHeaders);
              }
            })
            .catch((error) => {
              console.error(error);
            });
        } else {
          throw "Código es undefined o null";
        }
      } catch (e) {
        console.error(e);
      }
    },
    //TODO: Esta función habría que refactorizarla
    saveFilteredData() {
      let opciones = this.valoresFiltrados();
      let datos = [];

      if (opciones.length === 1) {
        api
          .getEventoByOneEntrie(opciones[0].nombre, opciones[0].value)
          .then((response) => {
            if (response.status === 200 && response.data.length > 0) {
              return response.data;
            }
            throw "No se han encontrado datos";
          })
          .then((data) => {
            data.forEach((element) => {
              api.getPreguntas(element.CodEventos).then((response) => {
                response.data.forEach((pregunta) => {
                  datos.push(pregunta);
                });
              });
            });
            this.$emit("header-data", this.headersText());
            this.$emit("data", datos);
          })
          .catch((error) => {
            this.$emit("data", { msg: error });
          });
        return;
      }

      if (opciones.length === 2) {
        api
          .getEventoByTwoEntries(
            opciones[0].nombre,
            opciones[1].nombre,
            opciones[0].value,
            opciones[1].value
          )
          .then((response) => {
            if (response.status === 200 && response.data.length > 0) {
              return response.data;
            }
            throw "No se han encontrado datos";
          })
          .then((data) => {
            data.forEach((element) => {
              // TODO: Este nombre (codeventos) debería cambiarse en la BDD a otro más congruente con los demás
              api.getPreguntas(element.codeventos).then((response) => {
                response.data.forEach((pregunta) => {
                  datos.push(pregunta);
                });
              });
            });
            this.$emit("header-data", this.headersText());
            this.$emit("data", datos);
          })
          .catch((error) => {
            this.$emit("data", { msg: error });
          });
        return;
      }

      if (opciones.length === 3) {
        api
          .getEventoByTwoEntries(
            opciones[0].nombre,
            opciones[1].nombre,
            opciones[2].nombre,
            opciones[0].value,
            opciones[1].value,
            opciones[2].value
          )
          .then((response) => {
            if (response.status === 200 && response.data.length > 0) {
              return response.data;
            }
            throw "No se han encontrado datos";
          })
          .then((data) => {
            console.log("Entra en then");
            data.forEach((element) => {
              api.getPreguntas(element.codeventos).then((response) => {
                response.data.forEach((pregunta) => {
                  datos.push(pregunta);
                });
              });
            });
            this.$emit("header-data", this.headersText());
            this.$emit("data", datos);
          })

          .catch((error) => {
            this.$emit("data", { msg: error });
          });
        return;
      }

      if (opciones.length === 4) {
        api
          .getEventoByFourEntries(
            opciones[2].value,
            opciones[1].value,
            opciones[0].value,
            opciones[3].value
          )
          .then((response) => {
            if (response.status === 200 && response.data.length > 0) {
              return response.data;
            }
            throw "No se han encontrado datos";
          })
          .then((data) => {
            data.forEach((element) => {
              api.getPreguntas(element.codeventos).then((response) => {
                response.data.forEach((pregunta) => {
                  datos.push(pregunta);
                });
              });
            });
            this.$emit("header-data", this.headersText());
            this.$emit("data", datos);
          })
          .catch((error) => {
            this.$emit("data", { msg: error });
          });
        return;
      }
    },
    async getPreguntasById() {
      try {
        let codigoEvento = this.searchData.codigo;

        if (codigoEvento !== undefined && codigoEvento !== "") {
          api.getPreguntas(codigoEvento).then((response) => {
            if (response.status === 200 && response.data.length > 0) {
              this.$emit("data", response.data);
            }
          });
        } else {
          this.$emit("data", { msg: "Código no es válido" });
          return;
        }
      } catch (error) {
        console.error(error);
      }
    },
    resetInputs() {
      this.$refs["etapa"].searchTerm = "";
      this.$refs["nivel"].searchTerm = "";
      this.$refs["area"].searchTerm = "";
      this.$refs["tema"].searchTerm = "";
      this.searchData.nombreEtapa = "";
      this.searchData.nombreNivel = "";
      this.searchData.nombreArea = "";
      this.searchData.nombreTema = "";
      this.searchData.codigo = "";
    },
    cerrarFiltros() {
      this.$emit("cerrar-filtros");
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
