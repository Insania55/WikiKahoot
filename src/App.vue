<template>
  <div id="app">
    <AppNav></AppNav>
    <router-view />
  </div>
</template>
<script>
import AppNav from "./components/AppNav.vue";

export default {
  name: "App",
  data() {
    return {};
  },
  components: {
    AppNav,
  },
};
</script>
<style lang="scss">
$--color-light-bg: #fff;

* {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
  outline: none;
}

body {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
  outline: none;
  font-size: 16px;
}

#app {
  // font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  box-sizing: border-box;
  outline: none;
  background-color: $--color-light-bg;

  h2,
  h3 {
    font-family: "francois one";
    letter-spacing: 1px;
  }

  .ir-arriba {
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
    padding: 20px;
    background-image: url("./assets/icono-subir.png");
    background-size: 100% 100%;
    cursor: pointer;
    position: fixed;
    bottom: 30px;
    right: 30px;
    border-radius: 100%;
  }
}
</style>
