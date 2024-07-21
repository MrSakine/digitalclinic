<template>
    <loading v-if="showLoading" :text="text" />
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
                <button type="button" class="btn btn-warning mx-2 text-white" @click="saveDocs">Telecharger</button>
            </div>
        </div>
    </div>
</template>

<script>
import { jsPDF } from "jspdf"
import Loading from '../../components/Loading.vue'

export default {
    props: {
        type: String,
        madeBy: String,
        madeByAge: Number,
        madeByAdresse: String,
        dateOfCreation: String,
        dateOfValidation: String,
        montant: Number,
        etat: Boolean,
        medecin: String,
        medecinAge: Number,
        medecinAdresse: String,
        typeConsultation: String,
        temperature: Number,
        groupeSangin: String,
        typeMaladie: String,
        descriptionMaladie: String,
        antMedicaux: String,
        traitementInitial: String,
        conseil: String,
        diagnostic: String,
        observation: String,
        ordo: Array
    },
    data() {
        return {
            etatText: this.checkState(),
            m: this.dateOfValidation.split(' ')[1].split(':').join(''),
            showLoading: false,
            text: ''
        }
    },
    components: {Loading},
    methods: {
        checkState: function() {
            return this.etat ? "Oui" : "Non"
        },
        saveDocs: function() {
            this.showLoading = true
            this.text = 'Preparation du fichier'
            setTimeout(() => {
                var doc = new jsPDF()
                doc.setFont("helvetica", "bold")
                doc.setFontSize(15)
                doc.text(this.madeBy, 20, 10)
                doc.text(this.madeByAdresse, 20, 20)
                doc.text(this.medecin, 200, 35, null, null, "right")
                doc.text(this.medecinAdresse, 200, 45, null, null, "right")
                doc.text('Details de la consultation:', 100, 65, null, null, "center")
                doc.setFont('courier', 'normal')
                doc.text('Créé le: ' + this.dateOfCreation, 20, 80)
                doc.text('Validé le: ' + this.dateOfValidation, 20, 90)
                doc.text('Type de consultation: ' + this.typeConsultation, 20, 100)
                doc.text('Montant paye: ' + this.montant, 20, 110)
                doc.text('Type de la maladie: ' + this.typeMaladie, 20, 120)
                doc.text('Description de la maladie: ' + this.descriptionMaladie, 20, 130)
                doc.text('Temperature: ' + this.temperature, 20, 140)
                doc.text('Groupe Sangin: ' + this.groupeSangin, 20, 150)
                doc.text('Antecedent medicaux: ' + this.antMedicaux, 20, 160)
                doc.text('Traitement initial: ' + this.traitementInitial, 20, 170)
                doc.setFont("helvetica", "bold")
                doc.text('Details du resultat:', 100, 190, null, null, "center")
                doc.setFont('courier', 'normal')
                doc.text('Observation: ' + this.observation, 20, 205)
                doc.text('Diagnostic: ' + this.diagnostic, 20, 215)
                doc.text('Conseil: ' + this.conseil, 20, 225)
                if (this.ordo) {
                    doc.text('Ordonnances: ', 20, 235)
                    let i = 235, f = doc.getFontSize()
                    for(const j of this.ordo) {
                        let text = `Medicament: ${j.medicament} | Posologie: ${j.modeEmploi} | Quantite: ${j.quantite}`
                        doc.setFontSize(12)
                        i += 10
                        doc.text(text, 20, i)
                        doc.setFontSize(f)
                    }
                }else{
                    doc.text('Ordonnances: Indefini', 20, 235)
                }
                doc.save(`Resultat#${this.m}.pdf`)
                this.showLoading = false
            }, 1000)
        }
    },
}
</script>
