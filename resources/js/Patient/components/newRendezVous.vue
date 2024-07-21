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
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" id="modalBtn">Voir</button>
                <button type="button" class="btn btn-danger mx-2" @click="deleteRendezVous">Supprimer</button>
            </div>
            <div class="modal fade" aria-hidden="true" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg p-3">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information du rendez vous</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-block mx-3 mb-3 border-bottom border-bottom-1 border-secondary">
                                <p class="fs-3 text-bold text-black">
                                    <span class="fw-bold">Nom et Prénom : </span>
                                    <span>{{madeBy}}</span>
                                </p>
                                <p class="fs-3 text-bold text-black">
                                    <span class="fw-bold">Adresse : </span>
                                    <span>{{adresse}}</span>
                                </p>
                                <p class="fs-3 text-bold text-black">
                                    <span class="fw-bold">Age : </span>
                                    <span>{{age}}</span>
                                </p>
                                <p class="fs-3 text-bold text-black">
                                    <span class="fw-bold">Adresse mail : </span>
                                    <span>{{email}}</span>
                                </p>
                            </div>
                            <div class="d-block mx-3 mb-3">
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Type de consultation: </span>
                                    <span>{{type}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Montant payé: </span>
                                    <span>{{montant}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Date de création: </span>
                                    <span>{{dateOfCreation}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Heure: </span>
                                    <span>{{meetingData[0]}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Médecin: </span>
                                    <span>{{meetingData[1]}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ['dRendezVous'],
    props: {
        type: String,
        typeConsultation: String,
        madeBy: String,
        email: String,
        adresse: String,
        age: Number,
        dateOfCreation: String,
        meetingData: Array,
        montant: Number,
        index: Number,
        id: Number,
    },
    data() {
        return {
            target: '',
            m: this.dateOfCreation.split(' ')[1].split(':').join(''),
            userEmail: localStorage.getItem('authPatientEmail')
        }
    },
    mounted() {
        this.target = `consultationInfo${this.m}`
        let main = document.querySelectorAll(`#app > div > div > div.home_container_right > div.w-100 > div:nth-child(${this.index+1})`)[0],
        x = main.querySelector('#modalBtn'),
        y = main.querySelector('div.modal.fade')
        x.setAttribute('data-bs-target', `#${this.target}`)
        y.setAttribute('id', this.target)
    },
    methods: {
        deleteRendezVous: function() {
            Swal.fire({
                icon: 'warning',
                title: '&#202;tes-vous sûr?',
                html: 'Vous &#234;tes sur le point de supprimer un rendez-vous',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuer',
                showClass: { popup: 'animate__animated animate__fadeInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            }).then((r) => {
                if (r.isConfirmed) {
                    axios.post('/api/deleteRendezVous', {
                        user: this.userEmail,
                        id: this.id
                    })
                    .then((rep) => {
                        if (rep.data.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: rep.data.message
                            })
                            this.$emit('dRendezVous')
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur est survenue, veuillez reessayer'
                            })
                        }
                    })
                    .catch(err => console.log(err))
                }
            })
        }
    },
}
</script>
