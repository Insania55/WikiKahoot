<template>
  <div class="help">
    <header>
      <h2 class="title">Ayuda</h2>
      <span>
        Aquí encontrarás toda la ayuda necesaria para poder utilizar todas las
        herramientas que ofrece WikiKahoot
      </span>
    </header>
    <div class="card">
      <div class="card-content-left">
        <div class="card-title">
          <h3>CREA UN EVENTO</h3>
        </div>
        <div class="texto">
          <span>
            En "Crear un evento" disponemos de dos opciones, "Crea un nuevo
            evento" y "Añade preguntas a un evento existente".
            <br /><br />
          </span>
          <img
            class="img-ejemplo"
            alt="ejemplo"
            src="../../assets/AyudaNewCard.png"
            width="300"
            height="200"
          />
          <ul>
            <li>
              Desde la sección "Crea un nuevo evento" podremos elegir cualquier
              Etapa, Nivel, Área o Tema de los ya existentes, pero también
              tenemos la posibilidad de crear nuevos pulsando en el botón "+".
            </li>
          </ul>
          <img
            class="img-ejemplo"
            alt="ejemplo"
            src="../../assets/AyudaCard.png"
            width="300"
            height="200"
          />
          <ul>
            <li>
              La sección "Añade preguntas a un evento existente" nos permite
              introducir el código de un evento que ya está creado para acceder
              a él.
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content-right-2">
        <div class="card-title">
          <h3>AÑADE PREGUNTAS A UN EVENTO</h3>
        </div>
        <div class="texto">
          <span>
            Una vez hemos econtrado el evento deseado o hemos creado nuestro
            propio evento, podemos añadir preguntas con sus respectivas
            respuestas.
            <br /><br />
          </span>
          <img
            class="img-ejemplo-2"
            alt="ejemplo"
            src="../../assets/AyudaFormulario.png"
            width="400"
            height="300"
          />
          <ul>
            <li>
              Simplemente deberemos rellenar cada uno de los campos, siendo
              obligatorios los campos con asterisco (*). Podemos en cualquier
              momento pulsar el botón "Borrar" para eliminar lo añadido a todos
              los campos. Una vez rellenada la información en sus respectivos
              campos, pulsando el botón "Añadir pregunta", se habrá completado
              el proceso y podremos seguir añadiendo preguntas de la misma forma
              si así lo deseamos.
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content-right">
        <div class="card-title">
          <h3>BUSCA UN EVENTO</h3>
        </div>
        <div class="texto">
          <span>
            En "Cosultar evento" podemos encontrar el evento que necesitemos y
            todas las plantillas que le correspondan.
            <br />
          </span>
          <span>
            Está búsqueda podemos realizarla de dos formas:
            <br /><br />
          </span>
          <img
            class="img-ejemplo-2"
            alt="ejemplo"
            src="../../assets/AyudaBuscarEvento2.png"
            width="300"
            height="150"
          />
          <ul>
            <li>
              A través de la opción "Filtros", donde encontraremos varios campos
              en los que si clicamos sobre ellos nos aparecerán distintas
              opciones para elegir y de esta manera encontrar las preguntas que
              más se adapten a nuestras necesidades .
            </li>
          </ul>
          <img
            class="img-ejemplo-2"
            alt="ejemplo"
            src="../../assets/AyudaBuscarEvento.png"
            width="300"
            height="200"
          />
          <ul>
            <li>
              Introduciendo directamente el código de evento deseado en esta
              barra de búsqueda.
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content-left-2">
        <div class="card-title">
          <h3>DESCARGA UN EVENTO</h3>
        </div>
        <div class="texto">
          <span>
            Una vez hemos encontrado el evento deseado o hemos filtrado la
            información necesaria para encontrar las preguntas deseadas podemos
            descargarlas.
            <br />
          </span>
          <span>
            Para ello debemos seguir los siguientes pasos:
            <br /><br />
          </span>
          <img
            class="img-ejemplo"
            alt="ejemplo"
            src="../../assets/seleccionarAyuda.png"
            width="100"
            height="200"
          />
          <ul>
            <li>
              Lo primero que deberemos hacer es seleccionar desde el recuadro de
              la tabla las preguntas que deseamos descargar, pinchando en el
              primer recuadro podemos seleccionar toda la fila.
            </li>
            <li>
              Para poder descargar la selección primero deberemos clicar en
              "Añadir a la descarga", una vez añadidas las preguntas ya podremos
              desplazarnos por las distintas páginas añadiendo preguntas.
            </li>
            <li>
              Si deseamos borrar de nuestra selección alguna de las preguntas
              podremos entrar en "Editar descarga actual", esta opción nos
              llevará a una tabla donde podemos eliminarlas de manera sencilla.
            </li>
            <li>
              Una vez tenemos las preguntas deseadas, clicando en el botón
              "Descargar selección" descargaremos todas en un archivo formato
              ".xlsx".
            </li>
          </ul>
          <img
            class="img-ejemplo-botones"
            alt="ejemplo"
            src="../../assets/botonesAyuda.png"
            width="300"
            height="200"
          />
        </div>
      </div>
    </div>
    <span class="ir-arriba" @click="$store.commit('scrollToView', $event)">
    </span>
  </div>
</template>

<script>
export default {};
</script>

<style lang="scss">
.help {
  background-color: white;
}
header {
  margin-bottom: 2em;
  text-align: center;
  .title {
    padding: 0.5em 0;
  }
}

.card {
  display: flex;
  justify-content: center;
  margin-bottom: 3rem;
  font-family: "Open Sans", sans-serif;
  .card-content-left {
    width: 70%;
    background: #431b9375;
    padding: 1em;
    margin: 1em;
    border-radius: 1rem;
    box-shadow: 2px 2px 2px 1px #431b9334;
  }
  .card-title {
    font-size: 18px;
    text-align: center;
    color: rgb(0, 0, 0);
    margin: 0.2em 0 0.6em 0;
  }
  .texto {
    color: #000000;
    line-height: 2em;
    margin-left: 1em;
    .img-ejemplo {
      margin-left: 3em;
      margin-right: 3em;
      float: left;
      height: auto;
      max-width: 100%;
    }
    .img-ejemplo-botones {
      display: block;
      margin: auto;
      height: auto;
      max-width: 100%;
    }
    ul {
      margin-bottom: 1.5em;
    }
  }
}
.card-content-right {
  width: 70%;
  background: #1976d288;
  padding: 1em;
  margin: 1em;
  border-radius: 1rem;
  box-shadow: 2px 2px 2px 1px #1976d24d;
  .img-ejemplo-2 {
    margin-left: 3em;
    margin-right: 1em;
    float: right;
    height: auto;
    max-width: 100%;
  }
}
.card-content-left-2 {
  width: 70%;
  background: #f257579f;
  padding: 1em;
  margin: 1em;
  border-radius: 1rem;
  box-shadow: 2px 2px 2px 1px #f2575750;
}
.card-content-right-2 {
  width: 70%;
  background: #42b983;
  padding: 1em;
  margin: 1em;
  border-radius: 1rem;
  box-shadow: 2px 2px 2px 1px #42b9839d;
  .img-ejemplo-2 {
    margin-left: 3em;
    margin-right: 1em;
    float: right;
    height: auto;
    max-width: 100%;
  }
}
</style>
