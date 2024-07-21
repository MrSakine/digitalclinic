<template>
    <div class="p-2">
        <p class="fs-2 text-secondary">{{ text }}</p>
    </div>
</template>

<script>
export default {
    props: {
        text: String
    }
}
</script>