<template>
    <div class="container-sm mb-3 mt-4 w-100">
        <nav-bar :monCompte="true"></nav-bar>
        <div>
            <div class="home_container_right__profil">
                <p>Profil</p>
                <edit-profil-vue :data="data" @infoEdited="getData" />
            </div>
            <div class="home_container_right__mdp">
                <p class="mt-5">Mettre à jour l'email ou le mot de passe</p>
                <edit-cred :data="data" @infoEdited="getData" />
            </div>
        </div>
    </div>
</template>

<script>
import navBar from '../components/CompteNavBar.vue'
import editProfilVue from '../components/editProfil.vue'
import editCred from '../components/editCred.vue'

export default {
    components: {navBar, editProfilVue, editCred},
    data() {
        return {
            data: []
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData: function() {
            axios.get('/api/getUser')
            .then((rep) => {
                this.data = rep.data.details
            })
            .catch(err => console.log(err.response.data))
        }
    },
}
</script>
