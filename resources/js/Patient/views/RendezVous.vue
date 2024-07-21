<template>
    <Head />
    <div class="home_nav_container">
        <d-nav :prendreRendezVous="true" :nbNotifications="0"></d-nav>
        <div class="home_container_right">
            <button type="button" class="btn btn-success btn-lg m-2"
            data-bs-toggle="modal" data-bs-target="#rendezvous"
            data-title="Créer un nouveau rendez-vous">Ajouter</button>
            <button class="btn btn-secondary btn-lg mb-3 mx-2 mt-3 rdvTooltip" type="button">Aide ?</button>
            <div class="modal fade" id="rendezvous" aria-hidden="true" aria-labelledby="rendezvousLabel"
            tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus-square mr-3"></i> Nouveau rendez-vous</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="clearBtn" @click="clearAll"></button>
                        </div>
                        <div class="modal-body">
                            <form id="rendezvousForm" v-on:submit.prevent="rendezvousFormHandler">
                                <div class="#">
                                    <div class="mb-2">
                                        <label for="typeConsultation">Type de consultation</label>
                                        <div class="d-flex">
                                            <select name="consultationSelection" id="consultationSelection" class="form-select" required
                                            @click="getConsultation" @focusin="removeError" v-model="models.rTypeConsultation">
                                                <option disabled value="">Choisissez une consultation</option>
                                                <option v-for="(d, i) in rendezvous" :key="i" :value="d.prix">{{d.type}}</option>
                                            </select>
                                            <i class="bi bi-info-circle descConsultationBanner" @mouseenter="showInformation"></i>
                                        </div>
                                        <span v-bind:class="typeConsultationState ? 'text-danger' : ''">
                                            {{typeConsultationState ? typeConsultationStateText : ''}}
                                        </span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="dob" class="form-label">Date consultation</label>
                                        <datepicker v-model="date" aria-placeholder="Selectionner une date..."
                                        :enableTimePicker="false" locale="fr" cancel-text="Annuler" select-text="Valider" @click="onOpen"
                                        @update:model-value="setupMeeting"
                                        />
                                        <span v-bind:class="dateConsultationState ? 'text-danger' : 'text-info'">
                                            {{dateConsultationState ? dateConsultationStateText : ''}}
                                        </span>
                                    </div>
                                    <div class="mb-2" id="meetingD" :class="meetingAvailable === false ? 'animate__animated animate__fadeOutDown' : ''">
                                        <label for="heure">Heure de consultation</label>
                                        <select name="heure" class="form-select" v-model="models.rHeure" @click="getSelectedMeeting">
                                            <option disabled value="">Choisissez une heure de consultation</option>
                                            <option v-for="(d, i) in meetingData" :key="i" :value="d.outerText">{{d.outerText}}</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="floatingInput">Montant</label>
                                        <input type="text" name="montant" id="montant" class="form-control" disabled v-model="montantModel"
                                        @focusin="removeError" />
                                    </div>
                                    <div>
                                        <card-component v-if="hidePaymentComponent === false" />
                                    </div>
                                </div>
                                <div class="d-flex flex-row flex-row-reverse">
                                    <button type="submit" class="btn btn-primary btn-lg mx-2 w-100 text-center" id="nextBtn">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noConsultation">
                <no-consultation-vue text="Vous n'aviez pas encore fait de demande de rendez vous"></no-consultation-vue>
            </div>
            <div class="w-100" v-if="hasConsultation">
                <new-rendez-vous @dRendezVous="loadRendezVous"
                    v-for="(rendezvous, index) in data" :key="rendezvous.id"
                    :id="rendezvous.id"
                    type="Rendez-vous"
                    :typeConsultation="rendezvous.type"
                    :madeBy="rendezvous.user"
                    :dateOfCreation="rendezvous.date"
                    :montant="Number(rendezvous.prix)"
                    :index="Number(index)"
                    :email="userEmail"
                    :age="rendezvous.age"
                    :adresse="rendezvous.adresse"
                    :meetingData="rendezvous.meeting.split(',')"
                ></new-rendez-vous>
            </div>
        </div>
    </div>
    <div id="rdvInfo" style="display:none;">
        <h4>Aide pour la creation d'un rendez-vous</h4>
        <span>
            Cliquer sur le bouton ajouter, choisissez le type de consultation et valider votre rendez-vous en cliquant sur le bouton valider
        </span>
    </div>
    <div id="descRendezInfo" style="display:none;">
        <h4 style="text-decoration: underline;">{{descTitle}}</h4>
        <span>
            {{descContent}}
        </span>
    </div>
