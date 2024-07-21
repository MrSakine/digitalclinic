<template>
    <Head />
    <div class="home_nav_container">
        <d-nav :faireConsultation="true" :nbNotifications="0"></d-nav>
        <div class="home_container_right">
            <button type="button" class="btn btn-success btn-lg m-2"
            data-bs-toggle="modal" data-bs-target="#consultation"
            data-title="Créer une nouvelle consultation">Ajouter</button>
            <button class="btn btn-secondary btn-lg mb-3 mx-2 mt-3 consultationTooltip" type="button">Aide ?</button>
            <div class="modal fade" id="consultation" aria-hidden="true" aria-labelledby="consultationLabel"
            tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-lg p-3">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-plus-square mr-3"></i> Nouvelle consultation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModal" @click="clearAll"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" id="demandeConsultation" v-on:submit.prevent="consultationSubmit">
                                <div class="consultationTab">
                                    <div class="mb-2">
                                        <label for="typeConsultation">Type de consultation</label>
                                        <div class="d-flex">
                                            <select name="consultationSelection" id="consultationSelection" class="form-select" required @click="getConsultation"
                                            @focusin="removeError" v-model="model.mTypeConsultation">
                                                <option disabled value="">Choisissez une consultation</option>
                                                <option v-for="(d, i) in consultations" :key="i" :value="d.prix">{{d.type}}</option>
                                            </select>
                                            <i class="bi bi-info-circle descConsultationBanner" @mouseenter="showInformation"></i>
                                        </div>
                                    </div>
                                    <span v-bind:class="nomConsultationState ? 'text-danger' : ''">
                                        {{ nomConsultationState ? nomConsultationStateText : ''}}
                                    </span>
                                    <div class="mb-2">
                                        <label for="montant" class="form-label">Montant de la consultation</label>
                                        <input type="text" name="montant" class="form-control"
                                        placeholder="Montant" autocomplete="off" disabled v-model="montantModel"/>
                                    </div>
                                    <div class="mb-4">
                                        <label for="groupSangin" class="form-label">Groupe Sangin</label>
                                        <select name="groupe_sangin" class="form-select" required @click="getGroupSangin" @focusin="removeError">
                                            <option selected value="">Choisissez une valeur</option>
                                            <option value="O-">O-</option>
                                            <option value="O+">O+</option>
                                            <option value="B-">B-</option>
                                            <option value="B+">B+</option>
                                            <option value="A-">A-</option>
                                            <option value="A+">A+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="AB+">AB+</option>
                                        </select>
                                        <span v-bind:class="groupSanginState ? 'text-danger' : ''">
                                            {{groupSanginState ? groupSanginStateText : ''}}
                                        </span>
                                    </div>
                                </div>
                                <div class="consultationTab">
                                    <div class="mb-2">
                                        <label for="temperature">Temperature</label>
                                        <input type="text" name="temperature" class="form-control" placeholder="Entrer votre temperature"
                                        @focusin="removeError" v-model="model.mTemperature" />
                                        <span v-bind:class="temperatureState ? 'text-danger' : ''">{{temperatureState ? temperatureStateText : ''}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="typeMaladie">Symptômes</label>
                                        <input type="text" name="typeMaladie" class="form-control" placeholder="Entrer votre type de maladie"
                                        @focusin="removeError" v-model="model.mTypeMaladie" />
                                        <span v-bind:class="typeMaladieState ? 'text-danger' : ''">{{typeMaladieState ? typeMaladieStateText : ''}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="descMaladie">Description du symptôme</label>
                                        <textarea name="descMaladie" cols="10" rows="5" class="form-control overflow-auto" @focusin="removeError"
                                        placeholder="Decrivez votre maladie" v-model="model.mDescriptionMaladie"></textarea>
                                        <span v-bind:class="descMaladieState ? 'text-danger' : ''">{{descMaladieState ? descMaladieStateText : ''}}</span>
                                    </div>
                                    <div class="mb-2">
                                        <label for="antecedentMedicaux">Antécedent medicaux</label>
                                        <textarea name="antecedentMedicaux" cols="10" rows="5" class="form-control overflow-auto" @focusin="removeError"
                                        placeholder='Entrer vos antecedents medicaux ou "Aucun" si vous en navez pas'
                                        v-model="model.mAntecedentMedicaux"></textarea>
                                        <span v-bind:class="antMedicaux ? 'text-danger' : ''">{{antMedicaux ? antMedicauxText : ''}}</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="traitementInitial">Traitement initial</label>
                                        <textarea name="traitementInitial" cols="10" rows="5" class="form-control overflow-auto" @focusin="removeError"
                                        placeholder='Entrer les traitements initials que vous avez eu a faire ou "Aucun" si vous en navez pas'
                                        v-model="model.mTraitementInitial"></textarea>
                                        <span v-bind:class="traitementInitialState ? 'text-danger' : ''">{{traitementInitialState ? traitementInitialStateText : ''}}</span>
                                    </div>
                                </div>
                                <div class="consultationTab">
                                    <card-component />
                                </div>
                                <div class="d-flex flex-row flex-row-reverse">
                                    <button type="button" class="btn btn-info btn-lg mx-2" id="nextBtn" @click="nextPrev(1)">Suivant</button>
                                    <button type="button" class="btn btn-secondary btn-lg" id="prevBtn" @click="nextPrev(-1)">Précedent</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noConsultation">
                <no-consultation-vue text="Vous n'aviez pas encore fait de demande de consultations"></no-consultation-vue>
            </div>
            <div class="w-100" v-if="hasConsultation">
                <new-consultation @dConsultation="loadConsultation"
                    v-for="(consultation, index) in data" :key="consultation.id"
                    :id="consultation.id"
                    :type="'Consultation en ligne'"
                    :typeConsultation="consultation.type"
                    :madeBy="consultation.user"
                    :adresse="consultation.adresse"
                    :age="consultation.age"
                    :genre="consultation.genre"
                    :email="userEmail"
                    :dateOfCreation="consultation.creation"
                    :montant="Number(consultation.montant)"
                    :etat="consultation.traitement === 'En cours' ? false : true"
                    :temperature="Number(consultation.temperature)"
                    :typeMaladie="consultation.typeMaladie"
                    :descMaladie="consultation.descriptionMaladie"
                    :antecedentMedicaux="consultation.antecedentMedicaux"
                    :traitementInitial="consultation.traitementInitial"
                    :groupeSangin="consultation.groupSangin"
                    :index="Number(index)"
                ></new-consultation>
            </div>
        </div>
    </div>

    <div id="consultationInfo" style="display:none;">
        <h4>Aide pour la création d'une consultation en ligne</h4>
        <span>
            Cliquez sur le bouton ajouter et suivez les instructions du formulaire
        </span>
    </div>
    <div id="descConsultationContent" style="display:none;">
        <h4 style="text-decoration: underline;">{{descTitle}}</h4>
        <span>
            {{descContent}}
        </span>
    </div>
</template>

<script>
import DNav from '../components/DashBoardNavBar.vue'
import Head from '../components/Head.vue'
import newConsultation from '../components/newConsultation.vue'
import noConsultationVue from '../components/noConsultation.vue'
import dateFormat from "dateformat"
import Consultation from '../../objects/Consultation.js'
import FicheConsultation from '../../objects/FicheConsultation.js'
import LoadingVue from '../../components/Loading.vue'
import cardComponent from '../components/cardComponent.vue'
import { useToast } from "vue-toastification"
import jbox from 'jbox'

export default {
    components: { DNav, newConsultation, noConsultationVue, LoadingVue, Head, cardComponent },
    data() {
        return {
            currentTab: 0,
            montantModel: '0',
            nomConsultationState: false,
            dateConsultationState: false,
            temperatureState: false,
            typeMaladieState: false,
            descMaladieState: false,
            antMedicaux: false,
            traitementInitialState: false,
            groupSanginState: false,
            nomConsultationStateText: "Veuillez selectionner une consultation",
            dateConsultationStateText: "Verifier la valeur de la date",
            temperatureStateText: "Verifier la valeur de la temperature",
            typeMaladieStateText: "Verifier la valeur du type de maladie",
            descMaladieStateText: "Verifier la valeur de la description de la maladie",
            antMedicauxText: "Verifier la valeur du champ",
            traitementInitialStateText: "Verifier la valeur du traitement initial",
            groupSanginStateText: "Verifier la valeur de votre groupe sangin",
            date: null,
            options: {
                date: true,
                delimeter: '/',
                datePattern: ['d', 'm', 'Y']
            },
            shouldValidateForm: false,
            consultations: [],
            groupeSanginModel: '',
            model: {
                mTypeConsultation: '',
                mTemperature: '',
                mDescriptionMaladie: '',
                mTypeMaladie: '',
                mAntecedentMedicaux: '',
                mTraitementInitial: ''
            },
            data: [],
            hasConsultation: false,
            noConsultation: false,
            userEmail: localStorage.getItem('authPatientEmail'),
            showLoading: false,
            showNotif: false,
            textLoading: null,
            descTitle: '',
            descContent: ''
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
        this.showTab(this.currentTab)
        this.loadConsultation()
        this.getTypeConsultation()
        const tx = document.querySelectorAll("textarea")
        tx.forEach((input) => {
            input.addEventListener("input", this.onInput, false)
        })
        Echo.private('new-traitement').
        listen('NewTraitement', (e) => {
            const toast = useToast()
            this.loadConsultation()
            toast.info(e.message, {timeout: false})
            toast = null
        })
    },
    methods: {
        loadConsultation: function() {
            axios.post('/api/consultations', {
                user: this.userEmail
            })
            .then((rep) => {
                this.showLoading = false
                this.textLoading = null
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
                this.showLoading = false
                this.textLoading = null
                console.log(err.response.data)
            })
        },
        showTab: function(n) {
            var x = document.getElementsByClassName('consultationTab')
            x[n].style.display = 'block'
            let previousBtn = document.getElementById('prevBtn')
            let nextBtn = document.getElementById('nextBtn')
            if (n == 0) previousBtn.style.display = 'none'
            else previousBtn.style.display = 'inline'

            if (n == x.length - 1) {
                nextBtn.innerHTML = "Valider"
            }
            else nextBtn.innerHTML = "Suivant"
        },
        nextPrev: function(n) {
            var x = document.getElementsByClassName('consultationTab'), nBtn = document.getElementById('nextBtn')
            this.shouldValidateForm = true
            if (n == 1 && this.currentTab == x.length - 1 && this.checkFormPart()){
                nBtn.setAttribute("type", "submit")
                return true
            }
            if (n == 1 && this.shouldValidateForm == true && this.checkFormPart()) {
                x[this.currentTab].style.display = 'none'
                this.currentTab += n
                this.showTab(this.currentTab)
            }else if (n == -1) {
                x[this.currentTab].style.display = 'none'
                this.currentTab += n
                this.showTab(this.currentTab)
            }else{
                return false
            }
        },
        consultationSubmit: function(e) {
            e.preventDefault()
            let d = new Date(),
            s = dateFormat(d, 'dd/mm/yyyy HH:MM:ss'),
            f = new FicheConsultation(
                this.model.mTemperature, this.model.mTypeMaladie, this.model.mDescriptionMaladie, this.model.mAntecedentMedicaux,
                this.model.mTraitementInitial, this.groupeSanginModel
            ),
            c = new Consultation(null, this.mTypeConsultation, this.montantModel, true, false, s, null, f)
            this.showLoading = true
            this.textLoading = 'Validation de votre demande de consultation en cours...'
            setTimeout(() => {
                axios.post('/api/saveConsultation', {
                    user: localStorage.getItem('authPatientEmail'),
                    typeConsultation: c.typeConsultation,
                    prixConsultation: c.prixConsultation,
                    payer: c.payer,
                    traiter: c.valider,
                    dateCreation: c.dateCreation,
                    dateValidation: c.dateValidation,
                    temperature: c.ficheConsultation.temperature,
                    typeMaladie: c.ficheConsultation.typeMaladie,
                    descriptionMaladie: c.ficheConsultation.descriptionMaladie,
                    antecedentMedicaux: c.ficheConsultation.antecedentMedicaux,
                    traitementInitial: c.ficheConsultation.traitementIntial,
                    groupSangin: c.ficheConsultation.groupeSangin
                })
                .then((rep) => {
                    this.showLoading = false
                    this.textLoading = null
                    if (rep.status == 200){
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: rep.data.message,
                            confirmButtonText: 'Fermer'
                        })
                        document.getElementsByClassName("btn-close")[0].click()
                        return true
                    }
                })
                .catch((err) => {
                    this.showLoading = false
                    this.textLoading = null
                    console.log(err.response.data)
                })
            }, 500)
        },
        checkFormPart: function() {
            var x = document.getElementsByClassName('consultationTab'),
            y = x[this.currentTab].getElementsByTagName('input'),
            z = x[this.currentTab].getElementsByTagName('textarea'),
            z1 = x[this.currentTab].getElementsByTagName('select')
            if (typeof y !== 'undefined') for(const i of y) { this.checkDetail(i) }
            if (typeof z !== 'undefined') for(const h of z) { this.checkDetail(h) }
            if (typeof z1 !== 'undefined') for (const y of z1) { this.checkDetail(y) }

            if (
                this.nomConsultationState == false
                && this.dateConsultationState == false
                && this.temperatureState == false
                && this.groupSanginState == false
                && this.typeMaladieState == false
                && this.descMaladieState == false
                && this.antMedicaux == false
                && this.traitementInitialState == false
            ){
                this.shouldValidateForm = false
                return true
            }else{
                return false
            }
        },
        checkDetail: function(input) {
            if (input.name == 'consultationSelection') {
                this.checkConsultationName()
            }else if (input.name == 'dateConsultation') {
                this.checkDateFormat(input.value)
            }else if (input.name == 'temperature') {
                this.checkTemperature(input.value)
            }else if (input.name == 'typeMaladie') {
                this.checkTypeMaladie(input.value)
            }else if (input.name == 'descMaladie') {
                this.checkDescMaladie(input.value)
            }else if (input.name == 'antecedentMedicaux') {
                this.checkAntMedicaux(input.value)
            }else if (input.name == 'traitementInitial'){
                this.checkTraitementIntial(input.value)
            }else{
                this.checkGroupSangin()
            }
        },
        checkConsultationName: function() {
            if (this.montantModel != '0') this.nomConsultationState = false
            else this.nomConsultationState = true
        },
        checkDateFormat: function(date) {
            if (date.match(/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/)) this.dateConsultationState = false
            else this.dateConsultationState = true
            let x = new Date()
            let [day, month, year] = dateFormat(x.toGMTString(), "dd/mm/yyyy").split("/")
            let [d, m, y] = date.split('/')
            if (Number(d) < Number(day) || Number(m) < Number(month) || Number(y) < Number(year) || Number(y) > Number(year)){
                this.dateConsultationState = true
            }
            else this.dateConsultationState = false
        },
        checkTemperature: function(t) {
            if (t.match(/^[0-9]+$/) && (Number(t) >= 20 && Number(t) < 38) ) this.temperatureState = false
            else this.temperatureState = true
        },
        checkTypeMaladie: function(ctm) {
            if (ctm.match(/^[a-zA-z\D]+$/)) this.typeMaladieState = false
            else this.typeMaladieState = true
        },
        checkDescMaladie: function(cdm) {
            if (cdm.match(/^[a-zA-z\D]+$/)) this.descMaladieState = false
            else this.descMaladieState = true
        },
        checkAntMedicaux: function(cam) {
            if (cam.match(/^[a-zA-z\D]+$/)) this.antMedicaux = false
            else this.antMedicaux = true
        },
        checkTraitementIntial: function(cti) {
            if (cti.match(/^[a-zA-z\D]+$/)) this.traitementInitialState = false
            else this.traitementInitialState = true
        },
        checkGroupSangin: function() {
            if (this.groupeSanginModel != '') this.groupSanginState = false
            else this.groupSanginState = true
        },
        removeError: function(e) {
            if (e.target.name == 'consultationSelection') {
                this.nomConsultationState = false
            }else if (e.target.name == 'dateConsultation') {
                this.dateConsultationState = false
            }else if (e.target.name == 'temperature') {
                this.temperatureState = false
            }else if (e.target.name == 'typeMaladie') {
                this.typeMaladieState = false
            }else if (e.target.name == 'descMaladie') {
                this.descMaladieState = false
            }else if (e.target.name == 'antecedentMedicaux') {
                this.antMedicaux = false
            }else if (e.target.name == 'traitementInitial') {
                this.traitementInitialState = false
            }else{
                this.groupSanginState = false
            }
        },
        clearAll: function() {
            let p1 = document.getElementsByTagName("select"), nBtn = document.getElementById('nextBtn'),
            x = document.getElementsByClassName('consultationTab')
            this.loadConsultation()
            for(const u of p1) {
                for(var i=1; i<u.childElementCount; i++){
                    u[i].selected = false
                }
            }
            x[this.currentTab].style.display = 'none'
            this.nomConsultationState = false
            this.dateConsultationState = false
            this.groupSanginState = false
            this.temperatureState = false
            this.groupSanginState = false
            this.typeMaladieState = false
            this.descMaladieState = false
            this.antMedicaux = false
            this.traitementInitialState = false
            this.shouldValidateForm = false
            this.montantModel = 0
            this.currentTab = 0
            this.showTab(this.currentTab)
            nBtn.setAttribute("type", "button")
            this.model.mTypeMaladie = ''
            this.model.mDescriptionMaladie = ''
            this.model.mGroupeSangin = ''
            this.model.mTemperature = ''
            this.model.mTypeConsultation = ''
            this.model.mAntecedentMedicaux = ''
            this.model.mTraitementInitial = ''
            this.date = ''
            this.montantModel = '0'
        },
        getConsultation: function(e) {
            this.montantModel = e.target.value
            this.mTypeConsultation = e.target.options[e.target.selectedIndex].text

        },
        tpc: function(e) {
            e.target.value = e.target.value.toUpperCase()
        },
        getGroupSangin: function(e) {
            this.groupeSanginModel = e.target.value
        },
        getTypeConsultation: function() {
            axios.get('/api/getType')
            .then(res => {
                if (res.data.status) {
                    this.consultations = res.data.details
                }
            })
            .catch(err => console.log(err))
        },
        onInput: function(e) {
            e.target.style.height = "auto"
            e.target.style.height = (e.target.scrollHeight) + "px"
        },
        showInformation: function() {
            if (this.montantModel !== '0') {
                let el = this.consultations.filter(value => value.type === this.mTypeConsultation)
                this.descTitle = el[0].type
                this.descContent = el[0].desc
                new jbox('Tooltip', {
                    attach: '.descConsultationBanner',
                    content: $('#descConsultationContent'),
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
                    content: $('#descConsultationContent'),
                    position: {
                        x: 'left',
                        y: 'top'
                    },
                    theme: 'TooltipDark',
                    width: 500
                })
            }
        }
    },
}
</script>

<style scoped>
textarea {
    resize: none;
    overflow: hidden;
}
::-webkit-scrollbar{
    width: 5px;
}
i.bi.bi-info-circle {
    font-size: 20px;
    color: #00ddff;
    margin-left: 20px;
    cursor: pointer;
}
</style>
