<template>
    <div class="home_nav_left">
        <ul class="nav flex-column">
            <li class="nav-item"
            data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
            data-aos-offset="500"
             data-aos-duration="500"
            >
                <router-link :to="{ name: 'medecin-accueil' }" v-bind:class="AccueilActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-house mx-2"></i>Accueil
                </router-link>
            </li>
            <li class="nav-item"
            data-aos="zoom-out"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
             data-aos-duration="600">
                <router-link :to="{ name: 'medecin-agenda' }" :class="agendaActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-calendar mx-2"></i>Agenda
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="700">
                <router-link :to="{ name: 'medecin-liste' }" v-bind:class="listeConsultationActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-person mx-2"></i>Consultations
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="700">
                <router-link :to="{name: 'medecin-rdv'}" v-bind:class="rdvActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-calendar mx-2"></i>Rendez-vous
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="800">
                <router-link :to="{ name: 'medecin-specialites' }" :class="specialiteActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-award mx-2"></i>Spécialités
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="900">
                <router-link :to="{name: 'medecin-liste-traites'}" v-bind:class="consultationTraiterActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-plus-square mx-2"></i>Traitements
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="1000">
                <router-link :to="{ name: 'medecin-message' }" v-bind:class="MessageActive ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-chat mx-2"></i>Messages
                </router-link>
            </li>
            </ul>
    </div>
</template>

<script>
import Title from "./Title.vue"
import Logout from './Logout.vue'

export default {
    components:{ Title, Logout },
    props: {
        AccueilActive: Boolean,
        agendaActive: Boolean,
        specialiteActive: Boolean,
        listeConsultationActive: Boolean,
        MessageActive: Boolean,
        consultationTraiterActive: Boolean,
        NotificationActive: Boolean,
        NbNotifications: Number,
        rdvActive: Boolean
    },
};
</script>
