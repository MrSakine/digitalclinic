<template>
    <loading-vue v-if="showLoading" :text="textLoading" />
    <Title />
    <div class="container border border-dark rounded-2 p-1">
        <div class="p-1 d-flex">
            <div class="flex-grow-1">
                <a class="btn btn-success" @click="checkBoite">
                    Ecrire un message
                </a>
            </div>
            <div class="fs-2">
                <button type="button"  class="btn btn-success border-0 m-1" data-bs-toggle="modal" data-bs-target="#resultat"> Ajouter Resultat</button>
                <button type="button"  class="btn btn-success border-0 m-1" data-bs-toggle="modal" data-bs-target="#ordonnance">Ajouter Ordonnance</button>
            </div>
            <resultat @newR="loadR" />
            <ordonnance @newOrdo="loadOrdo" />
        </div>
        <div style="background: #eee;">
            <traitement-vue
                :maladeNom="data.nom"
                :maladeprenom="data.prenom"
                :adresse="data.adresse"
                :maladeAge="Number(data.age)"
                :genre="data.genre ? 'Homme' : 'Femme'"
                :creationDate="data.date"
                :typeConsulation="data.type"
                :temperature="Number(data.temp)"
                :groupeSanguin="data.groupSangin"
                :description="data.descriptionMaladie"
                :AntecedantMedicaux="data.antMedicaux"
                :traitementInitial="data.traitementIntial"
            ></traitement-vue>
            <div id="resultat__accordion" v-if="resultat" class="mt-3">
                <new-resultat
                    :observation="resultatData.observation"
                    :diagnostic="resultatData.diagnostic"
                    :conseil="resultatData.conseil"
                ></new-resultat>
            </div>
            <div id="ordonnance__accordion" v-if="ordonnance" class="mt-3">
                <new-ordonnace :objects="ordonnancesData.obj"></new-ordonnace>
            </div>
        </div>
    </div>
    <div>
        <button class="btn btn-primary btn-lg" @click="finalHandler">Valider</button>
    </div>
</template>
<script>
import Ordonnance from '../components/Ordonnance.vue'
import Resultat from '../components/Resultat.vue'
import Title from '../components/Title.vue'
import TraitementVue from '../components/Traiter.vue'
import newResultat from '../components/newResultat.vue'
import newOrdonnace from '../components/newOrdonnance.vue'
import LoadingVue from '../../components/Loading.vue'
import dateFormat from "dateformat"

