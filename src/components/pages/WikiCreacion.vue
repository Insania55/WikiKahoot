<template>
  <div class="wiki-creacion-page">
    <main class="main-container">
      <div class="create-event-container">
        <h2>Crea un nuevo evento</h2>
        <form @submit.prevent>
          <div class="form-option">
            <AppSelect
              ref="etapa"
              label="Etapa"
              :options="this.$store.state.optionsEtapa"
              @input="consolear"
              @selected-value="setData($event, 'etapa')"
              placeholder="Etapa educativa. si procede"
            ></AppSelect>

            <i
              @click="newEtapa.isAdded = !newEtapa.isAdded"
              class="far fa-plus-square"
            ></i>
          </div>
          <transition name="fade">
            <div v-if="newEtapa.isAdded" class="new-field">
              <input
                placeholder="Añade una nueva etapa..."
                v-model="newEtapa.value"
                type="text"
              />
              <i @click="crearEtapa" class="far fa-save"></i>
            </div>
          </transition>

          <div class="form-option">
            <AppSelect
              ref="nivel"
              label="Nivel"
              :options="this.$store.state.optionsNivel"
              @input="consolear"
              @selected-value="setData($event, 'nivel')"
              placeholder="Nivel de complejidad"
            ></AppSelect>
            <i
              @click="newNivel.isAdded = !newNivel.isAdded"
              class="far fa-plus-square"
            ></i>
          </div>
          <transition name="fade">
            <div v-if="newNivel.isAdded" class="new-field">
              <input
                placeholder="Añade un nuevo nivel..."
                v-model="newNivel.value"
                type="text"
              />
              <i @click="crearNivel" class="far fa-save"></i>
            </div>
          </transition>

          <div class="form-option">
            <AppSelect
              ref="area"
              label="Área"
              :options="this.$store.state.optionsArea"
              @input="setData($event, 'area')"
              @selected-value="setData($event, 'area')"
              placeholder="Área temática general"
            ></AppSelect>
            <i
              @click="newArea.isAdded = !newArea.isAdded"
              class="far fa-plus-square"
            ></i>
          </div>
          <transition name="fade">
            <div v-if="newArea.isAdded" class="new-field">
              <input
                placeholder="Añade una nueva area..."
                v-model="newArea.value"
                type="text"
              />
              <i @click="crearArea" class="far fa-save"></i>
            </div>
          </transition>

          <div class="form-option">
            <AppSelect
              ref="tema"
              label="Tema"
              :options="this.$store.state.optionsTema"
              @selected-value="setData($event, 'tema')"
              @input="consolear"
              :placeholder="
                !isTemaCargado
                  ? 'Selecciona primero un área'
                  : 'Tema concreto de la pregunta'
              "
              :disabled="!isTemaCargado"
            ></AppSelect>
            <i
              @click="newTema.isAdded = !newTema.isAdded"
              class="far fa-plus-square"
            ></i>
          </div>
          <transition name="fade">
            <div v-if="newTema.isAdded" class="new-field">
              <input
                placeholder="Añade un nuevo tema..."
                v-model="newTema.value"
                type="text"
              />
              <i @click="crearTema" class="far fa-save"></i>
            </div>
          </transition>

          <!-- @click="descargarExcel" -->
          <AppButton @click="crearEvento" green>Crear evento</AppButton>
        </form>
      </div>
      <span class="separator">O</span>
      <div class="add-event-container">
        <h2>Añade preguntas a un evento existente</h2>

        <div class="input-container">
          <label class="input" for="codigo">
            <input
              v-model="codigoEvento"
              name="codigo"
              type="text"
              placeholder="12345..."
            />
            <span class="input-label">Código de evento</span>
          </label>
        </div>

        <AppButton @click="buscarEvento" green>Buscar evento</AppButton>
      </div>
    </main>

    <div class="form-container">
      <h2>Añadir preguntas</h2>
      <form @submit.prevent="anyadirPregunta">
        <div class="input-container w-100">
          <label class="input" for="enunciado">
            <input
              v-model="nuevaPregunta.enunciado"
              pattern="^{1,120}$"
              required
              name="enunciado"
              type="text"
              placeholder="El enunciado de la pregunta"
            />
            <span class="input-label">Enunciado*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <label class="input" for="r1">
            <input
              v-model="nuevaPregunta.r1"
              pattern="^{1,75}$"
              required
              name="r1"
              type="text"
              placeholder=""
            />
            <span class="input-label">Respuesta 1*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <label class="input" for="r2">
            <input
              v-model="nuevaPregunta.r2"
              pattern="^{1,75}$"
              required
              name="r2"
              type="text"
              placeholder=""
            />
            <span class="input-label">Respuesta 2*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <label class="input" for="r3">
            <input
              v-model="nuevaPregunta.r3"
              pattern="^{1,75}$"
              required
              name="r3"
              type="text"
              placeholder=""
            />
            <span class="input-label">Respuesta 3</span>
          </label>
        </div>
        <div class="input-container w-50">
          <label class="input" for="r4">
            <input
              v-model="nuevaPregunta.r4"
              pattern="^{1,75}$"
              name="r4"
              type="text"
              placeholder=""
            />
            <span class="input-label">Respuesta 4</span>
          </label>
        </div>
        <div class="input-container w-50">
          <!-- //TODO: Troquelar espacios antes de enviar-->
          <label class="input" for="respuestaCorrecta">
            <input
              v-model="nuevaPregunta.respuestaCorrecta"
              name="respuestaCorrecta"
              type="text"
              placeholder="1, 2.."
            />
            <span class="input-label">Respuesta(s) correcta(s)*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <!-- //TODO: Que solo se permita introducir valores dentro de array de posibilidades-->
          <!-- //TODO: Parsear a número antes de enviar -->

          <label class="input" for="tiempoLimite">
            <input
              list="tiempo"
              name="myBrowser"
              placeholder="5, 10, 20, 30, 60, 90, 120, 240"
            />
            <datalist id="tiempo">
              <option value="5"></option>
              <option value="10"></option>
              <option value="20"></option>
              <option value="30"></option>
              <option value="60"></option>
              <option value="90"></option>
              <option value="120"></option>
              <option value="240"></option>
            </datalist>

            <!-- <input
              v-model="nuevaPregunta.tiempoLimite"
              required
              name="tiempoLimite"
              type="text"
              placeholder=""
            /> -->
            <span class="input-label">Tiempo límite*</span>
          </label>
        </div>

        <div class="input-container w-100">
          <label class="input" for="imgLink">
            <input
              v-model="nuevaPregunta.imgLink"
              required
              name="imgLink"
              type="text"
            />
            <span class="input-label">Link hacia la imagen</span>
          </label>
        </div>
        <div class="button-container">
          <button @click.prevent="saveData" class="filter-option-button">
            Buscar
          </button>
          <button type="reset" class="filter-option-button">Borrar</button>
        </div>
      </form>
    </div>
    <span><small>Los campos con (*) son obligatorios</small> </span>
    <AppPaginatedTable
      v-if="eventoCargado"
      :data="preguntasAnyadidas"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(preguntasAnyadidas.length / itemsPerPage)"
      :total="preguntasAnyadidas.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
    >
    </AppPaginatedTable>
  </div>
