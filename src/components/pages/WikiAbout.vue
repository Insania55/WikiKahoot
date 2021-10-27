<template>
  <div id="about">
    <header>
      <h2 class="title">
        Acerca de
        <span><img src="../../assets/logo.png" alt="Logo WikiKahoot" /></span>
      </h2>
      <p class="cita">
        <cite> Play is the Highest Form of Research </cite>
        Albert Einstein
      </p>
    </header>
    <main>
      <div class="main-description">
        <p>
          <svg
            aria-hidden="true"
            focusable="false"
            data-prefix="fas"
            data-icon="list-check"
            class="svg-inline--fa fa-list-check"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
          >
            <path
              fill="currentColor"
              d="M118.2 199.9L63.09 261.1l-22.12-22.11c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l40 40C51.53 317.5 57.66 320 63.1 320c.2187 0 .4065 0 .6253-.0156c6.594-.1719 12.81-3.031 17.22-7.922l72-80c8.875-9.859 8.062-25.03-1.781-33.91C142.2 189.3 127.1 190.1 118.2 199.9zM118.2 39.94L63.09 101.1l-22.12-22.11c-9.375-9.375-24.56-9.375-33.94 0s-9.375 24.56 0 33.94l40 40C51.53 157.5 57.66 160 63.1 160c.2187 0 .4065 0 .6253-.0156c6.594-.1719 12.81-3.031 17.22-7.922l72-80c8.875-9.859 8.062-25.03-1.781-33.91C142.2 29.31 127.1 30.09 118.2 39.94zM48 367.1c-26.51 0-48 21.49-48 48c0 26.51 21.49 48 48 48s48-21.49 48-48C96 389.5 74.51 367.1 48 367.1zM256 128h224c17.67 0 32-14.33 32-32s-14.33-32-32-32h-224C238.3 64 224 78.33 224 96S238.3 128 256 128zM480 224h-224C238.3 224 224 238.3 224 256s14.33 32 32 32h224c17.67 0 32-14.33 32-32S497.7 224 480 224zM480 384H192c-17.67 0-32 14.33-32 32s14.33 32 32 32h288c17.67 0 32-14.33 32-32S497.7 384 480 384z"
            ></path>
          </svg>
          Proyecto impulsado por profesores de los centros educativos IES Poeta
          Paco Mollá, IES Azorín e IES La Canal.
        </p>
        <p>
          <svg
            aria-hidden="true"
            focusable="false"
            data-prefix="fas"
            data-icon="code"
            class="svg-inline--fa fa-code"
            role="img"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 640 512"
          >
            <path
              fill="currentColor"
              d="M416 31.94C416 21.75 408.1 0 384.1 0c-13.98 0-26.87 9.072-30.89 23.18l-128 448c-.8404 2.935-1.241 5.892-1.241 8.801C223.1 490.3 232 512 256 512c13.92 0 26.73-9.157 30.75-23.22l128-448C415.6 37.81 416 34.85 416 31.94zM176 143.1c0-18.28-14.95-32-32-32c-8.188 0-16.38 3.125-22.62 9.376l-112 112C3.125 239.6 0 247.8 0 255.1S3.125 272.4 9.375 278.6l112 112C127.6 396.9 135.8 399.1 144 399.1c17.05 0 32-13.73 32-32c0-8.188-3.125-16.38-9.375-22.63L77.25 255.1l89.38-89.38C172.9 160.3 176 152.2 176 143.1zM640 255.1c0-8.188-3.125-16.38-9.375-22.63l-112-112C512.4 115.1 504.2 111.1 496 111.1c-17.05 0-32 13.73-32 32c0 8.188 3.125 16.38 9.375 22.63l89.38 89.38l-89.38 89.38C467.1 351.6 464 359.8 464 367.1c0 18.28 14.95 32 32 32c8.188 0 16.38-3.125 22.62-9.376l112-112C636.9 272.4 640 264.2 640 255.1z"
            ></path>
          </svg>
          Desarrollado por los alumnos del ciclo formativo de grado superior de
          la especialidad de informática Desarrollo de Aplicaciones Web del IES
          Poeta Paco Mollá.
        </p>
      </div>
      <section>
        <h3>Alumnos participantes en la primera fase de desarrollo</h3>
        <ul>
          <li>
            Jorge Pérez Expósito
            <span
              ><a href="https://github.com/jorgepexp" target="_blank"
                ><i class="fab fa-github"></i
              ></a>
              <a href="mailto:jorge.pexp@gmail.com" target="_blank">
                <i class="fas fa-paper-plane"></i
              ></a>
            </span>
          </li>
          <li>
            Sergio Fernández Jiménez
            <span><i class="fas fa-paper-plane"></i></span>
          </li>
          <li>
            David Sánchez López <span><i class="fas fa-paper-plane"></i></span>
          </li>
          <li>Ricardo Candel Gil</li>
        </ul>
      </section>
    </main>
  </div>
</template>

<script>
export default {
  name: "About",
  data() {
    return {};
  },
};
</script>
<style lang="scss">
#about {
  header {
    .title {
      margin: 0.4rem 0 1rem 0;
      text-align: center;

      h2 {
        font-size: 20px;
      }

      img {
        height: 60px;
        width: 100px;

        position: relative;
        top: 15px;
      }
    }

    .cita {
      width: 50%;

      display: flex;
      flex-direction: column;
      align-items: center;
      line-height: 1.5rem;

      background-color: #431b9375;
      box-shadow: 4px 5px 5px 0px darkmagenta;
      border: 1px solid #8b008b;
      border-radius: 5px;

      padding: 1rem;
      margin: 0 auto;
      margin-bottom: 1.2rem;

      cite {
        font-weight: 600;
      }
    }
  }
  .main-description {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    flex-direction: column;

    background: #bcc;

    line-height: 2rem;

    padding: 1.6rem;
    margin: 0 auto;
    margin-bottom: 1rem;
  }

  section {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    h3 {
      font-size: 20px;

      margin: 1rem 0;
      // margin-bottom: 0.8rem;
    }

    ul {
      display: block;
      margin-left: -10px;
    }

    ul li {
      display: block;
      position: relative;

      span {
        a,
        a:visited,
        a:active {
          color: inherit;
        }
      }

      i {
        font-size: 18px;
        margin-right: 5px;
      }
    }

    ul li:not(:last-child) {
      margin-bottom: 16px;
    }

    ul li:before {
      content: "";
      position: absolute;
      top: 1.2em;
      left: -25px;
      margin-top: -0.9em;
      background: #1c612d;
      height: 12px;
      width: 12px;
      border-radius: 50%;
    }
  }

  svg.svg-inline--fa {
    position: relative;
    top: 2px;

    width: 15px;
    height: 15px;
  }
}
</style>