export default {
    components: { Resultat, Ordonnance, Title, TraitementVue, newResultat, newOrdonnace, LoadingVue },
    data: function () {
        return {
            data: [],
            resultat: false,
            ordonnance: false,
            resultatData: null,
            ordonnancesData: null,
            userEmail: localStorage.getItem('authMedecinEmail'),
            startMessageLink: `/accueil/medecin/start-conversation/${this.$route.params.id}`,
            showLoading: false,
            textLoading: null
        }
    },
    mounted() {
        this.loadFullConsultations()
        localStorage.removeItem('resultatItems')
        localStorage.removeItem('ordonnances')
    },
    methods: {
        loadFullConsultations: function(){
            axios.post('/api/getFullConsultations', {
                id: this.$route.params.id
            })
            .then((rep) => {
                this.data = rep.data
            })
            .catch(err => console.log(err.response.data))
        },
        loadResultats: function() {
            if (localStorage.getItem('resultatItems')) {
                this.resultat = true
                this.resultatData = JSON.parse(localStorage.getItem('resultatItems'))
            }else{
                this.resultat = false
                this.resultatData = null
            }
        },
        loadOrdonnances: function() {
            if (localStorage.getItem('ordonnances')) {
                this.ordonnance = true
                this.ordonnancesData = JSON.parse(localStorage.getItem('ordonnances'))
            }else{
                this.ordonnance = false
                this.ordonnancesData = null
            }
        },
        finalHandler: function() {
            if (!localStorage.getItem('ordonnances') && !localStorage.getItem('resultatItems')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Veuillez associer au moins un résultat',
                    confirmButtonText: 'Fermer'
                })
                return false
            }else if (!localStorage.getItem('resultatItems')){
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Veuillez associer un résultat',
                    confirmButtonText: 'Fermer'
                })
            }else{
                if (!localStorage.getItem('ordonnances')) {
                Swal.fire({
                    icon: 'warning',
                    title: '&#202;tes-vous sûr?',
                    html: 'Vous &#234;tes sur le point de valider un traitement sans lier d\'ordonnances',
                    showCancelButton: true,
                    cancelButtonText: 'Annuler',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continuer',
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' }
                })
                .then(r => {
                    if (r.isConfirmed) {
                        this.showLoading = true
                        this.textLoading = 'Enregistrement du traitement...'
                        setTimeout(() => {
                            axios.post('/api/saveTraitement', {
                                id: this.$route.params.id,
                                user: this.userEmail,
                                resultat: this.resultatData,
                                ordonnances: null,
                                date: dateFormat(new Date(), 'dd/mm/yyyy HH:MM:ss')
                            })
                            .then((rep) => {
                                this.showLoading = false
                                this.textLoading = null
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: rep.data.message,
                                    confirmButtonText: 'Fermer'
                                })
                                this.$router.push({name: 'medecin-liste'})
                            })
                            .catch(err => {
                                this.showLoading = false
                                this.textLoading = null
                                console.log(err.response.data)
                            })
                        }, 500)
                    }
                })
                }else{
                    setTimeout(() => {
                        axios.post('/api/saveTraitement', {
                            id: this.$route.params.id,
                            user: this.userEmail,
                            resultat: this.resultatData,
                            ordonnances: this.ordonnancesData,
                            date: dateFormat(new Date(), 'dd/mm/yyyy HH:MM:ss')
                        })
                        .then((rep) => {
                            this.showLoading = false
                            this.textLoading = null
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: rep.data.message,
                                confirmButtonText: 'Fermer'
                            })
                            this.$router.push({name: 'medecin-liste'})
                        })
                        .catch(err => {
                            this.showLoading = false
                            this.textLoading = null
                            console.log(err.response.data)
                        })
                    }, 500)
                }
            }
        },
        deleteBtn: function(n, text) {
            let m = document.querySelector('#app > div > div.container > div.p-1 > div:nth-child(2)'),
            t = m.children.length,
            b = null
            if (t >= 2) b = m.querySelector(`button:nth-child(${n})`)
            else b = m.querySelector('button:nth-child(1)')
            m.removeChild(b)
            Swal.fire({
                icon: 'success',
                title: 'Succes',
                text: `${text} ajouté avec succès`
            })
        },
        loadR: function() {
            this.deleteBtn(1, 'Nouveau résultat')
            this.loadResultats()
        },
        loadOrdo: function() {
            this.deleteBtn(2, 'Nouvelle(s) ordonnance(s)')
            this.loadOrdonnances()
        },
        checkBoite: function(e) {
            e.preventDefault()
            axios.post('/api/cibe', {
                id: this.$route.params.id
            })
            .then(rep => {
                if (rep.data.exists === 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Boite existante',
                        html: '<div>Vous avez déja ouvert une boite de dialogue concernant cette consultation'+
                        '<hr/><div style="margin-bottom:15px;"><br><span style="font-weight:bold">X</span>: cliquer sur X pour fermer<br>' +
                        '<span style="font-weight:bold">Continuer:</span> pour aller sur la page de messagerie<br>' +
                        '<span style="font-weight:bold">Supprimer:</span> pour supprimer la boite</div></div>',
                        confirmButtonText: 'Continuer',
                        denyButtonText: 'Supprimer',
                        showDenyButton: true,
                        showCancelButton: false,
                        showCloseButton: true,
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.open(this.startMessageLink, '_blank').focus()
                        }else if (result.isDenied) {}
                    })
                }else{
                    window.open(this.startMessageLink, '_blank').focus()
                }
            })
        }
    },
};
</script>
<style>
#fiche {
    background: #eee;
}
#title {
    width: 30%;
    height: 100%;
    font-size: 2em;
    text-align: center;
    font-style: italic;
    transform: rotate(-20deg);
    color: rgb(150, 150, 160);
}
button.btn.btn-primary {
    margin-left: 15.5%;
    margin-top: 15px;
    padding: 5px;
    font-size: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    width: 69%;
    height: 40px;
    text-align: center;
}
</style>
