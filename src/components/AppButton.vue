<template>
  <div class="app-button">
    <button
      v-if="normal"
      class="normal"
      @click="!href ? $emit('click', $event) : $router.push(href)"
    >
      <slot>Texto</slot>
    </button>
    <button v-if="disabled" class="disabled">
      <slot>Texto</slot>
    </button>
    <button
      v-if="green"
      class="green"
      @click="!href ? $emit('click', $event) : $router.push(href)"
    >
      <slot>Texto</slot>
    </button>
  </div>
</template>

<script>
export default {
  name: "AppButton",
  props: {
    normal: Boolean,
    disabled: Boolean,
    green: Boolean,
    href: String,
  },
  data() {
    return {};
  },
};
</script>

<style lang="scss">
.app-button {
  button {
    display: inline-block;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-weight: bold;
    text-align: center;
    min-height: 42px;
    min-width: 7.5rem;
    padding: 0px 16px 4px;
    position: relative;
    line-height: 0.9rem;
  }

  .normal {
    background: rgb(242, 242, 242) none repeat scroll 0% 0%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px -4px inset;

    &:hover:enabled {
      min-height: 40px;
      margin-top: 2px;
      padding-bottom: 2px;
      background-color: rgb(223, 223, 223);
      box-shadow: rgba(0, 0, 0, 0.25) 0px -2px inset;
    }

    &:active:enabled {
      min-height: 38px;
      margin-top: 4px;
      padding-bottom: 0px;
      box-shadow: none;
      background-color: rgb(202, 202, 202);
    }
  }

  .green {
    background: rgb(38, 137, 12) none repeat scroll 0% 0%;
    box-shadow: rgba(0, 0, 0, 0.25) 0px -4px inset;
    color: white;

    &:hover:enabled {
      min-height: 40px;
      margin-top: 2px;
      padding-bottom: 2px;
      box-shadow: none;
      background-color: rgb(35, 126, 11);
      box-shadow: rgba(0, 0, 0, 0.25) 0px -2px inset;
    }

    &:active:enabled {
      min-height: 38px;
      margin-top: 4px;
      padding-bottom: 0px;
      box-shadow: none;
      background-color: rgb(32, 115, 10);
    }
  }

  .disabled {
    cursor: not-allowed;
    background-color: rgb(204, 204, 204);
    color: white;
    box-shadow: none;
    padding-bottom: 0;

    &:hover {
      background-color: rgb(150, 150, 150);
    }
  }
}
</style>