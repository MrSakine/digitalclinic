<template>
    <Head />
    <div class="home_nav_container">
        <nav-bar :consultationTraiterActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 traitementTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noConsultation">
                <no-consultation text="Vous n'aviez pas encore traité de demande de consultations" />
            </div>
            <div class="container w-100 h-100 m-3 p-3" v-if="hasConsultation">
                <liste-resultats
                    v-for="(consultation, index) in data" :key="consultation.id"
                    :id="Number(consultation.id)"
                    :madeBy="consultation.user"
                    :madeByAge="Number(consultation.age)"
                    :madeByAdresse="consultation.adresse"
                    :madeByEmail="userEmail"
                    :madeByPhone="consultation.numero"
                    :dateOfCreation="consultation.date"
                    :montant="Number(consultation.montant)"
                    :etat="consultation.traiter"
                    :medecin="consultation.traiter_par"
                    :medecinAdresse="consultation.traiter_par_adresse"
                    :medecinAge="consultation.traiter_par_age"
                    :medecinPhone="consultation.traiter_par_numero"
                    :dateOfValidation="consultation.dateV"
                    :groupSangin="consultation.groupSangin"
                    :temperature="Number(consultation.temp)"
                    :descriptionMaladie="consultation.descriptionMaladie"
                    :antecedentMedicaux="consultation.antMedicaux"
                    :traitementInitial="consultation.traitementIntial"
                    :conseil="consultation.conseil"
                    :diagnostic="consultation.diagnostic"
                    :observation="consultation.observation"
                    type="Consultation en ligne"
                    :typeConsultation="consultation.type"
                    :index="Number(index)"
                    :ordo="consultation.ordonnances"
                />
            </div>
        </div>
    </div>
        <div id="traitementInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Le système vous affichera la liste de vos consultations traitées. Cliquer sur le bouton "Voir" pour voir les détails d'un traitement
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import noConsultation from '../components/noConsultation.vue'
import ListeResultats from '../components/ListeResultats.vue'
import Head from '../components/Head.vue'
import jbox from 'jbox'

export default {
    components: {NavBar, noConsultation, ListeResultats, Head},
    mounted() {
        new jbox('Tooltip', {
            attach: '.traitementTooltip',
            trigger: 'mouseenter',
            content: $('#traitementInfo'),
            position: {
                x: 'right',
                y: 'bottom'
            },
            outside: 'x',
            theme: 'TooltipBorder',
            width: 500
        })
        this.loadConsultationTraites()
    },
    methods: {
        loadConsultationTraites: function() {
            axios.post('/api/getMedecinTraiterConsultationsFull', {
                user: this.userEmail
            })
            .then((rep) => {
                this.data = rep.data.details
                if (this.data.length > 0) {
                    this.hasConsultation = true
                    this.noConsultation = false
                }else{
                    this.hasConsultation = false
                    this.noConsultation = true
                }
            })
        }
    },
    data() {
        return {
            data: [],
            hasConsultation: false,
            noConsultation: false,
            userEmail: localStorage.getItem('authMedecinEmail'),
        }
    },
}
</script>
