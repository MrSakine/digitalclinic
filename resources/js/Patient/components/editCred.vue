<template>
    <div>
        <form action="#" method="POST" class="edit-profil shadow-sm bg-light rounded mb-3 p-3">
            <div class="mx-5 mt-2">
                <label for="mail" class="fs-4 mt-3">Email</label>
                <input type="text" class="form-control w-75 mt-2" name="mail" placeholder="Adresse mail" disabled required v-model="oldEmail"
                v-on:focusin="removeError" />
                <span
                v-bind:class="invalidEmailState ? 'text-danger' : '' "
                v-if="invalidEmailState">{{invalidEmailStateText}}</span>
            </div>
            <div class="mx-5 mt-4">
                <label for="password" class="fs-4 mt-3">Mot de passe</label>
                <div class="d-flex">
                    <input type="password" class="form-control w-75 mt-2" name="password" placeholder="Mot de passe" disabled required v-model="oldPass"
                    v-on:focusin="removeError" />
                    <i class="bi bi-eye-slash mt-3" @click="togglePassword"></i>
                </div>
                <span
                v-bind:class="invalidPasswordState ? 'text-danger' : '' "
                v-if="invalidPasswordState">{{invalidPasswordStateText}}</span>
            </div>
            <div class="mt-2">
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
        togglePassword: function (e) {
            const t = e.target.parentNode.querySelector('input')
            if (t.disabled === true) {
                return false
            }
            const type = t.getAttribute("type") === "password" ? "text" : "password"
            t.setAttribute("type", type)
            t.value = t.disabled ? '' : t.value
            e.target.classList.toggle("bi-eye")
        },
        goBack: function() {
            this.showCancelBtn = false
            this.showSaveBtn = false
            this.parent.appendChild(this.editBtn)
            for(const el of this.inputs) {
                el.disabled = true
            }
            let el = document.querySelectorAll('.edit-profil')[1].querySelector('div:nth-child(2) > div'),
            input = el.querySelector('input'),
            icon = el.querySelector('i')
            input.setAttribute("type", "password")
            icon.classList.remove("bi-eye")
            icon.classList.add("bi-eye-slash")
            this.oldPass = this.password
            this.invalidEmailState = false
            this.invalidPasswordState = false
            this.oldEmail = this.copy_oldEmail
        },
        startEditing: function(e) {
            this.inputs = document.querySelectorAll('.edit-profil')[1].querySelectorAll('input')
            this.parent = e.target.parentNode
            this.editBtn = e.target
            this.inputs.forEach(function(el) {
                el.disabled = false
                if (el.type === "password"){
                    this.oldPass = 'password'
                }
            }.bind(this))
            this.inputs[0].focus()
            this.parent.removeChild(this.editBtn)
            this.showCancelBtn = true
            this.showSaveBtn = true
        },
        getData: function() {
            this.oldEmail = this.data.email
            this.oldPass = this.password
            this.copy_oldEmail = this.oldEmail
        },
        validateEmail: function(email) {
            return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
        },
        onSubmit: function() {
            if (
                this.copy_oldEmail == this.oldEmail
                && this.oldPass == 'password'
            ){
                this.toast.warning("Aucune modification n'a été effectuée", {timeout: 2000})
                return false
            }
            this.checkEmail(this.oldEmail)
            this.checkPassword(this.oldPass)

            if (this.invalidEmailState || this.invalidPasswordState || this.invalidEmailState && this.invalidPasswordState) {
                return false
            }else{
                axios.post('/api/editCred', {
                    email: this.oldEmail,
                    password: this.oldPass,
                    option: 'cred'
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
        checkEmail: function(email) {
            if (!this.validateEmail(email)){
                this.invalidEmailState = true
            }else{
                this.invalidEmailState = false
            }
        },
        checkPassword: function(password) {
            if (password.length < 6) {
                this.invalidPasswordState = true
            }else{
                this.invalidPasswordState = false
            }
        },
        removeError: function(e) {
            if (e.target.name === "mail") {
                this.invalidEmailState = false
            }else{
                this.invalidPasswordState = false
            }
        }
    },
    data() {
        return {
            password: 'DIGITAL CLINIC 2022',
            showCancelBtn: false,
            showSaveBtn: false,
            editBtn: null,
            parent: null,
            inputs: [],
            oldEmail: '',
            copy_oldEmail: '',
            oldPass: '',
            invalidPasswordState: false,
            invalidEmailState: false,
            invalidPasswordStateText: "Entrer un mot de passe long, d'au moins 6 caracteres",
            invalidEmailStateText: "Entrer un email valide"
        }
    },
    components: {cancelEditingVue, saveEditingVue},
    watch: {
        data: function() {
            this.getData()
        }
    }
}
</script>

<style scoped>
i.bi.bi-eye-slash,
i.bi.bi-eye {
    margin: 2px 0 0 -30px;
    padding: 2px;
    cursor: pointer;
}
</style>
