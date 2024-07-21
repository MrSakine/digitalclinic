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
                    <span class="text-secondary">Traité: {{etatText}} |  </span>
                    <span class="text-secondary">Par: {{medecin}} | </span>
                    <span class="text-secondary">Le: {{dateOfValidation}}</span>
                </p>
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-secondary mx-2 text-white" data-bs-toggle="modal" id="modalBtn">Voir</button>
            </div>
            <div class="modal fade" aria-hidden="true" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg p-3">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Information du resultat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="float-start">
                                <span class="fs-2 mb-3 text-decoration-underline">Details du patient</span>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Nom et Prenom: </span>
                                    <span>{{madeBy}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Age: </span>
                                    <span>{{madeByAge}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Adresse: </span>
                                    <span>{{madeByAdresse}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Telephone: </span>
                                    <span>{{madeByPhone}}</span>
                                </p>
                            </div>
                            <div class="float-end">
                                <span class="fs-2 mb-3 text-decoration-underline">Details du medecin</span>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Nom et Prenom: </span>
                                    <span>{{medecin}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Age: </span>
                                    <span>{{medecinAge}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Adresse: </span>
                                    <span>{{medecinAdresse}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Telephone: </span>
                                    <span>{{medecinPhone}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="border-top border-top-1 border-secondary">
                            <div class="mt-3 p-2 mx-2">
                                <p class="fw-bold text-decoration-underline fs-2">Fiche de consultation:</p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Type de consultation: </span>
                                    <span>{{typeConsultation}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Date de creation: </span>
                                    <span>{{dateOfCreation}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Date de validation: </span>
                                    <span>{{dateOfValidation}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Groupe Sangin: </span>
                                    <span>{{groupSangin}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Temperature: </span>
                                    <span>{{temperature}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Type de maladie: </span>
                                    <span>{{typeMaladie}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Description de la maladie: </span>
                                    <span>{{descriptionMaladie}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Antecedent medicaux: </span>
                                    <span>{{antecedentMedicaux}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Traitement initial: </span>
                                    <span>{{traitementInitial}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="border-top border-top-1 border-secondary">
                            <div class="mt-3 p-2 mx-2">
                                <p class="fw-bold text-decoration-underline fs-2">Fiche de resultat:</p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Conseil: </span>
                                    <span>{{conseil}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Diagnostic: </span>
                                    <span>{{diagnostic}}</span>
                                </p>
                                <p class="fs-6 font-monospace text-black text-body mb-1">
                                    <span class="fw-bold">Observation: </span>
                                    <span>{{observation}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="border-top border-top-1 border-secondary">
                            <div class="mt-3 p-2 mx-2">
                                <p class="fw-bold text-decoration-underline fs-2">Fiche d'ordonnances:</p>
                                <n-ordo-format :objects="ordo" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import nOrdoFormat from './nOrdoFormat.vue'

export default {
    components: {nOrdoFormat},
    props: {
        id: Number,
        type: String,
        madeBy: String,
        madeByAdresse: String,
        madeByAge: Number,
        madeByPhone: String,
        madeByEmail: String,
        dateOfCreation: String,
        dateOfValidation: String,
        groupSangin: String,
        temperature: Number,
        typeMaladie: String,
        descriptionMaladie: String,
        antecedentMedicaux: String,
        traitementInitial: String,
        montant: Number,
        etat: Boolean,
        medecin: String,
        medecinAge: Number,
        medecinAdresse: String,
        medecinPhone: String,
        typeConsultation: String,
        index: Number,
        conseil: String,
        observation: String,
        diagnostic: String,
        ordo: Array
    },
    data() {
        return {
            etatText: this.checkState(),
            m: this.dateOfValidation.split(' ')[1].split(':').join('')
        }
    },
    methods: {
        checkState: function() {
            return this.etat ? "Oui" : "Non"
        }
    },
    mounted() {
        this.target = `resultatInfo${this.m}`
        let main = document.querySelectorAll(
            `#app > div > div.home_nav_container > div.home_container_right > div.container > div:nth-child(${this.index+1})`
        )[this.index === 0 ? this.index : 0],
        x = main.querySelector('#modalBtn'),
        y = main.querySelector('div > div.modal.fade')
        x.setAttribute('data-bs-target', `#${this.target}`)
        y.setAttribute('id', this.target)
    },
}
</script>
