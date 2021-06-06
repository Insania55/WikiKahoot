<template>
  <div class="wiki-creacion-page">
    <main class="main-container">
      <!-- // ? Contenedor para crear un nuevo evento -->
      <div class="helper-container">
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
                placeholder="Elegir etapa"
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
                placeholder="Elegir nivel"
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
                placeholder="Elegir área"
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
                  !isTemaCargado ? 'Selecciona primero un área' : 'Elegir tema'
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
            <AppButton @click="crearEvento" normal>Crear evento</AppButton>
          </form>
        </div>
        <div class="help-tooltip">
          <i class="fas fa-arrow-circle-left"></i>
          <span>
            ¿No encuentras un campo específico? <strong>¡Créalo!</strong></span
          >
        </div>
      </div>

      <!-- // ? Contenedor para buscar un evento por ID -->
      <div class="add-event-container">
        <h2>Añade preguntas a un evento existente</h2>
        <div class="input-container w-100">
          <label class="input" for="codigo">
            <input
              v-model="codigoEvento"
              name="codigo"
              type="text"
              placeholder="0, 1, 2, 3, 4..."
              @keydown.enter="buscarEvento"
            />
            <span class="input-label">Código de evento</span>
          </label>
        </div>
        <AppButton @click="buscarEvento" normal>Buscar evento</AppButton>
      </div>
    </main>

    <h2 v-if="anyadirPreguntaForm" class="form-title">Formulario de adición</h2>
    <div v-if="anyadirPreguntaForm" class="form-container">
      <!-- <div>
        <span><strong>Etapa</strong> {{ eventNames.nombreEtapa }}</span>
        <span><strong>Nivel</strong> {{ eventNames.nombreNivel }}</span>
        <span><strong>Área</strong> {{ eventNames.nombreArea }}</span>
        <span><strong>Tema</strong> {{ eventNames.nombreTema }}</span>
        <span
          ><strong>Nº Preguntas</strong> {{ numeroPreguntasAsociadas }}</span
        >
      </div>
      -->
      <div class="event-names-container">
        <ul>
          <li>
            <span>Etapa</span>
            <span>{{ eventNames.nombreEtapa }}</span>
          </li>
          <li>
            <span>Área</span>
            <span>{{ eventNames.nombreArea }}</span>
          </li>
          <li>
            <span>Nivel</span>
            <span>{{ eventNames.nombreNivel }}</span>
          </li>
          <li>
            <span>Tema</span>
            <span>{{ eventNames.nombreTema }}</span>
          </li>

          <li>
            <span>Nº Preguntas</span>
            <span>{{ numeroPreguntasAsociadas }}</span>
          </li>
        </ul>
      </div>
      <div>
        <h2>Añadir preguntas</h2>
        <span
          >Código de evento
          <p>
            {{ codigoEventoNuevo !== "" ? codigoEventoNuevo : codigoEvento }}
          </p>
        </span>
      </div>
      <form @submit.prevent="anyadirPregunta">
        <div class="input-container w-100">
          <label class="input" for="Pregunta">
            <input
              v-model="nuevaPregunta.Pregunta"
              required
              name="Pregunta"
              type="text"
              placeholder="El enunciado de la pregunta"
            />
            <span class="input-label">Enunciado*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <label class="input" for="r1">
            <input
              v-model="nuevaPregunta.Respuesta1"
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
              v-model="nuevaPregunta.Respuesta2"
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
              v-model="nuevaPregunta.Respuesta3"
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
              v-model="nuevaPregunta.Respuesta4"
              name="r4"
              type="text"
              placeholder=""
            />
            <span class="input-label">Respuesta 4</span>
          </label>
        </div>
        <div class="input-container w-50">
          <!-- //TODO: Troquelar espacios antes de enviar-->
          <label class="input" for="Correcta">
            <input
              v-model="nuevaPregunta.Correcta"
              name="Correcta"
              type="text"
              placeholder="1, 2.."
            />
            <span class="input-label">Respuesta(s) correcta(s)*</span>
          </label>
        </div>
        <div class="input-container w-50">
          <!-- //TODO: Que solo se permita introducir valores dentro de array de posibilidades-->
          <!-- //TODO: Parsear a número antes de enviar -->
          <label class="input" for="Tiempo">
            <input
              v-model="nuevaPregunta.Tiempo"
              list="tiempo"
              name="Tiempo"
              placeholder="5, 10, 20, 30, 60, 90, 120, 240"
            />
            <span class="input-label">Tiempo límite*</span>
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
          </label>
        </div>

        <div class="input-container w-100">
          <label class="input" for="Imagen">
            <input
              placeholder=""
              v-model="nuevaPregunta.Imagen"
              name="Imagen"
              type="text"
            />
            <span class="input-label">Link hacia la imagen</span>
          </label>
        </div>
        <div class="required-fields-tooltip w-100">
          <small>Los campos con (*) son obligatorios</small>
        </div>

        <div class="button-container">
          <AppButton @click.prevent="anyadirPregunta" green
            >Añadir pregunta</AppButton
          >
          <AppButton @click.prevent="resetForm" normal>Borrar</AppButton>
        </div>
      </form>
    </div>

    <h2
      v-if="preguntasAnyadidas.length !== 0"
      class="preguntas-anyadidas-title"
    >
      - Preguntas añadidas al evento -
    </h2>
    <!-- // * Tabla para cargar las preguntas que se vayan añadiendo al evento  -->
    <AppPaginatedTable
      v-if="preguntasAnyadidas.length !== 0"
      :data="preguntasAnyadidas"
      :headerFields="camposHeader"
      :total-pages="Math.ceil(preguntasAnyadidas.length / itemsPerPage)"
      :total="preguntasAnyadidas.length"
      :perPage="itemsPerPage"
      :currentPage="currentPage"
      @page-changed="onPageChange"
    >
    </AppPaginatedTable>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>
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
      anyadirPreguntaForm: false,
      codigoEvento: "",
      codigoEventoNuevo: "",
      preguntasAnyadidas: [],
      eventNames: {
        nombreEtapa: "",
        nombreNivel: "",
        nombreArea: "",
        nombreTema: "",
      },
      numeroPreguntasAsociadas: "",
      nuevaPregunta: {
        Pregunta: "",
        Respuesta1: "",
        Respuesta2: "",
        Respuesta3: "",
        Respuesta4: "",
        Correcta: "",
        Tiempo: "",
        Imagen: "",
      },
      currentPage: 1,
      itemsPerPage: 20,
      camposHeader: [
        "Pregunta",
        "Respuesta 1",
        "Respuesta 2",
        "Respuesta 3",
        "Respuesta 4",
        "Respuesta correcta",
        "Tiempo límite",
        "Enlace a imagen",
      ],
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
      console.error(error);
    }
  },
  watch: {
    "dataToSend.area": function (oldVal, newVal) {
      if (this.dataToSend.area !== undefined) {
        this.$store.dispatch("loadTemas", this.dataToSend.area.value);
      }
      // * Si el área cambia y el tema ya ha sido seleccionado, se resetea el tema puesto que no tendrán correlación
      if (this.dataToSend.tema !== "" && oldVal.value !== newVal.value) {
        this.dataToSend.tema = "";
        this.$refs.tema.searchTerm = "";
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
      // * Comprobamos que ningún campo esté vacío antes de enviar
      if (!Object.values(this.dataToSend).some((el) => el === "")) {
        let fecha = new Date().toISOString().slice(0, 10);

        api
          .createEvento(
            this.dataToSend.etapa.value,
            this.dataToSend.nivel.value,
            this.dataToSend.area.value,
            this.dataToSend.tema.value,
            fecha
          )
          .then((response) => response.data)
          .then((data) => {
            this.eventNames.nombreEtapa = this.dataToSend.etapa.text;
            this.eventNames.nombreNivel = this.dataToSend.nivel.text;
            this.eventNames.nombreArea = this.dataToSend.area.text;
            this.eventNames.nombreTema = this.dataToSend.tema.text;
            this.codigoEventoNuevo = data.result.CodEvento;
            this.anyadirPreguntaForm = true;
          })
          .catch((error) => console.log(error));
      } else {
        console.log("No ha sido posible enviar. Algún campo vacío");
      }

      console.log("Se ha intentado crear el evento", this.dataToSend);
    },
    //TODO: El request al backend se debería hacer al pulsar en "Crear evento" y no al guardar
    crearEtapa() {
      if (this.newEtapa.value !== "" || this.newEtapa.value !== undefined) {
        let etapa = {
          Nombre: this.newEtapa.value,
        };
        try {
          api
            .createEtapa(etapa)
            .then((response) => response.data)
            .then((data) => {
              console.log(data);
            }).catch;
        } catch (error) {
          console.error(error);
        }
        this.newEtapa.isAdded = !this.newEtapa.isAdded;
        this.$refs.etapa.searchTerm = this.newEtapa.value;
      } else {
        console.log("Etapa está vacía");
      }
    },
    crearNivel() {
      if (this.newNivel.value !== "" || this.newNivel.value !== undefined) {
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
          console.error(e);
        }
        this.newNivel.isAdded = !this.newNivel.isAdded;
        this.$refs.nivel.searchTerm = this.newNivel.value;
      }
    },
    crearArea() {
      if (this.newArea.value !== "" || this.newArea.value !== undefined) {
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
          console.error(e);
        }
        this.newArea.isAdded = !this.newArea.isAdded;
        this.$refs.area.searchTerm = this.newArea.value;
      }
    },
    crearTema() {
      if (this.newTema.value !== "" || this.newTema.value !== undefined) {
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
          console.error(e);
        }
        this.newTema.isAdded = !this.newTema.isAdded;
        this.$refs.tema.searchTerm = this.newTema.value;
      }
    },
    anyadirPregunta() {
      try {
        let codigoEvento =
          this.codigoEventoNuevo !== ""
            ? this.codigoEventoNuevo
            : this.codigoEvento;
        codigoEvento = Number(codigoEvento);
        let fecha = new Date().toISOString().slice(0, 10);

        api
          .anyadirPregunta(
            codigoEvento,
            this.nuevaPregunta.Pregunta,
            this.nuevaPregunta.Respuesta1,
            this.nuevaPregunta.Respuesta2,
            this.nuevaPregunta.Respuesta3,
            this.nuevaPregunta.Respuesta4,
            this.nuevaPregunta.Correcta,
            this.nuevaPregunta.Limite,
            this.nuevaPregunta.Imagen,
            fecha
          )
          .then((response) => {
            console.log(response);
            if (response.status === 200) {
              this.preguntasAnyadidas.push(this.nuevaPregunta);
              this.resetForm();
            }
          });
      } catch (error) {
        console.log(error);
      }
    },
    buscarEvento() {
      if (this.codigoEvento === "") {
        //TODO: Cambiar a notificación para el usuario
        console.log("Código vacío");
        return;
      }
      if (Number(this.codigoEvento) === NaN) {
        console.log("El código de evento pasado no es un número");
        return;
      }

      try {
        // * Reseteamos el formulario y las preguntas añadidas, en caso de que se haya intentado buscar un evento nuevo tras ya haber buscado uno
        this.resetForm();
        this.preguntasAnyadidas = [];
        let eventID = Number(this.codigoEvento);

        api
          .getEventoById(eventID)
          .then((response) => response.data)
          .then((data) => {
            this.eventNames.nombreEtapa = data[0].nombreEtapa;
            this.eventNames.nombreNivel = data[0].nombreNivel;
            this.eventNames.nombreArea = data[0].nombreArea;
            this.eventNames.nombreTema = data[0].nombreTema;
            this.anyadirPreguntaForm = true;
          });

        api
          .getPreguntas(eventID)
          .then((response) => response.data)
          .then((data) => {
            this.numeroPreguntasAsociadas = data.length;
          });
      } catch (error) {
        console.error(error);
      }
      console.log("Se ha intentado buscar un evento");
    },
    resetForm() {
      this.nuevaPregunta = {
        Pregunta: "",
        Respuesta1: "",
        Respuesta2: "",
        Respuesta3: "",
        Respuesta4: "",
        Correcta: "",
        Tiempo: "",
        Imagen: "",
      };
    },
    onPageChange() {
      console.log("Respuesta del paginador");
    },
  },
};
</script>

