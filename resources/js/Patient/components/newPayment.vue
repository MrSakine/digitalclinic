<template>
    <loading v-if="showLoading" :text="text" />
    <div class="shadow-sm p-3 mb-2 bg-body rounded">
        <div class="d-flex">
            <div class="flex-grow-1">
                <p class="fs-6 m-0">
                    <span class="text-secondary">Type: {{type}} | </span>
                    <span class="text-secondary">Fait par: {{madeBy}} | </span>
                    <span class="text-secondary">Créé le: {{creation}} | </span>
                    <span class="text-secondary">Montant payé: {{montant}} XOF</span>
                </p>
                <p class="fs-2 m-0 mx-2"> <i class="bi bi-people"></i> {{typeConsultation}}</p>
            </div>
            <div class="mt-4">
                <button type="button" class="btn btn-warning mx-2" @click="savePaymentAsFile">Telecharger</button>
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
        creation: String,
        montant: Number,
        typeConsultation: String
    },
    data() {
        return {
            m: this.creation.split(' ')[1].split(':').join(''),
            showLoading: false,
            text: ''
        }
    },
    methods: {
        savePaymentAsFile: function() {
            this.showLoading = true
            this.text = 'Preparation du fichier'
            setTimeout(() => {
                var doc = new jsPDF()
                doc.setFont("helvetica", "bold")
                doc.text('Details du paiement:', 100, 30, null, null, "center")
                doc.text('Fait par: ' + this.madeBy, 20, 50)
                doc.text('Créé par: ' + this.creation, 20, 60)
                doc.text('Type de la consultation: ' + this.typeConsultation, 20, 70)
                doc.text('Montant payé: ' + this.montant, 20, 80)
                doc.save(`Paiement#${this.m}.pdf`)
                this.showLoading = false
            }, 1000)
        }
    },
    components: {Loading}
}
</script>