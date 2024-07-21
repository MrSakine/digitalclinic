<template>
  <loading-vue v-if="showLoading" text="Verification de vos informations"></loading-vue>
  <div id="appHome">
    <nav-bar :loginActive="true"></nav-bar>
    <div class="section__login-title">
        <h1>connexion</h1>
    </div>
  </div>
  <div class="mb-3 mt-4">
    <div class="row w-100">
        <div class="col">
            <img data-aos="fade-right" data-aos-duration="1200" data-aos-offset="300" data-aos-easing="ease-in-sine" src="/storage/images/home.svg" alt="Home" />
        </div>
        <div class="col" style="margin: 190px auto;">

            <form
            data-aos-duration="1200"
            data-aos="fade-left"
            data-aos-anchor="#example-anchor"
            data-aos-offset="500"
             method="POST" class="form_container " id="loginForm" v-on:submit.prevent="submitEventHandler" action="#">
             <div data-aos="filde-left" data-aos-duration="1200" class="mb-4 col-5 m-auto w-50">
                <label for="email" class="form-label">Email</label>
                <div class="d-flex">
                <span class="input-group-text">
                <i class="bi bi-person" style='color:#00e4fa;'></i>
                </span>
                <input type="email" ref="email" v-model="emailModel" name="email" class="form-control" placeholder="example@domain.com" required autocomplete="off"
                style="background-color: #f2f6fc;height:44px;" @focusin="removeError" data-bs-toggle="tooltip" data-bs-placement="top" title="Entrer une adresse mail" />
                <span v-bind:class="invalidEmailState ? 'text-danger' : '' ">{{invalidEmailStateText}}</span>
            </div>
             </div>
            <div class="d-flex w-75">
                <div class="flex-grow-1">
                    <div class="m-auto w-25 mr-3">
                        <label for="password" class="form-label">Mot de passe</label>
                    </div>
                </div>
                <a href="#" style="color: 00e4fa;">
                    <span data-aos="zoom-out" data-aos-duration="1000" data-aos-offset="200">Oublié?</span>
                </a>
            </div>
            <div  data-aos="fade-up" data-aos-duration="1200" class="input-group col-5 m-auto w-50">
              <span class="input-group-text">
                <i class="bi bi-lock-fill"  style='color:#00e4fa;'></i>
                </span>
                <input type="password" name="password" v-model="passwordModel" class="form-control" placeholder="Mot de passe" required autocomplete="off"
                style="background-color: #f2f6fc;height:44px;" @focusin="removeError" data-bs-toggle="tooltip" data-bs-placement="top" title="Entrer un mot de passe fort" />
                <span class="input-group-text">
                    <i class="bi bi-eye-slash" style="cursor:pointer;" @click="togglePassword"></i>
                </span>
                  <span v-bind:class="invalidPasswordState ? 'text-danger' : '' ">{{invalidPasswordStateText}}</span>
            </div>
            <div  data-aos="flip-right" data-aos-duration="1200" data-aos-offset="80"  class="m-auto mb-3 mt-5 text-center">
                <button type="submit" id="submitBtn" name="submitButtom" class="btn btn-info btn-lg">Valider</button>
            </div>
            </form>
        </div>
    </div>
  </div>
</template>
<script>
import NavBar from '../components/NavBar.vue'
import LoadingVue from '../components/Loading.vue'
import { useToast } from "vue-toastification"

export default {
  components: {NavBar, LoadingVue},
    data() {
      return {
        invalidEmailState: true,
        invalidPasswordState: true,
        invalidEmailStateText: '',
        invalidPasswordStateText: '',
        emailModel: '',
        passwordModel: '',
        showError: false,
        showErrorText: '',
        showLoading: false,
        typeUser: null,
      }
    },
    mounted() {
      console.log('mounted!')
      this.showLoading = false
    },
    methods: {
      removeError: function(e) {
        if (e.target.type == "email") {
          this.invalidEmailState = false
          this.invalidEmailStateText = ''
          this.removeInvalidLoginErrorText()
        }else{
          this.invalidPasswordState = false
          this.invalidPasswordStateText = ''
          this.removeInvalidLoginErrorText()
        }
      },
        togglePassword: function(e) {
            const t = e.target.parentNode.parentNode.querySelector('input')
            const type = t.getAttribute("type") === "password" ? "text" : "password"
            t.setAttribute("type", type)
            e.target.classList.toggle("bi-eye")
        },
      checkEmail: function(email) {
        if (!this.validateEmail(email)){
          this.invalidEmailState = true
          this.invalidEmailStateText = "Entrer un email valide"
        }
      },
      checkPassword: function(password) {
        if (password.length < 6) {
          this.invalidPasswordState = true
          this.invalidPasswordStateText = "Entrer un mot de passe long, d'au moins 6 caracteres"
        }
      },
      submitEventHandler: function(e) {
        e.preventDefault()
        this.checkEmail(this.emailModel)
        this.checkPassword(this.passwordModel)
        let submitBtn = document.getElementById("submitBtn")

        if (this.invalidEmailState == true && this.invalidPasswordState == true) {
          submitBtn.classList.add("animate__animated", "animate__headShake")
          this.invalidEmailState = true
          this.invalidPasswordState = true
          this.invalidEmailStateText = "Entrer un email valide"
          this.invalidPasswordStateText = "Entrer un mot de passe long d'au moins 6 caracteres"
        }else if (this.invalidEmailState == true) {
          this.invalidEmailStateText = "Entrer un email valide"
          this.invalidPasswordStateText = ''
          return false
        }else if (this.invalidPasswordState == true){
          this.invalidPasswordStateText = "Entrer un mot de passe long, d'au moins 6 caracteres"
          this.invalidEmailStateText = ''
          return false
        }else{
          this.showLoading = true
          setTimeout(() => {
            axios.get('/sanctum/csrf-cookie').then(() => {
              axios.post('/api/checklogin', {
                email: this.emailModel,
                password: this.passwordModel
              })
              .then((rep) => {
                  if (rep.status == 200 && rep.data.loggedIn == 1) {
                    this.showLoading = false
                    this.typeUser = rep.data.type
                    if (this.typeUser === 'patient') {
                        localStorage.setItem("authPatient", "true")
                        localStorage.setItem("authPatientEmail", this.emailModel)
                        window.location.assign('/accueil/patient')
                    }
                    else {
                        localStorage.setItem("authMedecin", "true")
                        localStorage.setItem("authMedecinEmail", this.emailModel)
                        window.location.assign('/accueil/medecin')
                    }
                  }
              })
                .catch((err) => {
                  if (err.response.status == 401) {
                    this.showLoading = false
                    this.showErrorText = err.response.data.message
                    this.showError = true
                    const toast = useToast()
                    toast.error(this.showErrorText, {timeout: 2000})
                }else{
                    this.showLoading = false
                    console.log(err)
                }
              })
            })
            .catch(err => console.log(err))
          }, 1000)
        }
      },
      validateEmail: function(email) {
        return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
      },
      removeInvalidLoginErrorText: function() {
        setTimeout(() => {
          this.showError = false
        }, 100)
      }
    }

}
</script>
