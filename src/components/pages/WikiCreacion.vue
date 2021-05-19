<template>
  <div class="wiki-creacion-page">
    <main class="main-container">
      <div class="create-event-container">
        <h2>Crea un nuevo evento</h2>
        <form @submit.prevent>
          <AppSelect
            label="Etapa"
            :options="optionsEtapa"
            @input="consolear"
            @selected-value="setData($event, 'etapa')"
            placeholder="Etapa educativa. si procede"
          ></AppSelect>
          <AppSelect
            label="Nivel"
            :options="optionsNivel"
            @input="consolear"
            @selected-value="setData($event, 'nivel')"
            placeholder="Nivel de complejidad"
          ></AppSelect>
          <AppSelect
            label="Área"
            :options="optionsArea"
            @input="consolear"
            @selected-value="setData($event, 'area')"
            placeholder="Área temática general"
          ></AppSelect>
          <AppSelect
            label="Tema"
            :options="optionsTema"
            @selected-value="setData($event, 'tema')"
            @input="consolear"
            placeholder="Tema concreto de la pregunta"
          ></AppSelect>
          <button @click="crearEvento">Crear evento</button>
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
        <button @click="buscarEvento">Buscar evento</button>
      </div>
    </main>

    <div class="form-container">
      <h2>Añadir preguntas</h2>
      <form @submit.prevent="anyadirPregunta">
        <div class="input-container w-100">
          <label class="input" for="enunciado">
            <input
              v-model="nuevaPregunta.enunciado"
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
              placeholder=""
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

export default {
  name: "WikiCreacion",
  data() {
    return {
      dataToSend: {
        etapa: "",
        nivel: "",
        area: "",
        tema: "",
      },
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
  components: { AppSelect, AppPaginatedTable },
  methods: {
    setData(data, target) {
      console.log("Seteando data: " + data);
      this.dataToSend[target] = data;
    },
    crearEvento() {
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
    anyadirPregunta() {},

    buscarEvento() {
      // TODO: Buscar evento en la base de datos cuando sea posible
      console.log("Se ha intentado buscar un evento");
    },
    consolear(ev) {
      console.log("Consoleando", ev);
    },
    onPageChange() {
      console.log("Respuesta del paginador");
    },
  },
};
</script>

<style lang="scss" scoped>
$--color-accent: goldenrod;
$--color-preguntas-container: #421b93;
$--color-preguntas-text: #eee;

.main-container {
  display: flex;
  flex-flow: row nowrap;
  flex: 0 0 30vw;
  justify-content: space-evenly;
  background: #eee;
}

.create-event-container {
  background: lightpink;
}

.add-event-container {
  background: lightblue;
}

.separator {
  display: flex;
  align-items: center;
}

.form-container {
  max-width: 700px;
  width: 100%;
  padding: 1.8rem 2rem;
  background: $--color-preguntas-container;
  border-radius: 5px;
  // margin: 0 auto;

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

.w-100 {
  width: 100%;
}

.w-50 {
  width: 50%;
}
</style>
