<template>
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button
                class="accordion-button collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                    Nouveau Ordonnance
                </button>
            </h2>
            <div class="accordion-collapse collapse" id="collapseTwo">
                <div class="accordion-body">
                    <div v-for="object in objects" :key="object">
                        <div class="d-flex fs-5">
                            <p class="text-bold mr-2">Medicaments:</p>
                            <p class="mx-2">{{object.medicament}}, </p>
                            <p class="text-bold">Posologies:</p>
                            <p class="mx-2">{{object.modeEmploi}}, </p>
                            <p class="text-bold">Quantité:</p>
                            <p class="mx-2">{{object.quantite}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Ordonnance from '../../objects/Ordonnance'

export default {
    props: {
        objects: Array[Ordonnance]
    },
    mounted() {
    },
}
</script>
