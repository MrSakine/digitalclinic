<template>
    <Head />
    <div class="home_nav_container">
        <NavBar :AccueilActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <div class="Home">
                <div class="Home-consultation">
                    <div class="Home-consultation-body">
                        <img src="/storage/images/patient-home.png" width="300"/>
                        <p>Consultation en cours</p>
                    </div>
                    <div class="Home-consultation-footer">
                        <span class="cercle">{{nbConsultations}}</span>
                    </div>
                </div>
                <div class="Home-rendez-vous">
                    <div class="Home-rendez-vous-body">
                        <img src="/storage/images/medecin-traitement.png" width="230"/>
                        <p>Traitement effectués</p>
                    </div>
                    <div class="Home-rendez-vous-footer">
                        <span class="cercle">{{nbTraitement}}</span>
                    </div>
                </div>
            </div>
            <div class="Home">
                <div class="Home-rendez-vous">
                    <div class="Home-rendez-vous-body">
                        <img src="/storage/images/patient-home-rendezvous.png" width="300"/>
                        <p>Rendez-vous en cours </p>
                    </div>
                    <div class="Home-rendez-vous-footer">
                        <span class="cercle">{{nbRendezVous}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from './components/NavBar.vue'
import Ordonnance from './components/Ordonnance.vue'
import Head from './components/Head.vue'

export default {
  components: { NavBar, Ordonnance, Head },
  mounted() {
    this.getStats()
  },
  data() {
    return {
        nbConsultations: 0,
        nbTraitement: 0,
        nbRendezVous: 0
    }
  },
  methods: {
    getStats: function() {
        axios.get('/api/getMedStats')
        .then(res => {
            let data = res.data
            this.nbConsultations = data.consultations
            this.nbTraitement = data.traitements
            this.nbRendezVous = data.rendezvous
        })
        .catch(err => console.log(err))
    }
  },
}
</script>
