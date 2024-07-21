<template>
    <Head />
    <div class="home_nav_container">
        <NavBar :rdvActive="true" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 rdvTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 mt-3 bg-body rounded" v-if="noRendezVous">
                <no-consultation text="Vous n'aviez pas encore eu de demande de rendez-vous" />
            </div>
            <div class="w-100" v-if="hasRendezVous">
                <liste-rendez-vous
                v-for="rdv in data" :key="rdv.id"
                :id="rdv.id"
                type="Rendez-vous"
                :typeConsultation="rdv.type"
                :date="rdv.date"
                :made_by="rdv.made_by"
                :meeting="rdv.meeting"
                :status="rdv.status"
                @onDelete="deleteRendezVous" />
            </div>
        </div>
    </div>
    <div id="rdvInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Le système vous montrera la liste de rendez-vous disponibles.
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Head from '../components/Head.vue'
import { useToast } from "vue-toastification"
import noConsultation from '../components/noConsultation.vue'
import ListeRendezVous from '../components/ListeRendezVous.vue'
import jbox from 'jbox'

export default {
    components: {NavBar, Head, noConsultation, ListeRendezVous},
    data() {
        return {
            data: [],
            hasRendezVous: false,
            noRendezVous: false
        }
    },
    mounted() {
        new jbox('Tooltip', {
            attach: '.rdvTooltip',
            trigger: 'mouseenter',
            content: $('#rdvInfo'),
            position: {
                x: 'right',
                y: 'bottom'
            },
            outside: 'x',
            theme: 'TooltipBorder',
            width: 500
        })
        this.loadRendezVous()
    },
    methods: {
        loadRendezVous: function() {
            axios.get('/api/getMedMeeting')
            .then(res => {
                this.data = res.data.details
                if (this.data.length > 0) {
                    this.hasRendezVous = true
                    this.noRendezVous = false
                }else{
                    this.hasRendezVous = false
                    this.noRendezVous = true
                }
            })
            .catch(err => console.log(err))
        },
        deleteRendezVous: function() {},
    },
}
</script>
