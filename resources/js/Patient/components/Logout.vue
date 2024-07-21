<template>
    <a class="dropdown-item" href="javascript:void(0)" @click="logout">Se deconnecter</a>
</template>

<script>
export default {
    methods: {
        logout: function() {
            localStorage.removeItem("authPatient")
            localStorage.removeItem("authPatientEmail")
            axios.post('/api/patient/logout', {})
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
    }
}
</script>
