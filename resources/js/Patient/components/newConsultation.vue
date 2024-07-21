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
                    <span class="text-secondary">Traité: {{etatText}}</span>
                </p>
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" id="modalBtn">Voir</button>
                <button type="button" class="btn btn-danger mx-2" @click="deleteConsultation">Supprimer</button>
            </div>
            <div class="modal fade modalParent" aria-hidden="true" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg p-3">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information de la consultation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-block mx-3 mb-3 border-bottom border-bottom-1 border-secondary">
                                <p class="fs-3 text-bold text-black">
                                    <span class="fw-bold">Nom et Prénom : </span>
                                    <span>{{madeBy}}</span>
                                </p>
                                <p class="fs-3 text-black">
                                    <span class="fw-bold">Adresse : </span>
                                    <span>{{adresse}}</span>
                                </p>
                                <p class="fs-3 text-black">
                                    <span class="fw-bold">Age : </span>
                                    <span>{{age}}</span>
                                </p>
                                <p class="fs-3 text-black">
                                    <span class="fw-bold">Email : </span>
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
                                    <span class="fw-bold">Traitement de la consultation: </span>
                                    <span>{{etat ? "Terminé" : "En cours"}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Température: </span>
                                    <span>{{temperature}}°C</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Type de maladie: </span>
                                    <span>{{typeMaladie}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Description de la maladie: </span>
                                    <span>{{descMaladie}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Antécedent medicaux: </span>
                                    <span>{{antecedentMedicaux}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Traitement initial: </span>
                                    <span>{{traitementInitial}}</span>
                                </p>
                                <p class="fs-5 font-monospace text-black text-body mb-2">
                                    <span class="fw-bold">Groupe Sangin: </span>
                                    <span>{{groupeSangin}}</span>
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
    emits: ['dConsultation'],
    props: {
        typeConsultation: String,
        type: String,
        madeBy: String,
        adresse: String,
        email: String,
        fullName: String,
        age: Number,
        dateOfCreation: String,
        dateOfValidation: String,
        montant: Number,
        etat: Boolean,
        genre: Boolean,
        temperature: Number,
        typeMaladie: String,
        descMaladie: String,
        antecedentMedicaux: String,
        traitementInitial: String,
        groupeSangin: String,
        index: Number,
        id: Number,
    },
    data() {
        return {
            etatText: this.checkState(),
            target: '',
            m: this.dateOfCreation.split(' ')[1].split(':').join(''),
            userEmail: localStorage.getItem('authPatientEmail')
        }
    },
    created() {
        this.target = ''
    },
    mounted() {
        this.target = `consultationInfo${this.m}`
        let main = document.querySelectorAll(`#app > div > div > div.home_container_right > div.w-100 > div:nth-child(${this.index+1})`)[0],
        x = main.querySelector('#modalBtn'),
        y = main.querySelector('div > div.modal.fade.modalParent')
        x.setAttribute('data-bs-target', `#${this.target}`)
        y.setAttribute('id', this.target)
    },
    methods: {
        checkState: function() {
            return this.etat ? "Oui" : "Non"
        },
        deleteConsultation: function() {
            Swal.fire({
                icon: 'warning',
                title: '&#202;tes-vous sûr?',
                html: 'Vous &#234;tes sur le point de supprimer une consultation',
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuer',
                showClass: { popup: 'animate__animated animate__fadeInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            }).then((r) => {
                if (r.isConfirmed) {
                    axios.post('/api/deleteConsultation', {
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
                            this.$emit('dConsultation')
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
