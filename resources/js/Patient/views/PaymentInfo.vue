<template>
    <div class="container-sm mb-3 mt-4 w-100">
        <nav-bar :payment="true" />
        <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noPayment">
            <no-consultation-vue text="Vous n'aviez pas encore fait de paiements" />
        </div>
        <div class="w-100" v-if="hasPayments">
            <new-payment
                v-for="paiement in data" :key="paiement.id"
                :type="paiement.type.includes('ligne') ? 'Consultation en ligne' : 'Rendez Vous'"
                :madeBy="paiement.user"
                :creation="paiement.date"
                :montant="Number(paiement.montant)"
                :typeConsultation="paiement.type" />
        </div>
    </div>
</template>

<script>
import navBar from '../components/CompteNavBar.vue'
import noConsultationVue from '../components/noConsultation.vue'
import newPayment from '../components/newPayment.vue'

export default {
    components: {navBar, noConsultationVue, newPayment},
    data() {
        return {
            data: [],
            hasPayments: false,
            noPayment: false,
            showLoading: false
        }
    },
    mounted() {
        axios.post('/api/payments', {
            user: localStorage.getItem('authPatientEmail')
        })
        .then((rep) => {
            if (rep.status == 200) this.data = rep.data.details
            if (this.data.length > 0) {
                this.hasPayments = true
                this.noPayment = false
            }else{
                this.hasPayments = false
                this.noPayment = true
            }
        })
        .catch(err => console.log(err.response.data))
    },
    methods: {
    },
}
</script>
