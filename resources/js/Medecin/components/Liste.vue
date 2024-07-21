<template>
  <div class="shadow-sm p-3 mb-2 bg-body rounded">
        <div class="d-flex">
            <div class="flex-grow-1">
                <p class="fs-6 m-0">
                    <span class="text-secondary">Type: {{type}} | </span>
                    <span class="text-secondary">Fait par: {{madeBy}} | </span>
                    <span class="text-secondary">Créé le: {{dateOfCreation}} | </span>
                    <span class="text-secondary">Montant payé: {{montant}} XOF</span>
                </p>
                <p class="fs-2 m-0 mx-2"> <i class="bi bi-people"></i> {{typeConsultation}}</p>
                <p class="fs-6">
                </p>
            </div>
            <div class="mt-4">
                <a class="btn btn-success" v-bind:href="link">Traiter</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            link: `/accueil/medecin/traiter/${this.id}`
        }
    },
    props: {
        id: Number,
        type: String,
        madeBy: String,
        dateOfCreation: String,
        montant: Number,
        typeConsultation: String,
    },
}
</script>