</template>

<script>
import AppSelect from "../AppSelect.vue";
import AppPaginatedTable from "../AppPaginatedTable.vue";
import AppButton from "../AppButton.vue";
import * as api from "../js/api.js";

export default {
  name: "WikiCreacion",
  components: { AppSelect, AppPaginatedTable, AppButton },
  data() {
    return {
      dataToSend: {
        etapa: "",
        nivel: "",
        area: "",
        tema: "",
      },
      newEtapa: { isAdded: false, value: "" },
      newNivel: { isAdded: false, value: "" },
      newArea: { isAdded: false, value: "" },
      newTema: { isAdded: false, value: "" },
      codigoEvento: 0,
      preguntasAnyadidas: [],
      nuevaPregunta: {
        enunciado: "",
        r1: "",
        r2: "",
        r3: "",
        r4: "",
        respuestaCorrecta: "",
        tiempoLimite: "",
        imgLink: "",
      },
      eventoCargado: true,
      currentPage: 1,
      itemsPerPage: 5,
      camposHeader: [
        "Enunciado",
        "Respuesta 1",
        "Respuesta 2",
        "Respuesta 3",
        "Respuesta 4",
        "Respuesta correcta",
        "Tiempo límite",
        "Enlace a imagen",
      ],
      optionsTema: [],
    };
  },
  computed: {
    isTemaCargado: function () {
      return this.dataToSend.area !== "" && this.dataToSend.area !== undefined;
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
  watch: {
    "dataToSend.area": function () {
      if (this.dataToSend.area !== undefined) {
        this.$store.dispatch("loadTemas", this.dataToSend.area.value);
      }
    },
  },
  methods: {
    consolear(ev) {
      console.log(ev);
    },
    setData(data, target) {
      this.dataToSend[target] = data;
    },
    crearEvento() {
      let fecha = new Date().toISOString().slice(0, 10);
      // * comprobamos que ningún campo esté vacío antes de enviar
      if (!Object.values(this.dataToSend).some((el) => el === "")) {
        api
          .createEvento(
            this.dataToSend.etapa.value,
            this.dataToSend.nivel.value,
            this.dataToSend.area.value,
            this.dataToSend.tema.value,
            fecha
          )
          .then((response) => response.data)
          .then((data) => console.log(data))
          .catch((error) => console.log(error));
      } else {
        console.log("No ha sido posible enviar. Algún campo vacío");
      }

      console.log("Se ha intentado crear el evento", this.dataToSend);
    },
    anyadirEvento(
      enunciado,
      r1,
      r2,
      r3,
      r4,
      respuestaCorrecta,
      timeLimit,
      imgLink
    ) {
      this.preguntasAnyadidas.push({
        enunciado,
        r1,
        r2,
        r3,
        r4,
        respuestaCorrecta,
        timeLimit,
        imgLink,
      });
    },
    crearEtapa() {
      let etapa = {
        Nombre: this.newEtapa.value,
      };

      try {
        api
          .createEtapa(etapa)
          .then((response) => response.data)
          .then((data) => {
            console.log(data.status);
          }).catch;
      } catch (e) {
        console.log(e);
      }
      this.newEtapa.isAdded = !this.newEtapa.isAdded;
      this.$refs.etapa.searchTerm = this.newEtapa.value;
    },
    crearNivel() {
      let nivel = {
        Nombre: this.newNivel.value,
      };

      try {
        api
          .createNivel(nivel)
          .then((response) => response.data)
          .then((data) => {
            console.log(data.status);
          }).catch;
      } catch (e) {
        console.log(e);
      }
      this.newNivel.isAdded = !this.newNivel.isAdded;
      this.$refs.nivel.searchTerm = this.newNivel.value;
    },
    crearArea() {
      let area = {
        Nombre: this.newArea.value,
      };

      try {
        api
          .createArea(area)
          .then((response) => response.data)
          .then((data) => {
            console.log(data.status);
          }).catch;
      } catch (e) {
        console.log(e);
      }
      this.newArea.isAdded = !this.newArea.isAdded;
      this.$refs.area.searchTerm = this.newArea.value;
    },
    crearTema() {
      let tema = {
        Nombre: this.newTema.value,
        FK_IdArea: this.dataToSend.area.value,
      };

      try {
        api
          .createTema(tema)
          .then((response) => response.data)
          .then((data) => {
            console.log(data.status);
          }).catch;
      } catch (e) {
        console.log(e);
      }
      this.newTema.isAdded = !this.newTema.isAdded;
      this.$refs.tema.searchTerm = this.newTema.value;
    },

    anyadirPregunta() {},

    buscarEvento() {
      // TODO: Buscar evento en la base de datos cuando sea posible
      console.log("Se ha intentado buscar un evento");
    },
    onPageChange() {
      console.log("Respuesta del paginador");
    },
  },
};
</script>

<style lang="scss" scoped>
$--color-accent: goldenrod;
$--color-preguntas-container: #2a2a3d;
$--color-preguntas-text: #eee;

.main-container {
  display: flex;
  flex-flow: row nowrap;
  flex: 0 0 30vw;
  justify-content: space-evenly;
  margin: 2em 0;

  h2 {
    // color: $--color-preguntas-text;
    margin-bottom: 0.7rem;
    border-bottom: 2px groove black;
  }

  > div {
    background: inherit;
    color: #211;
    border: 3px solid black;
    border-radius: 5px;
    box-shadow: 0 0 2px;
  }
}

.create-event-container {
  padding: 1rem 1.5rem;

  .app-select {
    margin-top: 1.5em;

    .label {
      width: 200px;
    }
  }

  .form-option {
    display: flex;
    flex-flow: row wrap;
    align-items: flex-end;

    i {
      margin-left: 0.5em;
      cursor: pointer;
      font-size: 1.4rem;
      &:active {
        transition: all 0.1ms ease-in-out;
        transform: scale(0.9);
        -webkit-transform: scale(0.9);
        -ms-transform: scale(0.9);
      }
    }
  }

  .new-field {
    margin-left: 3em;
    margin-top: 1rem;

    input {
      border: none;
      border-bottom: 1px solid black;
      padding: 0.2rem 0.5rem 0.2rem 0.3rem;
      min-width: 200px;
    }

    i {
      margin-left: 0.5em;
      cursor: pointer;
      font-size: 1.2rem;
      &:active {
        transition: all 0.1ms ease-in-out;
        transform: scale(0.9);
        -webkit-transform: scale(0.9);
        -ms-transform: scale(0.9);
      }
    }
  }

  .app-button {
    margin-top: 1.6rem;
  }
}

.add-event-container {
  padding: 0.8rem 1.5rem;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;

  > *:not(:first-child) {
    padding-top: 1em;
  }

  // .input-label {
  // }
}

.separator {
  display: flex;
  align-items: center;
}

.form-container {
  max-width: 75vw;
  width: 100%;
  padding: 1.8rem 2rem;
  background: $--color-preguntas-container;
  border-radius: 5px;
  margin: 0 auto;

  h2 {
    font-size: 25px;
    position: relative;
    color: #eee;

    &::before {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      height: 2px;
      width: 30px;
      // width: 230px;
      background: linear-gradient(136deg, lightpink, violet);
    }
  }

  form {
    display: flex;
    flex-flow: row wrap;
  }

  .input-container {
    padding: 2em;

    .input {
      position: relative;

      > input {
        display: block;
        width: 100%;
        border: 3px solid currentColor;
        padding: 1rem 0.5rem;
        color: $--color-preguntas-text;
        background: transparent;
        border-radius: 4px;

        &:focus,
        &:not(:placeholder-shown) {
          & + .input-label {
            transform: translate(-0.5rem, -65%) scale(0.8);
            color: $--color-accent;
            transition-duration: 0.2s;
          }
        }
      }
    }

    .input-label {
      color: $--color-preguntas-text;
      position: absolute;
      left: 0;
      top: 0;
      padding: 6px 4px;
      margin: 6px 8px;
      background: $--color-preguntas-container;
      white-space: nowrap;
      transform: translate(0, 0);
      transform-origin: 0, 0;
      transition: transform 120ms ease-in;
      font-weight: bold;
      line-height: 1.2;
    }
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  // transition: all 0.4s ease-in;
}

.w-100 {
  width: 100%;
}

.w-50 {
  width: 50%;
}
</style>
