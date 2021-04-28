<template>
  <div id="app-nav">
    <router-link to="/">Home</router-link> |
    <router-link to="/creacionEventos">Crear eventos</router-link> |
    <router-link to="/preguntas">Buscar eventos</router-link> |
    <router-link to="/ayuda">Ayuda</router-link>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
#app-nav {
  text-align: center;
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
