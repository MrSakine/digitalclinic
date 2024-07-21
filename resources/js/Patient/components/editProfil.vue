<template>
    <div>
        <form action="#" method="POST" class="edit-profil shadow-sm bg-light rounded mb-3 p-3">
            <div class="mx-5 mt-2 sm_container">
                <div class="sm w-50">
                    <label for="name" class="fs-4 mt-3">Nom</label>
                    <input type="text" class="form-control" name="nom" placeholder="Nom" v-model="last_name" disabled required v-on:focusin="removeError">
                <span
                v-bind:class="invalidLastNameState ? 'text-danger' : '' "
                v-if="invalidLastNameState">{{invalidLastNameStateText}}</span>
                </div>
                <div class="sm w-50 mr-0">
                    <label for="surname" class="fs-4 mt-3">Prenom</label>
                    <input type="text" class="form-control" name="prenom" placeholder="Prenom" v-model="first_name" disabled required
                    v-on:focusin="removeError">
                </div>
                <span
                v-bind:class="invalidFirstNameState ? 'text-danger' : '' "
                v-if="invalidFirstNameState">{{invalidFirstNameStateText}}</span>
            </div>
            <div class="mx-5 mt-2">
                <label for="adresse" class="fs-4 mt-3">Adresse</label>
                <div class="d-flex">
                    <input type="text" class="form-control w-75 mt-2" name="adresse" placeholder="Adresse" v-model="address" disabled required
                    v-on:focusin="removeError">
                </div>
                <span
                v-bind:class="invalidAddressState ? 'text-danger' : '' "
                v-if="invalidAddressState">{{invalidAddressStateText}}</span>
            </div>
            <div class="mx-5 mt-2 sm_container">
                <div class="sm w-50">
                    <label for="genre" class="fs-4 mt-3">Genre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="genre" placeholder="Genre" :value="data.genre ? 'Homme' : 'Femme'" disabled required>
                        <i class="bi bi-question-octagon profil-question"></i>
                    </div>
                </div>
                <div class="sm w-50 mr-0">
                    <label for="dob" class="fs-4 mt-3">Date de naissance</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="dob" placeholder="Date de naissance" :value="data.dob" disabled required>
                        <i class="bi bi-question-octagon profil-question"></i>
                    </div>
                </div>
            </div>
            <div class="mx-5 mt-4">
                <label for="phone" class="fs-4 mt-3">Numéro de téléphone</label>
                <input type="text" class="form-control w-75 mt-2" name="phone" placeholder="Numéro de téléphone" v-model="number" disabled required
                v-on:focusin="removeError">
                <span
                v-bind:class="invalidNumberState ? 'text-danger' : '' "
                v-if="invalidNumberState">{{invalidNumberStateText}}</span>
            </div>
            <div class="mt-3">
                <div class="mx-5 d-flex">
                    <button type="button" class="btn btn-warning btn-lg" @click.prevent="startEditing">Modifier</button>
                    <div v-if="showCancelBtn === true && showSaveBtn === true" class="d-flex animate__animated animate__bounceIn">
                        <cancel-editing-vue @canceled="goBack" />
                        <save-editing-vue @saved="onSubmit" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import saveEditingVue from '../../components/saveEditing.vue'
import cancelEditingVue from '../../components/cancelEditing.vue'
import jbox from 'jbox'
import { useToast } from "vue-toastification"

