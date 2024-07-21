<template>
    <Head />
    <div class="home_nav_container">
        <nav-bar :listeConsultationActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 consultationTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 mt-3 bg-body rounded" v-if="noConsultation">
                <no-consultation text="Vous n'aviez pas encore eu de demande de consultations" />
            </div>
            <div class="w-100" v-if="hasConsultation">
                <liste
                v-for="consultation in data" :key="consultation.id"
                :id="Number(consultation.id)"
                type="Consultation en ligne"
                :madeBy="consultation.user"
                :dateOfCreation="consultation.date"
                :montant="Number(consultation.prix)"
                :typeConsultation="consultation.type" />
            </div>
        </div>
    </div>
    <div id="consultationInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Le système vous montrera la liste de consultations disponibles correspondantes à vos spécialités (s'il y a en).
            Cliquer sur le bouton "Traiter" pour les traiter.
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Liste from '../components/Liste.vue'
import noConsultation from '../components/noConsultation.vue'
import Head from '../components/Head.vue'
import { useToast } from "vue-toastification"
import jbox from 'jbox'

export default {
  components: { NavBar, Liste, noConsultation, Head },
  data() {
    return {
      data: [],
      hasConsultation: false,
      noConsultation: false,
      consultationModel: '',
    }
  },
  mounted() {
    new jbox('Tooltip', {
        attach: '.consultationTooltip',
        trigger: 'mouseenter',
        content: $('#consultationInfo'),
        position: {
            x: 'right',
            y: 'bottom'
        },
        outside: 'x',
        theme: 'TooltipBorder',
        width: 500
    })
    this.loadConsultations()
    Echo.private('new-consultation')
    .listen('NewConsultation', (e) => {
        this.loadConsultations()
        const toast = useToast()
        toast.info(e.message, {timeout: false})
        toast = null
    })
  },
  methods: {
    loadConsultations: function() {
      axios.get('/api/getConsultations')
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
      .catch(err => console.log(err.response.data))
    }
  },
 }
 </script>
