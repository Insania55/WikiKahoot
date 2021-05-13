<template>
  <div class="app-select">
    <label class="label"
      >{{ label }}
      <input
        @input="onChange"
        @keydown.up="onArrowUp"
        @keydown.down="onArrowDown(results)"
        @keydown.enter.prevent="onEnter(results)"
        v-model="searchTerm"
        @click="onInputClick"
        class="chosen-value"
        type="text"
        :placeholder="placeholder"
        :disabled="disabled"
      />
    </label>
    <ul class="value-list open" v-if="optionsDropdown">
      <li v-if="isLoading" class="loading">Cargando resultados..</li>
      <li
        v-else-if="isInputClicked"
        v-for="(option, index) in options"
        :key="index"
        @click="setResult(option)"
        :class="{ 'is-active': index === currentPointer }"
      >
        {{ option.text }}
      </li>
      <li
        v-else
        v-for="(result, index) in results"
        :key="index"
        @click="setResult(result)"
        :class="{ 'is-active': index === currentPointer }"
      >
        {{ result.name }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "AppSelect",
  props: {
    options: {
      type: Array,
      required: false,
      default: () => [],
    },
    label: { type: String, required: false },
    placeholder: { type: String, required: false },
    disabled: { type: Boolean, required: false, default: false },
    isAsync: { type: Boolean, required: false, default: false },
  },
  data() {
    return {
      searchTerm: "",
      results: [],
      optionsDropdown: false,
      totalWidth: 0,
      currentPointer: -1,
      isLoading: false,
      isInputClicked: false,
    };
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  destroyed() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  watch: {
    options: function (val, oldVal) {
      if (this.isAsync) {
        this.results = val;
        this.optionsDropdown = true;
        this.isLoading = false;
      }
    },
  },
  methods: {
    filterResults() {
      this.results = this.options.filter(
        (item) =>
          item.value.toLowerCase().indexOf(this.searchTerm.toLowerCase()) > -1
      );
    },
    setResult(result) {
      this.searchTerm = result.text;
      this.optionsDropdown = false;
      this.$emit("selected-value", result.text);
    },
    onChange() {
      //TODO: Esto no debería ser así, emite demasiado. Quizá un debounce?
      this.$emit("input", this.searchTerm);
      if (this.isAsync) {
        this.isLoading = true;
      } else {
        // ? Si el input ha sido clickado y no hay resultados, esto hará que no se muestre ningún desplegable
        this.isInputClicked = false;
        this.filterResults();
        this.optionsDropdown = true;
      }
    },
    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.currentPointer = -1;
        this.optionsDropdown = false;
      }
    },
    onInputClick() {
      this.optionsDropdown = !this.optionsDropdown;
      this.isInputClicked = true;
      const viewportOffset = this.getOffsetScreen(this.$el);
      this.totalWidth = document.body.clientWidth - viewportOffset.left;
    },
    getOffsetScreen(_el) {
      const target = _el;
      const targetWidth = target.offsetWidth;
      const targetHeight = target.offsetHeight;
      let gleft = 0;
      let gtop = 0;
      let rect = {};

      // eslint-disable-next-line consistent-return
      function moonwalk(_parent) {
        if (_parent) {
          gleft += _parent.offsetLeft;
          gtop += _parent.offsetTop;
          moonwalk(_parent.offsetParent);
        } else {
          rect = {
            top: target.offsetTop + gtop,
            left: target.offsetLeft + gleft,
            bottom: target.offsetTop + gtop + targetHeight,
            right: target.offsetLeft + gleft + targetWidth,
          };
          return rect;
        }
      }
      moonwalk(target.offsetParent);
      return rect;
    },
    onArrowUp() {
      if (this.currentPointer > 0) {
        this.currentPointer = this.currentPointer - 1;
      }
    },
    onArrowDown(array) {
      if (array.length === 0) array = this.options;
      if (this.currentPointer < array.length - 1) {
        this.currentPointer = this.currentPointer + 1;
      }
    },
    onEnter(array) {
      // ? Si han hecho enter pero no han seleccionado ningún valor, se devuelve
      if (this.currentPointer === -1) return;

      // ? Si no han pasado un array por parámetro, es porque se ha abierto el desplegable mediante click y utilizamos las options por defecto
      if (array.length === 0) array = this.options;
      this.searchTerm = array[this.currentPointer].name;
      this.currentPointer = -1;
      this.optionsDropdown = false;
      this.$emit("selected-value", this.searchTerm);
    },
  },
};
</script>

//TODO: Refactorizar a código SCSS
<style lang="scss" scoped>
$select-width: 400px;
.app-select {
  .value-list {
    position: absolute;
    // top: 0;
    // left: 0;
    z-index: 999;
    width: 100%;
  }

  .label {
    font-weight: 600;
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    width: $select-width;
    line-height: 28px;
    margin-left: 3rem;

    input {
      height: 30px;
      flex: 0 0 $select-width;
      margin-left: 10px;
    }
  }

  .chosen-value {
    font-family: "Ek Mukta";
    font-weight: 600;
    font-size: 1rem;
    // background-color: #fafcfd;
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
    max-width: $select-width;
  }
  .chosen-value:focus::-webkit-input-placeholder,
  .chosen-value.open::-webkit-input-placeholder {
    color: #000;
  }

  .value-list {
    list-style: none;
    // margin-top: 2rem;
    box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    max-height: 0;
    max-width: 401px;
    -webkit-transition: 0.3s ease-in-out;
    transition: 0.3s ease-in-out;
    border: 1px solid black;
  }
  .value-list.open {
    margin-left: 2.95em;
    max-height: 320px;
    overflow: auto;
    overflow-x: hidden;
  }
  .value-list li {
    position: relative;
    height: 4rem;
    width: 400px;
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
  .value-list li:hover,
  .is-active {
    background-color: #ff908b !important;
  }
  .value-list li.closed {
    max-height: 0;
    overflow: hidden;
    padding: 0;
    opacity: 0;
  }
}
</style>
