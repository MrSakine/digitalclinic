<template>
    <Head />
    <div class="home_nav_container">
        <d-nav :resultatConsultation="true" :nbNotifications="0"></d-nav>
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 mx-2 mt-3 resultatTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noConsultation">
                <no-consultation-vue text="Vous n'aviez pas encore de consultations traitées"></no-consultation-vue>
            </div>
            <div class="container w-100 h-100 border-top border-secondary border-top-2 m-3 p-3" v-if="hasConsultation">
                <new-resultat
                    v-for="consultation in data" :key="consultation.id"
                    type="Consultation en ligne"
                    :madeBy="consultation.user"
                    :madeByAge="Number(consultation.age)"
                    :madeByAdresse="consultation.adresse"
                    :medecinAdresse="consultation.traiter_par_adresse"
                    :medecinAge="Number(consultation.traiter_par_age)"
                    :dateOfCreation="consultation.date"
                    :dateOfValidation="consultation.dateV"
                    :montant="Number(consultation.montant)"
                    :etat="consultation.traiter"
                    :medecin="consultation.traiter_par"
                    :typeConsultation="consultation.type"
                    :temperature="Number(consultation.temp)"
                    :groupeSangin="consultation.groupSangin"
                    :typeMaladie="consultation.typeMaladie"
                    :descriptionMaladie="consultation.descriptionMaladie"
                    :antMedicaux="consultation.antMedicaux"
                    :traitementInitial="consultation.traitementInitial"
                    :conseil="consultation.conseil"
                    :diagnostic="consultation.diagnostic"
                    :observation="consultation.observation"
                    :ordo="consultation.ordonnances"
                ></new-resultat>
            </div>
        </div>
    </div>
    <div id="resultatInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Utilisez cette partie du système pour voir les résultats d'une consultation traitée
        </span>
    </div>
</template>

<script>
import DNav from '../components/DashBoardNavBar.vue'
import newResultat from '../components/newResultat.vue'
import noConsultationVue from '../components/noConsultation.vue'
import Loading from '../../components/Loading.vue'
import Head from '../components/Head.vue'
import jbox from 'jbox'

export default {
    components: { DNav, newResultat, noConsultationVue, Loading, Head },
    data() {
        return {
            data: [],
            hasConsultation: false,
            noConsultation: false,
            userEmail: localStorage.getItem('authPatientEmail'),
            showLoading: false,
            text: ''
        }
    },
    mounted() {
        new jbox('Tooltip', {
            attach: '.resultatTooltip',
            trigger: 'mouseenter',
            content: $('#resultatInfo'),
            position: {
                x: 'right',
                y: 'bottom'
            },
            outside: 'x',
            theme: 'TooltipBorder',
            width: 500
        })
        this.loadFullConsultation()
    },
    methods: {
        loadFullConsultation: function() {
            axios.post('/api/getPatientTraiterConsultationsFull', {
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
            .catch((err) => {
                console.log(err.response.data)
            })
        }
    },
}
</script>
