<template>
  <div class="home">
    <header>
      <!-- TODO Habría que optimizar bastante las imágenes, ahora mismo ocupan demasiado y ralentizan la carga -->
      <div class="logo">
        <img class="logo-wikikahoot" src="../../assets/logo.png" />
      </div>
    </header>
    <div class="card-home-left">
      <div class="card-left">
        <router-link to="/creacionEventos">
          <div class="card-title-crear">
            <h3>CREA JUEGOS KAHOOT</h3>
          </div>
        </router-link>
        <div class="card-content">
          <img
            class="img-right"
            alt="logo1"
            src="../../assets/imagen-crear.png"
          />
          <span class="text">
            Crea el repositorio compartido de preguntas y respuestas de tus
            juegos Kahoot sobre la temática y nivel de dificultad que desees.
          </span>
        </div>
      </div>
    </div>
    <div class="card-home-right">
      <div class="card-right">
        <router-link to="/consultar">
          <div class="card-title-consultar">
            <h3>REPOSITORIO DE JUEGOS</h3>
          </div>
        </router-link>
        <div class="card-content">
          <img
            class="img-left"
            alt="logo2"
            src="../../assets/imagen-consultar.png"
          />
          <span class="text">
            Accede al repositorio compartido de preguntas y respuestas de juegos
            Kahoot creados. Podrás utilizarlas para tus nuevos juegos y
            ampliarlos con nuevas cuestiones.
          </span>
        </div>
      </div>
    </div>
    <div class="card-home-left">
      <div class="card-left">
        <div class="card-title-compartir">
          <h3>JUEGOS POR ETAPAS EDUCATIVAS</h3>
        </div>
        <div class="card-content">
          <img
            class="img-right"
            alt="logo3"
            src="../../assets/imagen-compartir.png"
          />
          <span class="text">
            Dispones de enlaces a juegos Kahoot creados por docentes de
            diferentes etapas educativas.
          </span>
        </div>
      </div>
    </div>
    <div class="card-home-right">
      <div class="card-right">
        <router-link to="/ayuda">
          <div class="card-title-ayudar">
            <h3>AYUDA</h3>
          </div>
        </router-link>
        <div class="card-content">
          <img
            class="img-left"
            alt="logo4"
            src="../../assets/imagen-ayudar.png"
          />
          <span class="text">
            Te explicamos cómo crear y acceder a juegos Kahoot utilizando esta
            herramienta para docentes.
          </span>
        </div>
      </div>
    </div>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>
  </div>
</template>

<script>
export default {
  name: "Home",
};
</script>
<style lang="scss">
.home {
  header {
    background-image: url("../../assets/logoBackground.png");
    background-size: 100% 100%;
    margin-bottom: 4rem;
    .logo-wikikahoot {
      height: auto;
      max-width: 100%;
    }

    .logo {
      display: flex;
      justify-content: center;
      padding: 1rem 0;
      backdrop-filter: blur(1.5rem);
      filter: drop-shadow(8px 8px 10px gray);
      -webkit-backdrop-filter: blur(1.5rem);
      -moz-backdrop-filter: blur(1.5rem);
    }
  }

  .card-home-left {
    display: flex;
    width: 60%;
    margin-bottom: 5rem;
    margin-left: 3rem;
    .card-left {
      background: #15527a;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
      border-radius: 0.5rem;
      .img-right {
        float: right;
        height: auto;
        max-width: 100%;
        border-radius: 0 0 0.5rem 0;
        margin-left: 2rem;
      }
    }
  }

  .card-home-right {
    display: flex;
    width: 60%;
    margin-bottom: 5rem;
    float: right;
    margin-right: 3rem;
    .card-right {
      background: #15527a;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
      border-radius: 0.5rem;
      .img-left {
        margin-right: 3em;
        float: left;
        height: auto;
        max-width: 100%;
        border-radius: 0 0 0 0.5rem;
        vertical-align: sub;
      }
    }
  }

  .text {
    color: white;
    line-height: 2rem;
    display: block;
    padding: 2rem;
    font-family: "open sans";
    font-size: 1.1rem;
  }

  .card-title-crear {
    display: flex;
    justify-content: center;
    background: #237e0b;
    font-family: "open sans";
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    color: white;
  }
  .card-title-crear:hover {
    cursor: pointer;
    animation: cambiar-color-crear 2s;
    animation-fill-mode: forwards;
  }

  @keyframes cambiar-color-crear {
    from {
      background: #237e0b;
    }
    to {
      background: #0b1980;
    }
  }
  .card-title-consultar {
    display: flex;
    justify-content: center;
    background: #f25757;
    font-family: "open sans";
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    color: white;
  }
  .card-title-consultar:hover {
    cursor: pointer;
    animation: cambiar-color-consultar 2s;
    animation-fill-mode: forwards;
  }
  @keyframes cambiar-color-consultar {
    from {
      background: #f25757;
    }
    to {
      background: #f8cc6a;
    }
  }
  .card-title-compartir {
    display: flex;
    justify-content: center;
    background: #431b93;
    font-family: "open sans";
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    color: white;
  }
  .card-title-compartir:hover {
    cursor: pointer;
    animation: cambiar-color-compartir 2s;
    animation-fill-mode: forwards;
  }
  @keyframes cambiar-color-compartir {
    from {
      background: #431b93;
    }
    to {
      background: rgb(190, 43, 43);
    }
  }
  .card-title-ayudar {
    display: flex;
    justify-content: center;
    background: #1976d2;
    font-family: "open sans";
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    color: white;
  }
  .card-title-ayudar:hover {
    cursor: pointer;
    animation: cambiar-color-ayudar 2s;
    animation-fill-mode: forwards;
  }
  @keyframes cambiar-color-ayudar {
    from {
      background: #1976d2;
    }
    to {
      background: rgb(122, 16, 148);
    }
  }

  a {
    text-decoration: none;
    &:active,
    &:visited {
      color: white;
    }
  }
}
</style>
