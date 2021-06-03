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
        :ref="'li' + index"
        v-else-if="isInputClicked"
        v-for="(option, index) in options"
        :key="index"
        @click="setResult(option)"
        :class="{ 'is-active': index === currentPointer }"
        :current="index === currentPointer ? focusElement(index) : ''"
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
        {{ result.text }}
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
      observer: null,
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
    "this.results": function (val, oldVal) {
      if (this.isAsync) {
        console.log("Entra en el watcher", val, oldVal);
        this.results = val;
        // this.optionsDropdown = true;
        this.isLoading = false;
      }
    },
    "this.currentPointer": function (val, oldVal) {
      console.log("Cambia el puntero a posicion " + val);
    },
  },
  methods: {
    // TODO: Controlar scroll al subir o bajar con las flechas
    focusElement(index) {
      // console.log(this.$refs["li" + index][0]);
      // console.log();
      // this.$refs["li" + index][0].parentElement.scrollTop += 20;
      // let activeEl = document.querySelector();
      // console.log(activeEl);
      // if (this.currentPointer === index) {
      //   ev.target.focus();
      // }
    },
    filterResults() {
      this.results = this.options.filter(
        (item) =>
          item.text.toLowerCase().indexOf(this.searchTerm.toLowerCase()) > -1
      );
      this.isLoading = false;
    },
    setResult(result) {
      this.searchTerm = result.text;
      this.optionsDropdown = false;
      this.$emit("selected-value", { text: result.text, value: result.value });
    },
    onChange() {
      //TODO: Conseguir que funcione el debouncing
      this.debounce(this.$emit("input", this.searchTerm));
      if (this.isAsync) {
        this.isLoading = true;
      }
      // ? Si el input ha sido clickado y no hay resultados, esto hará que no se muestre ningún desplegable
      this.isInputClicked = false;
      this.filterResults();
      this.optionsDropdown = true;
    },
    onInputClick() {
      this.optionsDropdown = !this.optionsDropdown;
      this.isInputClicked = true;
      const viewportOffset = this.getOffsetScreen(this.$el);
      this.totalWidth = document.body.clientWidth - viewportOffset.left;
    },
    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.currentPointer = -1;
        this.optionsDropdown = false;
      }
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
      this.searchTerm = array[this.currentPointer].text;
      this.currentPointer = -1;
      this.optionsDropdown = false;
      this.$emit("selected-value", this.searchTerm);
    },
    // async infiniteScroll({ isIntersecting, target }) {
    //   if (isIntersecting) {
    //     const ul = target.offsetParent;
    //     const scrollTop = target.offsetParent.scrollTop;
    //     await this.$nextTick();
    //     ul.scrollTop = scrollTop;
    //   }
    // },
    debounce(callback, timeout = 300) {
      let timerId;
      return (...args) => {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
          callback.apply(this, args);
        }, timeout);
      };
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
  },
};
</script>

//TODO: Refactorizar a código SCSS
<style lang="scss" scoped>
$select-width: 400px;
$--color-input: #fab700;
$--color-label-unfocused: #d9d9d9;
$--color-label-focused: black;

.app-select {
  .value-list {
    position: absolute;
    z-index: 555;
    width: 100%;
    // opacity: 1;
  }

  .label {
    font-size: 1.1rem;
    font-weight: 600;
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    width: $select-width;
    line-height: 28px;
    margin-left: 3.5rem;

    input {
      flex: 0 0 $select-width;
      margin-left: 10px;
      border-radius: 2px;
    }

    // &:hover {
    //   box-shadow: 0 1px 0px $--color-label-focused;
    //   border-bottom: 2px solid $--color-label-focused;
    // }
  }

  .chosen-value {
    font-family: "Open sans";
    font-size: 0.9rem;
    // font-weight: 600;
    border: 3px solid transparent;
    -webkit-transition: 0.3s ease-in-out;
    transition: 0.3s ease-in-out;
  }
  .chosen-value::-webkit-input-placeholder {
    color: #333;
  }
  .chosen-value:hover {
    // background-color: $--color-input;
    cursor: pointer;
  }
  .chosen-value:hover::-webkit-input-placeholder {
    color: #333;
  }
  .chosen-value:focus,
  .chosen-value.open {
    box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
    outline: 0;
    color: #000;
    max-width: $select-width;
  }
  .chosen-value:focus::-webkit-input-placeholder,
  .chosen-value.open::-webkit-input-placeholder {
    color: #000;
  }

  .value-list {
    list-style: none;
    box-shadow: 0px 5px 8px 0px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    max-height: 0;
    max-width: $select-width;
    -webkit-transition: 0.3s ease-in-out;
    transition: 0.3s ease-in-out;
    border: 1px solid black;
  }

  .value-list.open {
    margin-left: 3.5rem;
    max-height: 320px;
    overflow: auto;
    overflow-x: hidden;
    background-color: #eee;
    padding: 0;
  }
  .value-list li {
    position: relative;
    height: 4rem;
    background-color: #fafcfd;
    padding: 1rem 0.4rem;
    font-size: 1.1rem;
    // display: -webkit-box;
    // display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    cursor: pointer;
    -webkit-transition: background-color 0.3s;
    transition: background-color 0.3s;
  }
  .value-list li:hover,
  .is-active {
    background-color: $--color-input !important;
  }
  .value-list li.closed {
    overflow: hidden;
    max-height: 0;
    padding: 0;
  }
}
</style>
