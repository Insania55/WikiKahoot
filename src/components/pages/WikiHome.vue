<template>
  <div class="home">
    <header>
      <div class="logo">
        <img class="logo-wikikahoot" src="../../assets/logo.png" />
      </div>
    </header>
    <div class="card-container left">
      <div class="card-content">
        <div class="card-title">
          <h3>CREA EVENTOS</h3>
        </div>
        <div class="card-text">
          <p>
            WikiKahoot ofrece la opción de crear tus propios eventos con los que
            hacer crecer la web y crear contenido para otros usuarios.
          </p>
          <p>
            Esta es una forma de compartir conocimiento de la misma manera que
            se recibe.
          </p>
        </div>

        <div class="card-icon">
          <img alt="logo1" src="../../assets/card-image-2-kidd.png" />
        </div>
      </div>
    </div>
    <div class="card-container-consultar">
      <div class="card-consultar">
        <div class="icono-consultar">
          <img alt="logo2" src="../../assets/card-image-1-kidd.png" />
        </div>
        <div class="parrafos-consultar">
          <p>
            En la opción CONSULTA EVENTOS puedes buscar el evento que más se
            ajuste a tus necesidades, existen multitud de temas y variedad.
          </p>
          <p>Además puedes filtrarlos hasta dar con el más apropiado.</p>
        </div>
        <div class="titulo-consultar">
          <h3>CONSULTA EVENTOS</h3>
        </div>
      </div>
    </div>
    <div class="card-container-compartir">
      <div class="card-compartir">
        <div class="titulo-compartir">
          <h3>COMPARTE KAHOOT</h3>
        </div>
        <div class="parrafos-compartir">
          <p>
            WikiKahoot ofrece la opción de crear tus propios eventos con los que
            hacer crecer la web y crear contenido para otros usuarios.
          </p>
          <p>
            Esta es una forma de compartir conocimiento de la misma manera que
            se recibe.
          </p>
        </div>
        <div class="icono-compartir">
          <img alt="logo3" src="../../assets/card-image-2-kidd.png" />
        </div>
      </div>
    </div>
    <div class="card-container-ayudar">
      <div class="card-ayudar">
        <div class="icono-ayudar">
          <img alt="logo4" src="../../assets/card-image-1-kidd.png" />
        </div>
        <div class="parrafos-ayudar">
          <p>
            En la opción CONSULTA EVENTOS puedes buscar el evento que más se
            ajuste a tus necesidades, existen multitud de temas y variedad.
          </p>
          <p>Además puedes filtrarlos hasta dar con el más apropiado.</p>
        </div>
        <div class="titulo-ayudar">
          <h3>AYUDA</h3>
        </div>
      </div>
    </div>
    <span class="ir-arriba"> </span>
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

  // .ir-arriba {
  //   filter: drop-shadow(8px 8px 10px gray);
  //   padding: 20px;
  //   background-image: url("../assets/icono-subir.png");
  //   background-size: 100% 100%;
  //   cursor: pointer;
  //   position: fixed;
  //   bottom: 30px;
  //   right: 30px;
  //   border-radius: 100%;
  // }

  .card-container {
    margin-bottom: 3rem;
    align-items: center;
    color: #ffffff;
    border-radius: 5px;
    line-height: 1.4;
    max-width: 80vw;

    .card-content {
      display: flex;
      background: #0d2c40;
      width: 65%;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
    }

    .card-text {
      display: flex;
      flex-flow: column nowrap;

      p {
        max-width: 60ch;
        padding: 1rem 1.8rem;
        line-height: 1.4rem;
      }
    }
    .card-title {
      background: seagreen;
      display: flex;
      align-items: center;
      font-family: "open sans";

      &:hover {
        cursor: pointer;
        animation: cambiar-color 2s;
        animation-fill-mode: forwards;
        h3 {
          animation: rotacion 3s;
        }
      }
    }

    h3 {
      text-align: center;
      transform: rotate(-90deg);
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      -ms-transform: rotate(-90deg);
      -o-transform: rotate(-90deg);
      font-size: 120%;
      font-family: "Open sans";
    }

    .card-icon {
      display: flex;
      margin-left: auto;
    }

    @keyframes cambiar-color {
      from {
        background: seagreen;
      }
      to {
        background: rgb(38, 141, 182);
      }
    }

    @keyframes rotacion {
      from {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate9(-90deg);
        -o-transform: rotate(-90deg);
      }
      to {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
      }
    }
  }

  .card-container-consultar {
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    height: 20vh;
    color: #ffffff;
    line-height: 1.4;
    border-radius: 5px;

    .card-consultar {
      display: flex;
      background: #0d2c40;
      background-repeat: no-repeat;
      width: 65%;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
    }
    h3 {
      text-align: center;
      padding: 20px;
      padding-bottom: 3.5rem;
      transform: rotate(0deg);
      -webkit-transform: rotate(90deg);
      -moz-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
      -o-transform: rotate(90deg);
      font-size: 150%;
      text-shadow: 1px 3px #999;
    }
    .titulo-consultar {
      background: rgb(223, 205, 51);
    }
    p {
      padding-top: 1rem;
      padding-left: 1rem;
    }

    .parrafos-consultar {
      display: flex;
      flex-wrap: wrap;
      max-width: 80%;
    }

    .icono-consultar {
      display: flex;
      float: right;
      position: relative;
    }

    .titulo-consultar:hover {
      cursor: pointer;
      animation: colores-consultar 3s;
      animation-fill-mode: forwards;
      h3 {
        animation: rotacion-consultar 3s;
        animation-fill-mode: forwards;
      }
    }
    @keyframes colores-consultar {
      from {
        background: rgb(223, 205, 51);
      }
      to {
        background: rgb(184, 83, 43);
      }
    }
    @keyframes rotacion-consultar {
      from {
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate9(90deg);
        -o-transform: rotate(90deg);
      }
      to {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
      }
    }
  }

  .card-container-compartir {
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    height: 20vh;
    color: #ffffff;
    line-height: 1.4;
    border-radius: 5px;

    .card-compartir {
      display: flex;
      background: #0d2c40;
      background-repeat: no-repeat;
      width: 65%;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
    }
    h3 {
      text-align: center;
      padding: 20px;
      padding-bottom: 3.5rem;
      transform: rotate(0deg);
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      -ms-transform: rotate(-90deg);
      -o-transform: rotate(-90deg);
      font-size: 150%;
      text-shadow: 1px 3px #999;
    }
    .titulo-compartir {
      background: rgb(28, 189, 41);
    }
    p {
      padding-top: 1rem;
      padding-left: 1rem;
    }

    .parrafos-compartir {
      display: flex;
      flex-wrap: wrap;
      max-width: 80%;
    }

    .icono-compartir {
      display: flex;
      float: left;
      position: relative;
    }

    .titulo-compartir:hover {
      cursor: pointer;
      animation: colores-compartir 3s;
      animation-fill-mode: forwards;
      h3 {
        animation: rotacion-compartir 3s;
        animation-fill-mode: forwards;
      }
    }
    @keyframes colores-compartir {
      from {
        background: rgb(28, 189, 41);
      }
      to {
        background: rgb(207, 97, 211);
      }
    }
    @keyframes rotacion-compartir {
      from {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate9(-90deg);
        -o-transform: rotate(-90deg);
      }
      to {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
      }
    }
  }
  .card-container-ayudar {
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    height: 20vh;
    color: #ffffff;
    line-height: 1.4;
    border-radius: 5px;

    .card-ayudar {
      display: flex;
      background: #0d2c40;
      background-repeat: no-repeat;
      width: 65%;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
    }
    h3 {
      text-align: center;
      padding: 20px;
      padding-bottom: 3.5rem;
      transform: rotate(0deg);
      -webkit-transform: rotate(90deg);
      -moz-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
      -o-transform: rotate(90deg);
      font-size: 150%;
      text-shadow: 1px 3px #999;
    }
    .titulo-ayudar {
      background: rgb(48, 91, 155);
    }
    p {
      padding-top: 1rem;
      padding-left: 1rem;
    }

    .parrafos-ayudar {
      display: flex;
      flex-wrap: wrap;
      max-width: 80%;
    }

    .icono-ayudar {
      display: flex;
      float: right;
      position: relative;
    }

    .titulo-ayudar:hover {
      cursor: pointer;
      animation: colores-ayudar 3s;
      animation-fill-mode: forwards;
      h3 {
        animation: rotacion-ayudar 3s;
        animation-fill-mode: forwards;
      }
    }
    @keyframes colores-ayudar {
      from {
        background: rgb(48, 91, 155);
      }
      to {
        background: rgb(155, 31, 212);
      }
    }
    @keyframes rotacion-ayudar {
      from {
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate9(90deg);
        -o-transform: rotate(90deg);
      }
      to {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
      }
    }
  }

  .ir-arriba {
    filter: drop-shadow(8px 8px 10px gray);
    padding: 20px;
    background-image: url("../../assets/icono-subir.png");
    background-size: 100% 100%;
    cursor: pointer;
    position: fixed;
    bottom: 30px;
    right: 30px;
    border-radius: 100%;
  }

  @media screen and (max-width: 1060px) {
    .card-container {
      img {
        display: none;
      }
    }
    .card-container-consultar {
      img {
        display: none;
      }
    }
    .card-container-compartir {
      img {
        display: none;
      }
    }
    .card-container-ayudar {
      img {
        display: none;
      }
    }
  }
  @media screen and (max-width: 800px) {
    .card-container {
      .card-content {
        width: 100%;
        .card-title {
          width: 100%;
          position: absolute;
          h3 {
            padding: 0px;
            padding-bottom: 1rem;
            padding-top: 1rem;
            transform: rotate(0deg);
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
        }
        .card-text {
          margin-top: 4rem;
        }
      }

      .card-title:hover {
        @keyframes rotacion {
          from {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
          }
        }
      }
    }
    .card-container-consultar {
      .card-consultar {
        width: 100%;
        .titulo-consultar {
          width: 100%;
          position: absolute;
          h3 {
            padding: 0px;
            padding-bottom: 1rem;
            padding-top: 1rem;
            transform: rotate(0deg);
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
        }
        .parrafos-consultar {
          margin-top: 4rem;
        }
      }
      .card-title:hover {
        @keyframes rotacion-consultar {
          from {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
          }
        }
      }
    }
    .card-container-compartir {
      .card-compartir {
        width: 100%;
        .titulo-compartir {
          width: 100%;
          position: absolute;
          h3 {
            padding: 0px;
            padding-bottom: 1rem;
            padding-top: 1rem;
            transform: rotate(0deg);
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
        }
        .parrafos-compartir {
          margin-top: 4rem;
        }
      }
      .card-title:hover {
        @keyframes rotacion-compartir {
          from {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
          }
        }
      }
    }
    .card-container-ayudar {
      .card-ayudar {
        width: 100%;

        .titulo-ayudar {
          width: 100%;
          position: absolute;
          h3 {
            padding: 0px;
            padding-bottom: 1rem;
            padding-top: 1rem;
            transform: rotate(0deg);
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
        }
        .parrafos-ayudar {
          margin-top: 4rem;
        }
      }
      .card-title:hover {
        @keyframes rotacion-ayudar {
          from {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate9(0deg);
            -o-transform: rotate(0deg);
          }
          to {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
          }
        }
      }
    }
  }
}
</style>
