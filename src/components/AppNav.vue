<template>
  <div id="app-nav">
    <nav>
      <router-link to="/"
        ><img src="../assets/logo.png" alt="logo WikiKahoot"
      /></router-link>
      <router-link to="/">Home</router-link> |
      <router-link to="/creacionEventos">Crear Kahoot</router-link> |
      <router-link to="/consultar">Repositorio de juegos</router-link> |
      <router-link to="/ayuda">Ayuda</router-link> |
      <router-link to="/about">Acerca de</router-link>
    </nav>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
#app-nav {
  height: 64px;
  padding: 23px;
  padding-left: 8em;
  position: sticky;
  top: 1px;
  z-index: 1;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 1px 6px 0 rgba(32, 33, 36, 0.28);

  img {
    height: 48px;
    position: absolute;
    left: 0;
    top: 0;
    margin-top: 6px;
    margin-left: 30px;
    image-rendering: -webkit-optimize-contrast;
    image-rendering: -o-crisp-edges;
  }

  a {
    font-weight: bold;
    color: #2c3e50;
    margin: 0 4px;
    text-decoration: none;

    &:hover {
      color: #42b983;
      transition: all 0.2s;
    }
  }

  .router-link-exact-active {
    color: #42b983;
    border-bottom: 1px solid currentColor;
  }
}
</style>