<style lang="scss" scoped>
$--color-accent: #fab700;
$--color-preguntas-container: #431b93;
$--color-preguntas-text: #eee;
$--color-create-event-container: #069415;
$--color-add-event-container: #1989d2;

.main-container {
  display: flex;
  flex-flow: row nowrap;
  flex: 0 0 30vw;
  justify-content: space-evenly;
  margin: 2em 0;

  h2 {
    margin-bottom: 0.7rem;
  }

  > .add-event-container,
  .create-event-container {
    color: #211;
    border-radius: 5px;
    box-shadow: 2px 2px 3px black;
  }
}

.helper-container {
  display: flex;

  .help-tooltip {
    max-height: 1em;
    margin-top: 4.8rem;
    margin-left: 0.6rem;
    font-family: "open sans";

    i {
      font-size: 1.1rem;
      color: $--color-accent;
    }
  }
}

.create-event-container {
  padding: 1rem 1.5rem;
  position: relative;
  background: $--color-create-event-container;

  .form-option {
    display: flex;
    flex-flow: row wrap;
    align-items: flex-end;
    margin-top: 1.5em;

    i {
      margin-left: 0.5em;
      margin-bottom: 0.2em;
      cursor: pointer;
      font-size: 1.4rem;

      &:active {
        transition: all 0.1ms ease-in-out;
        transform: scale(0.9);
        -webkit-transform: scale(0.9);
        -ms-transform: scale(0.9);
      }

      &:hover {
        color: $--color-accent;
      }
    }
  }

  .new-field {
    margin-left: 3.5rem;
    margin-top: 1rem;
    display: flex;
    align-items: center;

    input {
      border: none;
      // border-bottom: 1px solid black;
      border-radius: 4px;
      padding: 0.3rem 0.5rem 0.3rem 0.3rem;
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
      &:hover {
        color: $--color-accent;
      }
    }
  }

  .app-button {
    margin-top: 1.6rem;
    text-align: center;
  }
}

