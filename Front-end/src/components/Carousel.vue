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

    // Formatto la lunghezza della recensione a 200 carratteri
    formatDescription(description) {
      //creo la variabile per settare la formattazione in pagina del testo della recensione
      let maxLength = 0;

      let larghezzaFinestra = window.innerWidth;

      //gestisco con uno switch le varie grandezze dello schermo
      switch (true) {
        case larghezzaFinestra < 500:
          maxLength = 25;
          break;
        case larghezzaFinestra >= 500 && larghezzaFinestra < 600:
          maxLength = 30;
          break;
        case larghezzaFinestra >= 600 && larghezzaFinestra <= 767:
          maxLength = 45;
          break;
        case larghezzaFinestra >= 768 && larghezzaFinestra <= 1000:
          maxLength = 30;
          break;
        case larghezzaFinestra >= 1001 && larghezzaFinestra <= 1200:
          maxLength = 45;
          break;
        case larghezzaFinestra >= 1201 && larghezzaFinestra <= 1500:
          maxLength = 60;
          break;
        case larghezzaFinestra >= 1501 && larghezzaFinestra <= 1700:
          maxLength = 85;
          break;
        case larghezzaFinestra >= 1701:
          maxLength = 100;
          break;
      }

      console.log(maxLength);

      // se la recensione è più lunga di un tot
      if (description.length > maxLength) {
        let formattedDescription = "";
        for (let i = 0; i < description.length; i++) {
          //controllo che la posizione dell'ennesimo carattere sia la designata per mandare a capo il testo o un suo multiplo
          if (i > 0 && i % maxLength === 0) {
            //forzo ad andare a capo inserendo il carattere "\n" in quella posizione
            formattedDescription += "\n";
          }
          formattedDescription += description[i];
        }
        return formattedDescription;
      } else {
        return description;
      }
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
          <!-- La card si bloccherà quando il mouse passa sopra -->

          <h5 class="card-title mb-0">{{ review.title }}</h5>

          <!-- mi assicuro che la descrizione entri in pagina correttamente -->

          <p class="card-text">{{ formatDescription(review.description) }}</p>

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

    .card-text {
      max-width: 100%; /* Imposta la larghezza massima al 100% della larghezza del contenitore */
      word-wrap: break-word; /* Assicura che le parole lunghe si spezzino quando superano la larghezza massima */
    }
  }
  .arrows {
    display: flex;
    justify-content: space-evenly;
  }
}
</style>
