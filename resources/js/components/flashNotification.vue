<template>
    <div>
        <h1>{{title}}</h1>
        <span>{{content}}</span>
    </div>
</template>

<script>

export default {
    props: {
        title: String,
        content: String
    },
    mounted() {
        this.toast = useToast()
        this.toast.info('Test')
    },
    data() {
        return {
            toast: null
        }
    },
}
</script>
