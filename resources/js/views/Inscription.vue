<template>
    <loading v-if="showLoading" text="Validation de l'inscription en cours"></loading>
    <div id="appHome">
        <nav-bar :inscriptionActive="true"></nav-bar>
        <div class="section__signup-title">
            <h1>inscription</h1>
        </div>
    </div>
    <div class="mb-3 mt-4 w-100">
        <div class="container mt-5 p-2">
            <form action="" method="POST" id="inscriptionForm" v-on:submit.prevent="inscriptionFormHandler">
                <div class="mb-3 col-5 m-auto w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                     data-aos-offset="500"
                     data-aos-duration="400"
                    >
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" placeholder="Entrer votre nom" required autocomplete="off"
                    style="background-color: #f2f6fc" v-model="nameModel" @focusin="removeError" />
                    <span v-bind:class="nameState ? 'text-danger' : ''">
                        {{nameState ? invalidNameStateText : ''}}
                    </span>
                </div>
                <div class="mb-3 col-5 m-auto w-50"
                data-aos="fade-left"
                 data-aos-anchor="#example-anchor"
                data-aos-offset="500"
                data-aos-duration="500">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input type="text" class="form-control" name="prenom" placeholder="Entrer votre prenom" required autocomplete="off"
                    style="background-color: #f2f6fc" v-model="surnameModel" @focusin="removeError" />
                    <span v-bind:class="surnameState ? 'text-danger' : ''">
                        {{surnameState ? invalidSurnameStateText : ''}}
                    </span>
                </div>
                <div class="mb-3 col-5 m-auto w-50"
                data-aos="fade-left"
                data-aos-anchor="#example-anchor"
                data-aos-offset="500"
                data-aos-duration="600">
                    <label for="dob" class="form-label">Date de naissance</label>
                    <cleave v-model="date" id="date" type="text" class="form-control" name="dob" placeholder="Entrer votre de naissance" autocomplete="off" required
                     :options="options" style="background-color: #f2f6fc" @focusin="removeError"/>
                    <span v-bind:class="dateState ? 'text-danger' : ''">
                        {{dateState ? invalidDateStateText : ''}}
                    </span>
                </div>
                <div class="mb-3 col-5 m-auto w-50"
                data-aos="fade-left"
                data-aos-anchor="#example-anchor"
                data-aos-offset="500"
                data-aos-duration="700">
                    <label for="genre" class="form-label">Genre</label>
                    <select name="genre" id="genre" class="form-select form-control-inscription" aria-label="Genre selection" required style="background-color: #f2f6fc" @click="getGenre" @focusin="removeError">
                        <option selected class="text-secondary">Selectionner votre genre</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                    </select>
                    <span v-bind:class="genreState ? 'text-danger' : ''">
                        {{genreState ? invalidGenreStateText : ''}}
                    </span>
                </div>
                <div class="mb-3 col-5 m-auto w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="700"
                    data-aos-duration="700">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control form-control-inscription" required placeholder="Entrer votre adresse" style="background-color: #f2f6fc" autocomplete="off"
                    v-model="adresseModel" name="adresse" @focusin="removeError" />
                    <span v-bind:class="adresseState ? 'text-danger' : ''">
                        {{adresseState ? invalidAdressStateText : ''}}
                    </span>
                </div>
                <div class="mb-3 col-5 m-auto w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="800"
                    data-aos-duration="800">
                    <label for="num" class="form-label">Numéro de téléphone</label>
                    <cleave v-model="numberModel" id="number" class="form-control" required placeholder="Entrer votre numéro de téléphone" style="background-color: #f2f6fc"
                    autocomplete="off" name="num" :options="phoneOptions" @focusin="removeError" />
                    <span v-bind:class="numberState ? 'text-danger' : ''">
                        {{numberState ? invalidNumberStateText : ''}}
                    </span>
                </div>
                <div class="col-5 m-auto w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="900"
                    data-aos-duration="800">
                    <label for="email" class="form-label">Adresse email</label>
                </div>
                <div class="input-group col-5 m-auto w-50"
                data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="900"
                    data-aos-duration="800">
                    <input type="email" class="form-control" name="email" placeholder="Entrer votre adresse mail" required autocomplete="off"
                    style="background-color: #f2f6fc" v-model="emailModel" @focusin="removeError" />
                </div>
                <div class="col-5 m-auto mb-3 w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1000"
                    data-aos-duration="800">
                    <span v-bind:class="emailState ? 'text-danger' : ''">{{emailState ? invalidEmailStateText : ''}}</span>
                </div>
                <div class="col-5 m-auto w-50"
                data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1000"
                    data-aos-duration="800">
                    <label for="password" class="form-label">Mot de passe</label>
                </div>
                <div class="input-group col-5 m-auto w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1000"
                    data-aos-duration="900">
                    <input type="password" v-model="passwordModel" class="form-control" name="password" placeholder="Entrer votre mot de passe" required autocomplete="off"
                    style="background-color: #f2f6fc" @focusin="removeError" />
                    <span class="input-group-text">
                        <i class="bi bi-eye-slash" style="cursor:pointer;" @click="togglePassword"></i>
                    </span>
                </div>
                <div class="col-5 m-auto mb-3 w-50"
                    data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1000"
                    data-aos-duration="1000">
                    <span v-bind:class="passwordState ? 'text-danger' : '' ">{{passwordState ? invalidPasswordStateText : ''}}</span>
                </div>
                <div class="col-5 m-auto w-50"
                 data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1100"
                    data-aos-duration="800">
                    <label for="confirmpass" class="form-label">Confirmer mot de passe</label>
                </div>
                <div class="input-group mb-3 col-5 m-auto w-50"
                 data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1100"
                    data-aos-duration="1000">
                    <input type="password" v-model="secondPasswordModel" class="form-control" name="confirm_password"
                    placeholder="Confirmer votre mot de passe"
                    required autocomplete="off" style="background-color: #f2f6fc" @focusin="removeError" />
                    <span class="input-group-text">
                        <i class="bi bi-eye-slash" style="cursor:pointer;" @click="togglePassword"></i>
                    </span>
                </div>
                <div class="col-5 m-auto mb-3 w-50"
                data-aos="fade-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1000"
                    data-aos-duration="1100">
                    <span v-bind:class="newPasswordState ? 'text-danger' : '' ">{{newPasswordState ? invalidNewPasswordStateText : ''}}</span>
                </div>
                <div class="col-5 m-auto mb-3 text-center"
                 data-aos="flip-left"
                    data-aos-anchor="#example-anchor"
                    data-aos-offset="1100"
                    data-aos-duration="1200">
                    <button type="submit" class="btn btn-primary btn-lg">Valider</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Loading from '../components/Loading.vue'
