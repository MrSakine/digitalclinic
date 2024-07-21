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
                <a href="#" class="nav-link active text-primary">Mon Compte</a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    methods: {
        goBackToHome: function() {
            this.$router.push({name: 'medecin-accueil'})
        }
    },
}
</script>
