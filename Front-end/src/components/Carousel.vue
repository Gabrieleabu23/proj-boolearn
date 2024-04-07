<script>
import { store } from "../store";

export default {
  data() {
    return {
      store,
      activePage: 0, // Indice della pagina attiva
      itemsPerPage: 1, // Numero di elementi da visualizzare per pagina
      timer: null, // Timer per lo scorrimento automatico
    };
  },
  computed: {
    paginatedReviews() {
      const startIndex = this.activePage * this.itemsPerPage;

      return store.recensioni.slice(startIndex, startIndex + this.itemsPerPage);
    },
  },
  methods: {
    changeNextPage() {
      this.activePage =
        (this.activePage + 1) %
        Math.ceil(this.store.recensioni.length / this.itemsPerPage);
    },

    changePrevPage() {
      this.activePage =
        (this.activePage -
          1 +
          Math.ceil(this.store.recensioni.length / this.itemsPerPage)) %
        Math.ceil(this.store.recensioni.length / this.itemsPerPage);
    },

    // Funzione per intervallo
    intervalImg() {
      this.timer = setInterval(this.changeNextPage, 4000);
    },

    // Funzione per fermare l'intervallo quando il mouse passa sopra
    stopAutoPlay() {
      clearInterval(this.timer);
      this.timer = null;
    },
  },
  mounted() {
    this.intervalImg();
  },
  beforeDestroy() {
    clearInterval(this.timer); // Cancella l'intervallo per evitare perdite di memoria
  },
};
</script>

<template>
  <div class="carosello">
    <div class="container text-center">
      <div class="slider-wrapper" tabindex="0" id="app">
        <!-- Ciclo for sulla pagina attiva -->
        <div
          v-for="review in paginatedReviews"
          :key="review.id"
          @mouseover="stopAutoPlay"
          @mouseout="intervalImg"
        >
          <!-- L'immagine si bloccherà quando il mouse passa sopra -->

          <h5 class="card-title mb-0">{{ review.title }}</h5>
          <p class="card-text">{{ review.description }}</p>
          <p class="card-text">{{ review.date_of_review }}</p>
        </div>
      </div>
      <div class="arrows">
        <i @click="changePrevPage" class="fa-solid fa-arrow-left"></i>
        <i @click="changeNextPage" class="fa-solid fa-arrow-right"></i>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
// SCSS per la sezione del carousel
@use "../styles/partials/variables" as *;
.carosello {
  .slider-wrapper {
    display: flex;
    flex-wrap: wrap;
    background-size: cover;
    padding: 50px 0;
    img {
      max-width: 150px;
      height: auto;
    }
    h1 {
      font-size: 50px;
    }
    p {
      padding-top: 30px;
      color: #7799ad;
      font-size: 20px;
    }
  }
  .arrows {
    display: flex;
    justify-content: space-evenly;
  }
}
</style>