import Patient from '../objects/Patient.js'

export default {
    components: {NavBar, Loading},
    data() {
        return {
            passwordState: false,
            newPasswordState: false,
            dateState: false,
            nameState: false,
            surnameState: false,
            adresseState: false,
            emailState: false,
            genreState: false,
            numberState: false,
            genreModel: '',
            invalidPasswordStateText: "Entrer un mot de passe long, d'au moins 6 caracteres",
            invalidNewPasswordStateText: "Vos mot de passes ne correspondent pas",
            invalidDateStateText: 'Verifier le format de votre date',
            invalidNameStateText: 'Entrer un nom valide',
            invalidSurnameStateText: 'Entrer un prenom valide',
            invalidAdressStateText: 'Entrer une adresse valide',
            invalidNumberStateText: 'Entrer un numero valide',
            invalidEmailStateText: 'Entrer un email valide',
            invalidGenreStateText: 'Veuillez selectionner un genre',
            date: null,
            options: {
                date: true,
                delimiter: '/',
                datePattern: ['d', 'm', 'Y']
            },
            phoneOptions: {
                numericOnly: true,
                blocks: [2, 2, 2, 2],
                delimiter: ' ',
            },
            passwordModel: '',
            nameModel: '',
            surnameModel: '',
            adresseModel: '',
            numberModel: '',
            emailModel: '',
            secondPasswordModel: '',
            showLoading: false

        }
    },
    mounted() {
        console.log('mounted!')
    },
    methods: {
        checkFirstPassword: function() {
            if (this.passwordModel.length < 6) this.passwordState = true
            else this.passwordState = false
        },
        checkSecondPassword: function(s) {
            let firstPassword = this.passwordModel
            if (s != firstPassword) this.newPasswordState = true
            else this.newPasswordState = false
        },
        checkDateFormat: function(date) {
            if (date.match(/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/)) this.dateState = false
            else this.dateState = true
        },
        checkGenre: function() {
            if (this.genreModel != '') this.genreState = false
            else this.genreState = true
        },
        checkEmail: function(email) {
            if (this.validateEmail(email)) this.emailState = false
            else this.emailState = true
        },
        checkName: function(value){
            if (value.match(/^[a-zA-z\D]+$/)) this.nameState = false
            else this.nameState = true
        },
        checkSurName: function(value) {
            if (value.match(/^[a-zA-z\D]+$/)) this.surnameState = false
            else this.surnameState = true
        },
        checkAdress: function(value) {
            if (value.match(/^[a-zA-z\D]+$/)) this.adresseState = false
            else this.adresseState = true
        },
        checkNumber: function(value) {
            if (value.match(/^([5-9])[0-9]{7}$/)) this.numberState = false
            else this.numberState = true
        },
        togglePassword: function(e) {
            const t = e.target.parentNode.parentNode.querySelector('input')
            const type = t.getAttribute("type") === "password" ? "text" : "password"
            t.setAttribute("type", type)
            e.target.classList.toggle("bi-eye")
        },
        inscriptionFormHandler: function(e) {
            e.preventDefault()
            this.checkName(this.nameModel)
            this.checkSurName(this.surnameModel)
            this.checkDateFormat(document.getElementById("date").value)
            this.checkGenre()
            this.checkAdress(this.adresseModel)
            this.checkNumber(document.getElementById("number").value.split(' ').join(''))
            this.checkEmail(this.emailModel)
            this.checkFirstPassword(this.passwordModel)
            this.checkSecondPassword(this.secondPasswordModel)
            if (
                this.nameState == false
                && this.surnameState == false
                && this.dateState == false
                && this.genreState == false
                && this.adresseState == false
                && this.numberState == false
                && this.emailState == false
                && this.passwordState == false
                && this.newPasswordState == false)
                {
                    this.showLoading = false
                    let g = this.genreModel === 'homme' ? true : false,
                    p = new Patient(
                        null, this.nameModel, this.surnameModel, this.emailModel, this.passwordModel, document.getElementById("date").value,
                        g, this.adresseModel, this.numberModel
                    )
                    setTimeout(() => {
                        axios.post('/api/saveUser', {
                            name: p.nom,
                            secondName: p.prenom,
                            email: p.email,
                            password: p.password,
                            date: p.dateNaissance,
                            genre: p.genre,
                            adresse: p.adresse,
                            number: p.telephone
                        })
                        .then((response) => {
                            this.showLoading = false
                            let g = response.data
                            if (g.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: 'Inscription réussi avec succès. Cliquez sur le button pour continuer',
                                    confirmButtonText: 'Fermer'
                                }).then(r => {
                                    if (r.isConfirmed){
                                        this.$router.push({name: 'login'})
                                    }
                                })
                                return true
                            }else{
                                this.showLoading = false
                                if (g.error == 'email'){
                                    this.emailState = true
                                    this.invalidEmailStateText = g.message
                                }else{
                                    this.numberState = true
                                    this.invalidNumberStateText = g.message
                                }
                            }
                        })
                        .catch(err => console.log(err))
                    })
            }
            return false
        },
        validateEmail: function(email) {
            return email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
        },
        removeError: function(e) {
            if (e.target.name == 'nom') this.nameState = false
            else if (e.target.name == 'prenom') this.surnameState = false
            else if (e.target.name == 'dob') this.dateState = false
            else if (e.target.name == 'adresse') this.adresseState = false
            else if (e.target.name == 'email') this.emailState = false
            else if (e.target.name == 'password') this.passwordState = false
            else if (e.target.name == 'genre') this.genreState = false
            else if (e.target.name == 'num') this.numberState = false
            else this.newPasswordState = false
        },
        getGenre: function(e) {
            this.genreModel = e.target.value
        }
    },
}
</script>
