<template>
  <div id="app-nav">
    <router-link to="/"
      ><img src="../assets/logo.png" alt="logo WikiKahoot"
    /></router-link>
    <router-link to="/">Home</router-link> |
    <router-link to="/creacionEventos">Crear eventos</router-link> |
    <router-link to="/preguntas">Consultar eventos</router-link> |
    <router-link to="/ayuda">Ayuda</router-link>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
#app-nav {
  text-align: center;
  padding: 20px;
  position: sticky;
  top: 1px;
  background: rgba(238, 238, 238, 0.95);
  z-index: 1;
  img {
    height: 45px;
    position: absolute;
    left: 0;
    top: 0;
    margin-top: 6px;
    margin-left: 30px;
  }

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
