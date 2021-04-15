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
  // Si quitas esto el layout se va a la verga
  text-align: center;
  color: $dark-font;
}

//TODO: Esto debería moverse al componente AppHeader
#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: $dark-font;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
