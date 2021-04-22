<template>
  <div id="app">
    <AppHeader></AppHeader>
    <router-view />
  </div>
</template>
<script>
import AppHeader from './components/AppHeader.vue';

export default {
  name: 'App',
  data() {
    return {};
  },
  components: {
    AppHeader,
  },
};
</script>
<style lang="scss">
$dark-font: #2c3e50;

* {
  box-sizing: border-box;
  outline: none;
}

body {
  box-sizing: border-box;
  padding: 0;
  margin: 0;
  outline: none;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  box-sizing: border-box;
  outline: none;
  color: $dark-font;
}
</style>
