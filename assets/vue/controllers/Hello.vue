
<template>
    <div>
        Blalala
      <button @click="startRace" :disabled="raceStarted">Run Race</button>
      <div v-if="countdown > 0" class="countdown">Race starts in {{ countdown }} seconds</div>
      <div v-if="raceStarted" class="race-track-container" :style="{ width: raceLength + 'px' }">
        <div class="race-track" :style="trackStyle">
          <div v-for="(horse, index) in horses" :key="index" class="horse" :style="horseStyle(horse)">
            <span>{{ horse.name }}</span>
            <img :src="horse.image" alt="Horse" />
          </div>
        </div>
      </div>
      <div v-if="showResults" class="results-modal">
        <h2>Race Results</h2>
        <ul>
          <li v-for="(horse, index) in horses" :key="index">{{ horse.name }}: {{ horse.distance }}px</li>
        </ul>
      </div>
      <div v-if="showModal" class="modal">
        <div class="modal-content">
          <div v-if="loading" class="loader"></div>
          <p>{{ modalMessage }}</p>
          <button v-if="error" @click="retryFetchRaceData">Relancer</button>
        </div>
      </div>
    </div>
  </template>

<script>
   import Horse from '../models/Horse.js';
   export default {
  data() {
    return {
      raceLength: 18000,
      horses: [],
      showResults: false,
      raceStarted: false,
      countdown: 0,
      raceInterval: null,
      showModal: false,
      loading: false,
      error: false,
      modalMessage: '',
      playerHorse: null, // Ajout de l'attribut pour suivre le cheval du joueur
    };
  },
  methods: {
    horseStyle(horse) {
      return {
        left: horse.distance + 'px',
      };
    },
    startRace() {
      this.showModal = true;
      this.loading = true;
      this.modalMessage = 'Création de la course';
      this.fetchRaceData().then(data => {
        if (data.success) {
          this.modalMessage = 'Choix des jockeys et attribution des chevaux';
          setTimeout(() => {
            this.horses = data.horses;
            this.playerHorse = this.horses[0]; // Supposons que le premier cheval est celui du joueur
            this.modalMessage = 'Starting Race';
            setTimeout(() => {
              this.showModal = false;
              this.countdown = 5;
              this.startCountdown();
            }, 1000);
          }, 2000); // Simuler le temps de choix des jockeys
        } else {
          this.loading = false;
          this.error = true;
          this.modalMessage = 'Une erreur est survenue';
        }
      }).catch(() => {
        this.loading = false;
        this.error = true;
        this.modalMessage = 'Une erreur est survenue';
      });
    },
    startCountdown() {
      const countdownInterval = setInterval(() => {
        this.countdown--;
        if (this.countdown <= 0) {
          clearInterval(countdownInterval);
          this.raceStarted = true;
          this.runRace();
        }
      }, 1000);
    },
    runRace() {
      this.raceInterval = setInterval(() => {
        let allFinished = true;
        this.horses.forEach(horse => {
          horse.move();
          if (horse.distance < this.raceLength) {
            allFinished = false;
          }
        });
        if (allFinished) {
          clearInterval(this.raceInterval);
          this.showResults = true;
        }
      }, 100); // Ajustez l'intervalle selon vos besoins
    },
    fetchRaceData() {
      return new Promise((resolve, reject) => {
        // Simuler la récupération des données de la course
        setTimeout(() => {
          const horses = [
            new Horse("Horse1", "horse1.png", 40, 60, 55, 80),
            new Horse("Horse2", "horse2.png", 35, 55, 60, 75),
            new Horse("Horse3", "horse3.png", 45, 65, 50, 85),
            // Ajoutez jusqu'à 8 chevaux
          ];
          resolve({ success: true, horses });
        }, 1000);
      });
    },
    retryFetchRaceData() {
      this.error = false;
      this.loading = true;
      this.modalMessage = 'Création de la course';
      this.fetchRaceData().then(data => {
        if (data.success) {
          this.modalMessage = 'Choix des jockeys et attribution des chevaux';
          setTimeout(() => {
            this.horses = data.horses;
            this.playerHorse = this.horses[0]; // Supposons que le premier cheval est celui du joueur
            this.modalMessage = 'Starting Race';
            setTimeout(() => {
              this.showModal = false;
              this.countdown = 5;
              this.startCountdown();
            }, 1000);
          }, 2000); // Simuler le temps de choix des jockeys
        } else {
          this.loading = false;
          this.error = true;
          this.modalMessage = 'Une erreur est survenue';
        }
      }).catch(() => {
        this.loading = false;
        this.error = true;
        this.modalMessage = 'Une erreur est survenue';
      });
    },
  },
  computed: {
    trackStyle() {
      if (this.playerHorse) {
        const viewWidth = window.innerWidth;
        const viewHalf = viewWidth / 2;
        const horseCenter = this.playerHorse.distance + 50; // 50 est la moitié de la largeur du cheval
        const scrollPosition = horseCenter - viewHalf;
        return {
          transform: `translateX(-${scrollPosition}px)`,
        };
      }
      return {};
    },
  },
};
</script>

<style>
.race-track-container {
  position: relative;
  height: 200px;
  background-color: #8bc34a;
  overflow: hidden;
}

.race-track {
  position: absolute;
  width: 100%;
  height: 100%;
  transition: transform 0.1s ease-out;
}

.horse {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
}

.horse span {
  margin-bottom: 10px;
  font-weight: bold;
}

.horse img {
  width: 100px;
  height: 100px;
}

.results-modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.countdown {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-top: 20px;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
}

.loader {
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>