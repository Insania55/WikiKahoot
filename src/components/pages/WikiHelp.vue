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
          <h3>AYUDA EVENTOS</h3>
        </div>
        <div class="texto">
          <img
            class="img-ejemplo"
            alt="ejemplo"
            src="../../assets/img-ejemplo.png"
            width="400"
            height="300"
          />
          <span>
            Lorem ipsum dolor sit amet consectetur adipiscing elit faucibus
            imperdiet class dictumst vivamus interdum, eros vitae purus taciti
            massa natoque pellentesque auctor commodo proin eget. Massa tellus
            consequat dis urna praesent natoque, suscipit convallis etiam
            penatibus lobortis cursus aenean, sollicitudin porta congue magna
            egestas. Semper euismod id dignissim curae fringilla at purus sem
            vivamus a, turpis varius ad ac litora urna nibh egestas.
          </span>
          <ol>
            <li>Enchufar correctamente</li>
            <li>Comprobar conexiones</li>
            <li>Encender el aparato</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content-right">
        <div class="card-title">
          <h3>AYUDA CONSULTAS</h3>
        </div>
        <div class="texto">
          <img
            class="img-ejemplo-2"
            alt="ejemplo"
            src="../../assets/img-ejemplo.png"
            width="400"
            height="300"
          />
          <span>
            Lorem ipsum dolor sit amet consectetur adipiscing elit faucibus
            imperdiet class dictumst vivamus interdum, eros vitae purus taciti
            massa natoque pellentesque auctor commodo proin eget. Massa tellus
            consequat dis urna praesent natoque, suscipit convallis etiam
            penatibus lobortis cursus aenean, sollicitudin porta congue magna
            egestas. Semper euismod id dignissim curae fringilla at purus sem
            vivamus a, turpis varius ad ac litora urna nibh egestas.
          </span>
          <ol>
            <li>Enchufar correctamente</li>
            <li>Comprobar conexiones</li>
            <li>Encender el aparato</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-content-left-2">
        <div class="card-title">
          <h3>AYUDA COMPARTIR</h3>
        </div>
        <div class="texto">
          <img
            class="img-ejemplo"
            alt="ejemplo"
            src="../../assets/img-ejemplo.png"
            width="400"
            height="300"
          />
          <span>
            Lorem ipsum dolor sit amet consectetur adipiscing elit faucibus
            imperdiet class dictumst vivamus interdum, eros vitae purus taciti
            massa natoque pellentesque auctor commodo proin eget. Massa tellus
            consequat dis urna praesent natoque, suscipit convallis etiam
            penatibus lobortis cursus aenean, sollicitudin porta congue magna
            egestas. Semper euismod id dignissim curae fringilla at purus sem
            vivamus a, turpis varius ad ac litora urna nibh egestas.
          </span>
          <ol>
            <li>Enchufar correctamente</li>
            <li>Comprobar conexiones</li>
            <li>Encender el aparato</li>
          </ol>
        </div>
      </div>
    </div>
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
  .card-content-left {
    width: 70%;
    background: #431b9375;
    padding: 1em;
    margin: 1em;
    border: 1px solid #c1c1c1;
    border-radius: 1rem;
    box-shadow: 2px 2px 2px 1px #431b9334;
  }
  .card-title {
    text-align: center;
    color: rgb(0, 0, 0);
    margin-bottom: 2em;
  }
  .texto {
    color: #000000;
    line-height: 2em;
    margin-left: 1em;
    .img-ejemplo {
      margin-right: 3em;
      float: left;
      height: auto;
      max-width: 100%;
    }
    ol {
      margin: 0.5em;
    }
  }
}
.card-content-right {
  width: 70%;
  background: #1976d288;
  padding: 1em;
  margin: 1em;
  border: 1px solid #c1c1c1;
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
  border: 1px solid #c1c1c1;
  border-radius: 1rem;
  box-shadow: 2px 2px 2px 1px #f2575750;
}
</style>
