<template>
    <div class="modal fade" id="editPassword" aria-hidden="true" aria-labelledby="editPasswordLabel"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg p-3">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modification du mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="clearAll"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form action="#" method="POST" v-on:submit.prevent="editpasswordSubmitHandler">
                            <div class="mb-3">
                                <label for="ancienMotDePasse" class="form-label">Ancien mot de passe</label>
                                <input type="password" name="amdp" class="form-control w-75" placeholder="Entrer votre ancien mot de passe"
                                v-model="models.mOldPassword" required autocomplete="off" @focusin="removeError">
                                <span v-bind:class="oldPasswordState ? 'text-danger' : ''">
                                    {{oldPasswordState ? oldPasswordStateText : ''}}
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="nouveauMotDePasse" class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="nmdp" class="form-control w-75" placeholder="Entrer votre nouveau mot de passe"
                                v-model="models.mFirstPassword" required autocomplete="off" @focusin="removeError">
                                <span v-bind:class="newFirstPasswordState ? 'text-danger' : ''">
                                    {{newFirstPasswordState ? newFirstPasswordStateText : ''}}
                                </span>
                            </div>
                            <div class="mb-3">
                                <label for="confirmerNouveauMotDePasse" class="form-label">Confirmer votre nouveau mot de passe</label>
                                <input type="password" name="cnmdp" class="form-control w-75" placeholder="Confirmer votre nouveau mot de passe"
                                v-model="models.mSecondPassword" required autocomplete="off" @focusin="removeError">
                                <span v-bind:class="newSecondPasswordState ? 'text-danger' : ''">
                                    {{newSecondPasswordState ? newSecondPasswordStateText : ''}}
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            oldPasswordState: false,
            newFirstPasswordState: false,
            newSecondPasswordState: false,
            oldPasswordStateText: "Verifier la valeur de votre ancien mot de passe",
            newFirstPasswordStateText: "Verifier la valeur de votre nouveau mot de passe",
            newSecondPasswordStateText: "Les mots de passe ne correspondent pas",
            models: {
                mOldPassword: '',
                mFirstPassword: '',
                mSecondPassword: ''
            },
            userEmail: localStorage.getItem('authMedecinEmail'),
        }
    },
    methods: {
        editpasswordSubmitHandler: function(e) {
            e.preventDefault()
            this.checkOldPassword(this.models.mOldPassword)
            this.checkNewFirstPassword(this.models.mFirstPassword)
            this.checkNewSecondPassword(this.models.mFirstPassword)
            if (
                this.oldPasswordState == false
                && this.newFirstPasswordState == false
                && this.newSecondPasswordState == false
            ) {
                setTimeout(() => {
                    axios.post('/api/editPassword', {
                        user: this.userEmail,
                        oldPassword: this.models.mOldPassword,
                        newPassword: this.models.mFirstPassword
                    })
                    .then((rep) => {
                        let d = rep.data
                        if (d.status === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: d.message + '. Vous allez etre déconnecté, utiliser le nouveau mot de passe pour vous connecter',
                                confirmButtonText: 'Fermer'
                            })
                            .then((r) => {
                                if (r.isConfirmed) {
                                    localStorage.removeItem("authMedecin")
                                    localStorage.removeItem("authMedecinEmail")
                                    this.$router.push({name: 'login'})
                                }
                            })
                        }else{
                            this.oldPasswordState = true
                            this.oldPasswordStateText = d.message
                        }
                    })
                    .catch((err) => {
                        console.log(err.response.data)
                    })
                }, 1000)
                return true
            }
            
            return false
        },
        checkOldPassword: function(v) {
            if (v.length < 6) this.oldPasswordState = true
            else this.oldPasswordState = false
        },
        checkNewFirstPassword: function(v) {
            if (v.length < 6) this.newFirstPasswordState = true
            else if (v === this.models.mOldPassword) {
                this.newFirstPasswordState = true
                this.newFirstPasswordStateText = "Vueillez entrer un nouveau mot de passe"
            }
            else this.newFirstPasswordState = false
        },
        checkNewSecondPassword: function(v) {
            if (this.models.mSecondPassword != v) this.newSecondPasswordState = true
            else this.newSecondPasswordState = false
        },
        removeError: function(e) {
            if (e.target.name == 'amdp') this.oldPasswordState = false
            else if (e.target.name == 'nmdp') this.newFirstPasswordState = false
            else this.newSecondPasswordState = false
        },
        clearAll: function() {
            this.oldPasswordState = false
            this.newFirstPasswordState = false
            this.newSecondPasswordState = false
            this.models.mOldPassword = ''
            this.models.mFirstPassword = ''
            this.models.mSecondPassword = ''
        }
    },
    
}
</script>