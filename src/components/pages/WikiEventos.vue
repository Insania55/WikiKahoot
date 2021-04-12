<template>
  <div class="wiki-eventos">
    <div class="filtros"></div>

    <table class="datagrid">
      <thead class="datagrid-header">
        <tr>
          <th><input type="checkbox" @click="seleccionarTodos" /></th>

          <th v-for="(header, index) in camposHeader" :key="index">
            {{ header }}
          </th>
        </tr>
      </thead>

      <tr
        class="evento"
        v-for="(evento, index) in bddEventos"
        :id="'row' + index"
        :key="index"
      >
        <!-- <Evento
            :codigo="evento.codigo"
            :area="evento.area"
            :etapa="evento.etapa"
            :nivel="evento.nivel"
            :tema="evento.tema"
          ></Evento> -->
        <td><input type="checkbox" /></td>
        <td>{{ evento.area }}</td>
        <td>{{ evento.etapa }}</td>
        <td>{{ evento.nivel }}</td>
        <td>{{ evento.tema }}</td>
        <td>{{ evento.codigo }}</td>
      </tr>
      <button class="datagrid-button">Descargar selección</button>
    </table>
  </div>
</template>

<script>
import Evento from '../Evento.vue';
import Preguntas from '../Preguntas.vue';

export default {
  name: 'WikiEventos',
  data() {
    return {
      camposHeader: ['Area', 'Etapa', 'Nivel', 'Tema', 'Codigo'],
      eventos: [],
      bddEventos: [
        {
          codigo: 0,
          area: 'anime',
          etapa: 'none',
          nivel: 'begginer',
          tema: 'shonen',
          fecha: new Date().toLocaleString,
          revisado: false,
        },
        {
          codigo: 1,
          area: 'anime',
          etapa: 'none',
          nivel: 'advanced',
          tema: 'misterio',
          fecha: new Date().toLocaleString,
          revisado: false,
        },
      ],
    };
  },
  components: {
    Evento,
    Preguntas,
  },

  methods: {
    crearEvento() {},

    seleccionarTodos() {
      let checkboxes = document.querySelectorAll('input[type=checkbox');
      let allSelected = checkboxes[0].checked === true;

      if (allSelected) {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = true;
        });
      } else {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
      }
    },
  },
};
</script>

<style lang="scss">
.datagrid {
  border: 2px solid black;

  .datagrid-header th {
    border-bottom: 2px solid salmon;
    background: #ffd;
  }

  .evento {
    color: seagreen;
  }
}
</style>
