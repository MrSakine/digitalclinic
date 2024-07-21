<template>
    <div class="shadow-sm p-3 mb-2 bg-body rounded">
        <div class="d-flex">
            <div class="flex-grow-1">
                <span class="text-secondary">Boite de dialogue {{index + 1}}</span>
                <p class="fs-2 m-0 mx-2"> <i class="bi bi-people"></i> {{typeConsultation}}</p>
                <div class="d-flex flex-row">
                    <p class="fs-6">
                        <span class="text-secondary"><span class="mr-2">De:</span> {{medecin_from}} | </span>
                    </p>
                    <p class="fs-6">
                        <span class="text-secondary mx-2">Le: {{date}}</span>
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a :href="startMessageLink" class="btn btn-secondary" target="_blank">Parler</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userEmail: localStorage.getItem('authPatientEmail'),
            startMessageLink: null
        }
    },
    props: {
        id: Number,
        medecin_from: String,
        date: String,
        typeConsultation: String,
        index: Number
    },
    mounted() {
        this.startMessageLink = `/accueil/patient/start-conversation/${this.id}`
    },
}
</script>