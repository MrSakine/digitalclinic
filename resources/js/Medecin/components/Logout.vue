<template>
    <a class="dropdown-item" href="javascript:void(0)" @click="logout">Se deconnecter</a>
</template>

<script>
export default {
    methods: {
        logout: function() {
            localStorage.removeItem("authMedecin")
            localStorage.removeItem("authMedecinEmail")
            axios.post('/api/medecin/logout', {})
            .then((rep) => {
                if (rep.data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succes',
                        text: rep.data.message
                    })
                    .then(() => {
                        window.location.assign('/login')
                    })
                }
            })
        }
    },
    data() {
        return {
        }
    },
}
</script>
