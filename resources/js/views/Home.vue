<template>
    <div id="appHome" style="overflow: hidden;">
        <nav-bar :accueilActive="true"></nav-bar>
        <div  id="section">
            <div id="section__title">
                <div  data-aos="slide-right" data-aos-duration="1000" data-aos-once="true" class="section__title-image">
                    <img src="/storage/images/home.svg" alt="Logo" width="650" height="650">
                </div>
                <div class="section__title-text">
                    <h1  data-aos="slide-down" data-aos-duration="1000" >Système de consultation en ligne</h1>
                    <p  data-aos="slide-left" data-aos-duration="1000">
                        Faites vos consultations en ligne depuis votre maison, votre poste de travail ou n'importe où avec une connexion internet.
                    </p>
                    <router-link :to="{name: 'inscription'}">
                        <button data-aos="flip-left" data-aos-duration="10000" data-aos-once="true" class="navbar__right_button-signup">S'inscrire</button>
                    </router-link>
                </div>
            </div>
            <div data-aos="fade"  id="section__consultation">
                <div class="section__consultation-text">
                    <h1 data-aos="slide-down" data-aos-duration="10000" data-aos-once="true">Consultation en ligne</h1>
                    <p data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true">
                        Soumettez votre <u class="consultation-info" data-title="Fiche contenant vos problèmes de santé">fiche de consultation</u> et attendez son traitement. Vous recevrez un résultat après traitement de votre demande par un professionel de santé
                    </p>
                </div>
                <div  data-aos="slide-right" data-aos-duration="1000" data-aos-once="true" class="section__consultation-image">
                    <img src="/storage/images/consultation.png" alt="Consultation en ligne" width="600" height="500">
                </div>
            </div>

            <div data-aos="fade" data-aos-duration="100" data-aos-once="true" id="section__rendezvous">
                <div  data-aos="slide-left" data-aos-duration="1000" data-aos-once="true" class="section__rendezvous-image">
                    <img src="/storage/images/meeting.png" alt="Meeting" width="600" height="500">
                </div>
                <div data-aos="zoom-in" data-aos-duration="1000" data-aos-once="true" class="section__rendezvous-text">
                    <h1>Rendez-vous physique</h1>
                    <p>
                        Créer vos <u class="rendezvous-info" data-title="Consulation physique">rendez-vous</u> pour pouvoir parler physiquement à un professionel de santé. La création d'un rendez-vous vient avec un jusitifcatif que vous devez montrer comme preuve de rendez-vous
                    </p>
                </div>
            </div>
            <div data-aos="flip-up" data-aos-duration="1000" data-aos-once="true" id="section__conversation">
                <div  class="section__conversation-title">
                    <h1  data-aos="fade-down" data-aos-duration="1200" data-aos-once="true">Discussion intégré</h1>
                </div>
                <div class="section__conversation-content">
                    <p data-aos="fade-up" data-aos-duration="1200" data-aos-once="true">
                        Discuter avec un professionel de santé s'il a besoin de plus d'informations pour traiter votre demande ou si vous voulez lui donner plus d'informations pour l'aider à bien comprendre votre demande
                    </p>
                </div>
            </div>
            <div  id="section__professionels">
                <div class="section__professionels-text">
                    <h1 data-aos="fade-right" data-aos-duration="1200" data-aos-once="true">Mettre en place son agenda</h1>
                    <p  data-aos="slide-right" data-aos-duration="1200" data-aos-once="true">
                        Pour les professionels de santé, créer vos horaires de disponibilité pendant la semaine pour les prises de rendez-vous. Pour chaque rendez-vous, la personne concernée doit montrer son jusitifcatif
                    </p>
                </div>
                <div class="section__professionels-image">
                    <img data-aos="slide-left" data-aos-duration="1000" data-aos-once="true" src="/storage/images/agenda.jpg" alt="Agenda" width="700" height="500">
                </div>
            </div>
        </div>
        <Footer/>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Footer from '../components/Footer.vue'

export default {
    components: {NavBar, Footer},
}
</script>
