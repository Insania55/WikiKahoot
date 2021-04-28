<template>
  <div class="home">
    <header>
      <div class="logo">
        <img alt="logo" src="../assets/logo.png" />
      </div>
    </header>
    <div class="card-container">
      <div class="card">
        <div class="titulo">
          <h3>CREA EVENTOS</h3>
        </div>
        <p>
          WikiKahoot ofrece la opción de crear tus propios eventos con los que
          hacer crecer la web y crear contenido para otros usuarios.
        </p>
        <br />
        <p>
          Esta es una forma de compartir conocimiento de la misma manera que se
          recibe.
        </p>
        <div class="icono">
          <img alt="logo" src="../assets/card-image-2-kidd.png" />
        </div>
      </div>
    </div>
    <div class="card-container-odd">
      <div class="card-odd">
        <h3>CONSULTA EVENTOS</h3>
        <div class="parrafos">
          <div>
            <p>
              En la opción CONSULTA EVENTOS puedes buscar el evento que más se
              ajuste a tus necesidades, existen multitud de temas y variedad.
            </p>
          </div>
          <div>
            <p>Además puedes filtrarlos hasta dar con el más apropiado.</p>
          </div>
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

/*
!NO VA
*Esperando a que Jorge le eche un vistazo
$(document).ready(function() {
  $(".ir-arriba").click(function() {
    $("body, html").animate(
      {
        scrollTop: "0px",
      },
      300
    );
  });

  $(window).scroll(function() {
    if ($(this).scrollTop() > 0) {
      $(".ir-arriba").slideDown(300);
    } else {
      $(".ir-arriba").slideUp(300);
    }
  });
});*/
</script>
<style lang="scss">
.home {
  header {
    background-image: url("../assets/logoBackground.png");
    background-size: 100% 100%;
    margin-bottom: 4rem;
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
  .ir-arriba {
    filter: drop-shadow(8px 8px 10px gray);
    padding: 20px;
    background-image: url("../assets/icono-subir.png");
    background-size: 100% 100%;
    cursor: pointer;
    position: fixed;
    bottom: 30px;
    right: 30px;
    border-radius: 100%;
  }

  .card-container {
    margin-bottom: 3rem;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    height: 20vh;
    color: #ffffff;
    line-height: 1.4;
    border-radius: 5px;

    .card {
      display: flex;
      background: #0d2c40;
      background-repeat: no-repeat;
      width: 80%;
      height: 100%;
      border-radius: 2px;
      box-shadow: 1px 1px 4px 2px rgba(0, 0, 0, 0.2);
    }
    h3 {
      text-align: center;
      padding: 20px;
      padding-bottom: 3.5rem;
      -webkit-transform: rotate(-90deg);
      -moz-transform: rotate(-90deg);
      -ms-transform: rotate(-90deg);
      -o-transform: rotate(-90deg);
      font-size: 150%;
    }
    .titulo {
      background: seagreen;
    }
    p {
      padding-left: 1rem;
      width: 60%;
    }

    .parrafos {
      display: flex;
      flex-wrap: wrap;
    }

    .icono {
      display: flex;
      float: left;
      position: relative;
    }

    .titulo:hover {
      cursor: pointer;
      animation: example 5s;
      animation-fill-mode: forwards;
      h3 {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
      }
    }

    @keyframes example {
      from {
        padding-left: 0px;
      }
      to {
        padding-left: 300px;
      }
    }
  }

  // .card-container {
  //   margin-bottom: 3rem;
  //   > .card {
  //     background: #0d2c40 url("../assets/card-image-1.png");
  //     background-repeat: no-repeat;
  //     background-position: 850px 50px;
  //     background-size: 30%;
  //     position: relative;
  //     color: #ffffff;
  //     width: 60%;
  //     padding: 6.1em 1em;

  //     h3 {
  //       position: absolute;
  //       color: #ffffff;
  //       font-size: 150%;
  //       line-height: 2.1em;
  //       top: 2.5em;
  //       left: -4.5em;
  //       padding: 2em;
  //       padding-bottom: 1.21em;
  //       -webkit-transform: rotate(-90deg);
  //       -moz-transform: rotate(-90deg);
  //       -ms-transform: rotate(-90deg);
  //       -o-transform: rotate(-90deg);
  //       background: seagreen;
  //     }
  //     p {
  //       width: 66%;
  //       padding-left: 10%;
  //     }
  //   }
  // }
  // .card-container-odd {
  //   margin-bottom: 3rem;
  //   > .card-odd {
  //     background: #0d2c40 url("../assets/card-image-2.png");
  //     background-repeat: no-repeat;
  //     background-position: -50px 50px;
  //     background-size: 30%;
  //     position: relative;
  //     color: #ffffff;
  //     width: 60%;
  //     padding: 6.1em 1em;
  //     margin-left: auto;

  //     h3 {
  //       position: absolute;
  //       color: #ffffff;
  //       font-size: 145%;
  //       line-height: 1.59em;
  //       top: 3.35em;
  //       right: -4.5em;
  //       padding: 1em;
  //       padding-bottom: 1.5em;
  //       -webkit-transform: rotate(90deg);
  //       -moz-transform: rotate(90deg);
  //       -ms-transform: rotate(90deg);
  //       -o-transform: rotate(90deg);
  //       background: #eecd38ea;
  //     }
  //     p {
  //       width: 66%;
  //       padding-right: 10%;
  //       margin-left: auto;
  //     }
  //   }
  // }
  // @media screen and (max-width: 800px) {
  //   .card-container {
  //     margin-bottom: 3rem;
  //     > .card {
  //       background: #0d2c40;
  //       width: 90%;
  //       padding: 6.1em 1em;

  //       h3 {
  //         font-size: 165%;
  //         top: 2.7em;
  //         left: -4.5em;
  //         padding-bottom: 1em;
  //       }
  //       p {
  //         width: 80%;
  //         padding-left: 20%;
  //       }
  //     }
  //   }
  //   .card-container-odd {
  //     margin-bottom: 3rem;
  //     > .card-odd {
  //       background: #0d2c40;
  //       background-position: -50px 50px;
  //       width: 90%;
  //       padding: 6em 1em;

  //       h3 {
  //         font-size: 140%;
  //         line-height: 2em;
  //         top: 3.5em;
  //         right: -4.5em;
  //         padding-bottom: 1em;
  //       }
  //       p {
  //         width: 92%;
  //       }
  //     }
  //   }
  // }
  // @media screen and (max-width: 600px) {
  //   .card-container {
  //     margin-bottom: 3rem;
  //     > .card {
  //       background: #0d2c40;
  //       background-position: 850px 50px;
  //       width: 100%;

  //       h3 {
  //         position: relative;
  //         text-align: center;
  //         font-size: 150%;
  //         line-height: 1em;
  //         top: -5em;
  //         left: 0em;
  //         padding: 1em;
  //         padding-bottom: 1em;
  //         -webkit-transform: rotate(0deg);
  //         -moz-transform: rotate(0deg);
  //         -ms-transform: rotate(0deg);
  //         -o-transform: rotate(0deg);
  //         background: seagreen;
  //       }
  //       p {
  //         text-align: center;
  //         width: 100%;
  //         padding-left: 0%;
  //       }
  //     }
  //   }
  //   .card-container-odd {
  //     margin-bottom: 3rem;
  //     > .card-odd {
  //       background: #0d2c40;
  //       background-position: 850px 50px;
  //       width: 100%;

  //       h3 {
  //         position: relative;
  //         text-align: center;
  //         font-size: 150%;
  //         line-height: 1em;
  //         top: -5em;
  //         right: 0em;
  //         padding: 1em;
  //         padding-bottom: 1em;
  //         -webkit-transform: rotate(0deg);
  //         -moz-transform: rotate(0deg);
  //         -ms-transform: rotate(0deg);
  //         -o-transform: rotate(0deg);
  //         background: #eecd38ea;
  //       }
  //       p {
  //         text-align: center;
  //         width: 100%;
  //         padding-right: 0%;
  //       }
  //     }
  //   }
  // }
}
</style>
