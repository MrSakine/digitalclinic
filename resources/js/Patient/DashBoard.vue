<template>
    <Head />
    <div class="home_nav_container">
        <d-nav :accueilActive="true" :nbNotifications="0"></d-nav>
        <div class="home_container_right">
            <div class="Home">
                <div class="Home-consultation">
                    <div class="Home-consultation-body">
                        <img src="/storage/images/patient-home.png" width="300"/>
                        <p>Consultations en cours</p>
                    </div>
                    <div class="Home-consultation-footer">
                        <span class="cercle">{{nbConsultations}}</span>
                    </div>
                </div>
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
            <div class="Home">
                <div class="Home-consultation">
                    <div class="Home-consultation-body">
                        <img src="/storage/images/message-image.png" width="200"/>
                        <p>Messages en cours</p>
                    </div>
                    <div class="Home-consultation-footer">
                        <span class="cercle">{{nbMessages}}</span>
                    </div>
                </div>
                <div class="Home-rendez-vous">
                    <div class="Home-rendez-vous-body">
                        <img src="/storage/images/patient-resultat.png" width="300"/>
                        <p>Resultats re&#231;us</p>
                    </div>
                    <div class="Home-rendez-vous-footer">
                        <span class="cercle">{{nbResultats}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DNav from './components/DashBoardNavBar.vue'
import Head from './components/Head.vue'

export default {
    components: {DNav, Head},
    data() {
        return {
            userEmail: localStorage.getItem('authPatientEmail'),
            nbConsultations: 0,
            nbRendezVous: 0,
            nbMessages: 0,
            nbResultats: 0
        }
    },
    methods: {
        getData: function() {
            axios.get('/api/getStats')
            .then(res => {
                let data = res.data
                this.nbConsultations = data.consultations
                this.nbRendezVous = data.rendezvous
                this.nbMessages = data.messages
                this.nbResultats = data.resultats
            })
            .catch(err => console.log(err))
        }
    },
    mounted() {
        this.getData()
    },
}
</script>