.add-event-container {
  padding: 0.8rem 1.5rem;
  position: relative;
  display: flex;
  flex-flow: column nowrap;
  align-items: center;
  background: $--color-add-event-container;

  .input-container {
    .input > input {
      color: black;
      border-color: inherit;
    }
    .input-label {
      color: black;
      background: $--color-add-event-container;
    }
  }
}

.preguntas-anyadidas-title {
  text-align: center;
  margin-bottom: 1rem;
  font-size: 1.7rem;
}

.form-title {
  text-align: center;
  font-size: 1.9rem;
  margin-top: 3rem;
}

.form-container {
  width: 100%;
  max-width: 70vw;
  position: relative;
  background: $--color-preguntas-container;
  margin: 1rem auto 2rem auto;
  padding: 1.5rem;
  padding-bottom: 0.5rem;
  border: 2px solid black;
  border-radius: 5px;

  form {
    display: flex;
    flex-flow: row wrap;
  }

  // * Recuadro para mostrar el nombre de las columnas (etapa, nivel..) en el formulario
  // > div:first-child {
  //   display: flex;
  //   width: 70%;
  //   justify-content: space-around;
  //   margin: 0 auto;
  //   margin-bottom: 0.5rem;
  //   padding: 0.8rem;
  //   color: $--color-preguntas-container;
  //   // border-radius: 5px;
  //   // border-bottom: 1px solid white;

  //   > span {
  //     color: white;
  //     // font-weight: bold;
  //     strong {
  //       // font-style: none;
  //       color: $--color-preguntas-container;
  //       background: white;
  //       border-radius: 50%;
  //       padding: 0.4rem;
  //       margin-right: 0.2rem;
  //     }
  //   }
  // }

  // * Span para mostrar el código de evento
  > div:nth-child(2) {
    display: flex;
    flex-wrap: wrap;

    span {
      margin-left: auto;
      color: #eee;
      font-weight: bold;
      display: flex;
      align-items: center;

      p {
        background: white;
        color: $--color-preguntas-container;
        border-radius: 80%;
        padding: 5px;
        text-align: center;
        width: 45px;
        margin-left: 4px;
      }
    }
  }

  .event-names-container {
    display: flex;
    text-align: center;
    justify-content: center;
    flex-direction: column;

    h2 {
      margin-bottom: 1rem;
    }

    ul {
      background-color: rgba(255, 255, 255, 0.9);
      width: 40vw;
      font-family: "Open sans";
      display: flex;
      align-items: center;
      justify-content: space-around;
      border: 1px solid black;
      border-radius: 5px;
      margin: 0 auto;

      li {
        display: flex;
        flex-direction: column;
        list-style-type: none;
        margin: 0.6rem;
      }
    }

    span:first-child {
      font-weight: bolder;
      font-size: 18px;
      padding-top: 5px;
      text-decoration: underline;
      margin-bottom: 3px;
      color: #2c3e50;
    }
  }

  h2 {
    font-size: 26px;
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
  .required-fields-tooltip {
    height: 40px;
    small {
      color: white;
      font-weight: bold;
      margin-left: 2rem;
    }
  }

  .button-container {
    margin: 0.8rem 0 2rem 1.8rem;
  }
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
      font-size: 0.9rem;
      outline-style: none;

      &:focus,
      &:not(:placeholder-shown) {
        & + .input-label {
          transform: translate(-0.5rem, -65%) scale(0.8);
          color: $--color-accent;
          transition-duration: 0.2s;
        }
      }

      &::placeholder {
        font-family: "open sans";
      }
    }
  }

  .input-label {
    color: $--color-preguntas-text;
    position: absolute;
    left: 0;
    top: 0;
    padding: 2px 4px;
    margin: 6px 8px;
    background: $--color-preguntas-container;
    white-space: nowrap;
    transform: translate(0, 0);
    -webkit-transform-origin: 0;
    transform-origin: 0, 0;
    transition: transform 120ms ease-in;
    font-weight: bold;
    line-height: 1.2;
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