export default {
    setup() {
        const toast = useToast();
        return {toast}
    },
    props: {
        data: Object
    },
    emits: ['infoEdited'],
    methods: {
        onSubmit: function() {
            if (
                this.copy_first_name == this.first_name
                && this.copy_last_name == this.last_name
                && this.copy_address == this.address
                && this.copy_number == this.number
            ) {
                this.toast.warning("Aucune modification n'a été effectuée", {timeout: 2000})
                return false
            }
            this.checkText(this.last_name, "nom")
            this.checkText(this.first_name, "prenom")
            this.checkText(this.address, "adresse")
            this.checkNumber(this.number)
            if (this.invalidFirstNameState || this.invalidLastNameState || this.invalidAddressState || this.invalidNumberState ||
            this.invalidFirstNameState
            && this.invalidLastNameState
            && this.invalidAddressState
            && this.invalidNumberState) {
                return false
            }else{
                axios.post('/api/editCred', {
                    f: this.first_name,
                    l: this.last_name,
                    a: this.address,
                    n: this.number,
                    option: 'profil'
                })
                .then(res => {
                    if (res.data.status) {
                        this.toast.success("Modification effectuée avec succès", {timeout: 2000})
                        this.$emit('infoEdited')
                        this.goBack()
                    }
                })
                .catch(err => console.log(err))
            }
        },
        goBack: function(e) {
            this.showCancelBtn = false
            this.showSaveBtn = false
            this.parent.appendChild(this.editBtn)
            for(const el of this.inputs) {
                el.disabled = true
            }
            this.invalidFirstNameState = false
            this.invalidLastNameState = false
            this.invalidAddressState = false
            this.invalidNumberState = false
            this.first_name = this.copy_first_name
            this.last_name = this.copy_last_name
            this.address = this.copy_address
            this.number = this.copy_number
        },
        startEditing: function(e) {
            this.inputs = document.querySelectorAll('.edit-profil')[0].querySelectorAll('input')
            this.parent = e.target.parentNode
            this.editBtn = e.target
            this.inputs.forEach(function(el) {
                el.disabled = el.name === "genre" ? true : el.name === "dob" ? true : false
            })
            this.inputs[0].focus()
            this.parent.removeChild(this.editBtn)
            this.showCancelBtn = true
            this.showSaveBtn = true
        },
        checkText: function(value, state) {
            if (state === "nom") {
                if (value.match(/^[a-zA-z\D]+$/)) this.invalidLastNameState = false
                else this.invalidLastNameState = true
            }else if (state === "prenom"){
                if (value.match(/^[a-zA-z\D]+$/)) this.invalidFirstNameState = false
                else this.invalidFirstNameState = true
            }else{
                if (value.match(/^[a-zA-z\D]+$/)) this.invalidAddressState = false
                else this.invalidAddressState = true
            }
        },
        checkNumber: function(value) {
            if (value.match(/^([5-9])[0-9]{7}$/)) this.invalidNumberState = false
            else this.invalidNumberState = true
        },
        getData: function() {
            this.first_name = this.data.prenom
            this.last_name = this.data.nom
            this.address = this.data.adresse
            this.number = this.data.telephone
            this.copy_first_name = this.first_name
            this.copy_last_name = this.last_name
            this.copy_address = this.address
            this.copy_number = this.number
        },
        removeError: function(e) {
            if (e.target.name === "nom") {
                this.invalidLastNameState = false
            }else if (e.target.name === "prenom") {
                this.invalidFirstNameState = false
            }else if (e.target.name === "adresse") {
                this.invalidAddressState = false
            }else{
                this.invalidNumberState = false
            }
        }
    },
    components: {cancelEditingVue, saveEditingVue},
    data() {
        return {
            showCancelBtn: false,
            showSaveBtn: false,
            editBtn: null,
            parent: null,
            inputs: [],
            invalidFirstNameState: false,
            invalidFirstNameStateText: 'Vérifier la valeur de votre prenom',
            invalidLastNameState: false,
            invalidLastNameStateText: 'Vérifier la valeur de votre nom',
            invalidAddressState: false,
            invalidAddressStateText: 'Vérifier la valeur de votre adresse',
            invalidNumberState: false,
            invalidNumberStateText: 'Vérifier la valeur de votre numéro de téléphone',
            first_name: '',
            copy_first_name: '',
            last_name: '',
            copy_last_name: '',
            address: '',
            copy_address: '',
            number: '',
            copy_number: ''
        }
    },
    mounted() {
        let main = document.querySelectorAll('.edit-profil i.bi.bi-question-octagon')
        main.forEach((value) => {
            new jbox('Tooltip', {
                attach: `.${value.classList[2]}`,
                trigger: 'mouseenter',
                content: 'Vous ne pouvez pas modifier cette information',
                theme: 'TooltipBorder'
            })
        })
    },
    watch: {
        data: function() {
            this.getData()
        }
    }
}
</script>
