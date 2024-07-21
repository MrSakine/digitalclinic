<template>
    <div class="bg-light w-25 p-2 mb-5">
        <p class="fs-5 font-weight-bold">Information sur le medecin</p>
        <ul>
            <li>Nom: <span>{{data.nom}}</span></li>
            <li>Prenom: <span>{{data.prenom}}</span></li>
            <li>Adresse: <span>{{data.adresse}}</span></li>
            <li>Age: <span>{{data.age}}</span></li>
            <li>Genre: <span>{{data.genre ? 'Homme' : 'Femme'}}</span></li>
        </ul>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getInfo()
    },
    methods: {
        getInfo: function() {
            axios.post('/api/getMedecinInfo', {
                id: this.id
            })
            .then((rep) => {
                this.data = rep.data.details
            })
            .catch(err => console.log(err.response.data))
        }
    },
    data() {
        return {
            data: []
        }
    },
    props: {
        id: Number
    }
}
</script>