</template>

<script>
import DNav from '../components/DashBoardNavBar.vue'
import newRendezVous from '../components/newRendezVous.vue'
import noConsultationVue from '../components/noConsultation.vue'
import RendezVous from '../../objects/RendezVous'
import dateFormat from 'dateformat'
import LoadingVue from '../../components/Loading.vue'
import Head from '../components/Head.vue'
import cardComponent from '../components/cardComponent.vue'
import jbox from 'jbox'
import { ref } from 'vue'
import Datepicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: { DNav, newRendezVous, noConsultationVue, LoadingVue, Head, Datepicker, cardComponent },
    setup() {
        const date = ref(new Date())
        const format = (date) => {
            return dateFormat(date, 'dd/mm/yyyy')
        }

        return {date, format}
    },
    data() {
        return {
            type: "Rendez-Vous",
            madeBy: "",
            dateOfCreation: "20/02/2022",
            montant: 10000,
            montantModel: '0',
            options: {
                date: true,
                delimeter: '/',
                datePattern: ['d', 'm', 'Y']
            },
            typeConsultationState: false,
            dateConsultationState: false,
            typeConsultationStateText: "Veuillez choisir une consultation",
            dateConsultationStateText: "Verifier la valeur de votre date",
            rendezvous: [],
            models: {
                rTypeConsultation: '',
                rMontant: '',
                rHeure: ''
            },
            data: [],
            hasConsultation: false,
            noConsultation: false,
            userEmail: localStorage.getItem('authPatientEmail'),
            showLoading: false,
            descTitle: '',
            descContent: '',
            meetingData: {},
            meetingAvailable: true,
            hidePaymentComponent: false,
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
      this.getTypeConsultation()
    },
    methods: {
        loadRendezVous: function() {
            axios.post('/api/rendezvous', {
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
            .catch(err => console.log(err.response.data))
        },
        onOpen: function() {
            this.dateConsultationState = false
        },
        getConsultation: function(e) {
            this.dateConsultationState = false
            this.montantModel = e.target.value
            this.rTypeConsultation = e.target.options[e.target.selectedIndex].text
            this.setupMeeting()
        },
        checkConsultation: function() {
            if (this.montantModel != '0') this.typeConsultationState = false
            else this.typeConsultationState = true
        },
        checkDateFormat: function(date) {
            this.dateConsultationStateText = 'Verifier la valeur de votre date'
            if (date.match(/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/)) this.dateConsultationState = false
            else this.dateConsultationState = true
            let x = new Date()
            let [day, month, year] = dateFormat(x.toDateString(), 'dd/mm/yyyy').split('/')
            let [d, m, y] = date.split('/')
            if (Number(d) < Number(day) || Number(m) < Number(month) || Number(y) < Number(year) || Number(y) > Number(year)) this.dateConsultationState = true
            else this.dateConsultationState = false
        },
        clearAll: function() {
            this.loadRendezVous()
            const f = document.getElementById("rendezvousForm").getElementsByTagName('input'),
            g = document.getElementById("consultationSelection")
            for(const i of f) { i.value = '' }
            for(var i=1; i<g.childElementCount; i++) g[i].selected = false
            this.typeConsultationState = false
            this.dateConsultationState = false
            this.montantModel = '0'
            this.models.rTypeConsultation = ''
        },
        rendezvousFormHandler: function(e) {
            e.preventDefault()
            this.checkConsultation()
            this.checkDateFormat(this.format(this.date))
            if (this.typeConsultationState == false && this.dateConsultationState == false) {
                let d = new Date(),
                s = this.format(this.date) + ' ' + dateFormat(d, 'HH:MM:ss'),
                rdv = new RendezVous(this.rTypeConsultation, s, Number(this.montantModel))
                this.showLoading = true
                setTimeout(() => {
                    axios.post('/api/saveRendezVous', {
                        user: localStorage.getItem('authPatientEmail'),
                        typeConsultation: rdv.typeConsultation,
                        date: rdv.dateConsultation,
                        heure: this.models.rHeure,
                        prix: rdv.prix
                    })
                    .then((rep) => {
                        this.showLoading = false
                        if (rep.status == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: rep.data.message,
                                confirmButtonText: 'Fermer'
                            })
                            document.getElementById("clearBtn").click()
                        }
                    })
                    .catch((err) => {
                        this.showLoading = false
                    })
                }, 1000)
            }else{
                return false
            }
        },
        removeError: function(e) {
            if (e.target.name == 'consultationSelection'){
                this.typeConsultationState = false
            }else{
                this.dateConsultationState = false
            }
        },
        getTypeConsultation: function() {
            axios.get('/api/getType')
            .then(res => {
                if (res.data.status) {
                    this.rendezvous = res.data.details
                }
            })
            .catch(err => console.log(err))
        },
        showInformation: function() {
            if (this.montantModel !== '0') {
                let el = this.rendezvous.filter(value => value.type === this.rTypeConsultation)
                this.descTitle = el[0].type
                this.descContent = el[0].desc
                new jbox('Tooltip', {
                    attach: '.descConsultationBanner',
                    content: $('#descRendezInfo'),
                    position: {
                        x: 'left',
                        y: 'top'
                    },
                    theme: 'TooltipDark',
                    width: 500
                })
            }else{
                this.descTitle = 'Information'
                this.descContent = 'Cliquer sur une consultation pour voir plus d\'informations'
                new jbox('Tooltip', {
                    attach: '.descConsultationBanner',
                    content: $('#descRendezInfo'),
                    position: {
                        x: 'left',
                        y: 'top'
                    },
                    theme: 'TooltipDark',
                    width: 500
                })
            }
        },
        setupMeeting: function() {
            this.dateConsultationState = false
            let tmp = [], el = document.querySelector('#meetingD')
            if (this.models.rTypeConsultation !== '') {
                axios.post('/api/getAllMeeting', {
                    typeConsultation: this.rTypeConsultation,
                    date: this.getDay(this.date)
                })
                .then(res => {
                    this.meetingData = res.data.details
                    if (this.meetingData.length > 0) {
                        this.meetingAvailable = true
                        this.hidePaymentComponent = false
                        el.style.display = 'block'
                        el.classList.add('animate__animated')
                        el.classList.add('animate__bounceInUp')
                        for (const j of this.meetingData) {
                            let s = {
                                value: j.hours,
                                outerText: `${j.hours}, ${j.medecin}`
                            }
                            tmp.push(s)
                        }
                        this.meetingData = tmp
                    }else{
                        this.meetingAvailable = false
                        this.hidePaymentComponent = true
                        this.dateConsultationState = true
                        this.dateConsultationStateText = 'Pas de rendez-vous disponibles pour cette date.'
                        setTimeout(() => {
                            el.style.display = 'none'
                            el.classList.remove('animate__animated')
                            el.classList.remove('animate__bounceInUp')
                        }, 1000)
                    }
                })
                .catch(err => console.log(err))
            }
        },
        getSelectedMeeting: function(e) {
            this.dateConsultationState = false
            this.models.rHeure = e.target.value
        },
        getDay: function(date) {
            let day = date.getDay()
            switch(day) {
                case 0:
                    return "Dimanche"
                case 1:
                    return "Lundi"
                case 2:
                    return "Mardi"
                case 3:
                    return "Mercredi"
                case 4:
                    return "Jeudi"
                case 5:
                    return "Vendredi"
                case 6:
                    return "Samedi"
            }
        }
    },
}
</script>

<style scoped>
i.bi.bi-info-circle {
    font-size: 20px;
    color: #00ddff;
    margin-left: 20px;
    cursor: pointer;
}
</style>
