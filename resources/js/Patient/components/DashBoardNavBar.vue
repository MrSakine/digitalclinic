<template>
    <div class="home_nav_left">
        <ul class="nav flex-column">
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="500">
            <router-link :to="{name: 'accueil'}" v-bind:class="accueilActive ? 'nav-link active': 'nav-link'">
                <i class="bi bi-house mx-2"></i>Accueil
                </router-link>
            </li>
            <li class="nav-item"
            data-aos="zoom-out"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
             data-aos-duration="600">
                <router-link :to="{name: 'consultation-online'}" v-bind:class="faireConsultation ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-person mx-2"></i>Consultations
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="700">
                <router-link :to="{name: 'rendez-vous'}" v-bind:class="prendreRendezVous ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-calendar mx-2"></i>Rendez-vous
                </router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="800">
                <router-link :to="{name: 'messages'}" v-bind:class="gererMessages ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-chat mx-2"></i>Messages</router-link>
            </li>
            <li class="nav-item"
             data-aos="zoom-out"
             data-aos-anchor="#example-anchor"
             data-aos-offset="500"
             data-aos-duration="900">
                <router-link :to="{name: 'resultats'}" v-bind:class="resultatConsultation ? 'nav-link active' : 'nav-link'">
                    <i class="bi bi-plus-square mx-2"></i>Resultats</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        accueilActive: Boolean,
        faireConsultation: Boolean,
        prendreRendezVous: Boolean,
        gererMessages: Boolean,
        gererNotifications: Boolean,
        resultatConsultation: Boolean,
        nbNotifications: Number,
		tableauBord: Boolean
    },
}
</script>
