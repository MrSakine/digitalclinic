<template>
    <div class="fs-5"
        v-for="object in objects" :key="object"
    >
        <span> - </span>
        <span>Medicaments: {{object.medicament}} | </span>
        <span>Posologies: {{object.modeEmploi}} | </span>
        <span>Quantité: {{object.quantite}}</span>
    </div>
</template>

<script>
export default {
    props: {
        objects: Array
    }
}
</script>