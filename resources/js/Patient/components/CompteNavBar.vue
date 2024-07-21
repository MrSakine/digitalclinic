<template>
    <div class="d-flex">
        <div class="flex-grow-1">
            <p class="fs-1 p-3 mb-4">Digital Clinic</p>
        </div>
        <div class="mt-4">
            <i class="bi bi-x-lg" style="cursor:pointer;font-size: 20px;" @click="goBackToHome"></i>
        </div>
    </div>
    <nav class="fs-4 mb-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <router-link
                :to="{name: 'mon-compte'}"
                v-bind:class="monCompte ? 'nav-link active text-primary' : 'nav-link text-secondary'">Mon Compte</router-link>
            </li>
            <li class="nav-item">
                <router-link
                :to="{name: 'payment'}"
                v-bind:class="payment ? 'nav-link active text-primary' : 'nav-link text-secondary'">Mes paiements</router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        monCompte: Boolean,
        payment: Boolean
    },
    methods: {
        goBackToHome: function() {
            this.$router.push({name: 'accueil'})
        }
    },
}
</script>
