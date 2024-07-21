<template>
    <div>
        <button type="button" class="btn btn-secondary btn-lg" @click.prevent="cancel">Annuler</button>
    </div>
</template>

<script>
export default {
    emits: ['canceled'],
    methods: {
        cancel: function() {
            this.$emit('canceled')
        }
    },
}
</script>
