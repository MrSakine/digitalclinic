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
                        <span class="text-secondary mx-2"><span class="mr-2">Pour:</span> {{patient_to}} | </span>
                    </p>
                    <p class="fs-6">
                        <span class="text-secondary">Le: {{date}}</span>
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a :href="startMessageLink" class="btn btn-secondary" target="_blank">Parler</a>
                <button type="button" class="btn btn-danger mx-2" @click="deleteBoiteDialogue">Supprimer</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            userEmail: localStorage.getItem('authMedecinEmail'),
            startMessageLink: null
        }
    },
    props: {
        id: Number,
        medecin_from: String,
        patient_to: String,
        date: String,
        typeConsultation: String,
        index: Number
    },
    emits: ['dBoite'],
    mounted() {
        this.startMessageLink = `/accueil/medecin/start-conversation/${this.id}`
    },
    methods: {
        deleteBoiteDialogue: function() {
            Swal.fire({
                icon: 'warning',
                title: '&#202;tes-vous sûr?',
                html: 'Vous &#234;tes sur le point de supprimer une boite de dialogue',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuer',
                showClass: { popup: 'animate__animated animate__fadeInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            }).then((r) => {
                if (r.isConfirmed) {
                    axios.post('/api/dBD', {
                        id: this.id
                    })
                    .then(rep => {
                        if (rep.data.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: rep.data.message
                            })
                            this.$emit('dBoite')
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur est survenue, veuillez reessayer'
                            })
                        }
                    })
                    .catch(err => console.log(err.response.data))
                }
            })
        }
    },
}
</script>
