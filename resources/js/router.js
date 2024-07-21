import { createRouter, createWebHistory } from 'vue-router'
import LoginVue from './views/Login.vue'
import InscriptionVue from './views/Inscription.vue'
import HomeVue from './views/Home.vue'
import PatientAccueil from './Patient/DashBoard.vue'
import FAQ from './views/FAQ.vue'
import MonCompteAccueil from './Patient/views/MonCompte.vue'
import ConsultationPatient from './Patient/views/ConsultationOnline.vue'
import RdvPatient from './Patient/views/RendezVous.vue'
import MessageConsultationPatient from './Patient/views/Message.vue'
import ResultatConsultationPatient from './Patient/views/Resultats.vue'
import PaiementInfoPatient from './Patient/views/PaymentInfo.vue'
import MedecinAccueil from './Medecin/App.vue'
import MedecinAgenda from './Medecin/views/Agenda.vue'
import MedecinTraiter from './Medecin/views/MedecinTraiter.vue'
import ListeConsulation from './Medecin/views/ListeConsultation.vue'
import ListeRendezVous from './Medecin/views/RendezVous.vue'
import MedecinSpecialite from './Medecin/views/Specialites.vue'
import MessageConsultationMedecin from './Medecin/views/Message.vue'
import MedecinConsultationTraite from './Medecin/views/ConsultationTraite.vue'
import MedecinCompteAccueil from './Medecin/views/MonCompte.vue'
import MedecinConv from './Medecin/views/Conversation.vue'
import PatientConv from './Patient/views/Conversation.vue'

export const routes = [
    { path: '/', component: HomeVue, name: 'index' },
    { path: '/login', component: LoginVue, name: 'login' },
    { path: '/inscription', component: InscriptionVue, name: 'inscription' },
    { path: '/faq', component: FAQ, name: 'faq' },
    { path: '/accueil/patient', component: PatientAccueil, name: 'accueil' },
    { path: '/accueil/patient/mon-compte', component: MonCompteAccueil, name: 'mon-compte' },
    { path: '/accueil/patient/payments', component: PaiementInfoPatient, name: 'payment' },
    { path: '/accueil/patient/consultation', component: ConsultationPatient, name: 'consultation-online' },
    { path: '/accueil/patient/rendezvous', component: RdvPatient, name: 'rendez-vous' },
    { path: '/accueil/patient/messages', component: MessageConsultationPatient, name: 'messages' },
    { path: '/accueil/patient/start-conversation/:id', component: PatientConv, name: 'patient-conv' },
    { path: '/accueil/patient/resultats', component: ResultatConsultationPatient, name: 'resultats' },
    { path: '/accueil/medecin', component: MedecinAccueil, name: 'medecin-accueil' },
    { path: '/accueil/medecin/agenda', component: MedecinAgenda, name: 'medecin-agenda' },
    { path: '/accueil/medecin/mon-compte', component: MedecinCompteAccueil, name: 'medecin-accueil-compte' },
    { path: '/accueil/medecin/listes', component: ListeConsulation, name: 'medecin-liste' },
    { path: '/accueil/medecin/rdv', component: ListeRendezVous, name: 'medecin-rdv' },
    { path: '/accueil/medecin/specialites', component: MedecinSpecialite, name: 'medecin-specialites' },
    { path: '/accueil/medecin/listes/traites', component: MedecinConsultationTraite, name: 'medecin-liste-traites' },
    { path: '/accueil/medecin/traiter/:id', component: MedecinTraiter, name: 'medecin-traiter' },
    { path: '/accueil/medecin/messages', component: MessageConsultationMedecin, name: 'medecin-message' },
    { path: '/accueil/medecin/start-conversation/:id', component: MedecinConv, name: 'medecin-conv' },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router
