<template>
    <div>
        <button type="submit" class="btn btn-primary btn-lg mx-3" @click.prevent="save">Sauvegarder</button>
    </div>
</template>

<script>
export default {
    emits: ['saved'],
    methods: {
        save: function() {
            this.$emit('saved')
        }
    },
}
</script>
