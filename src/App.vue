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
  outline: none;
  margin: 0;
  padding: 0;
}

body {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
  outline: none;
}

#app {
  // font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  box-sizing: border-box;
  outline: none;
  background-color: $--color-light-bg;
}
</style>
