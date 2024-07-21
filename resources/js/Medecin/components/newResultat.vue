<template>
    <div class="accordion">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button
                class="accordion-button collapsed"
                type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Nouveau Resultat
                </button>
            </h2>
            <div class="accordion-collapse collapse" id="collapseOne">
                <div class="accordion-body">
                    <div class="col-4 d-flex">
                        <p class="fs-5 text-bold mx-4">Observation:</p>
                        <p class="fs-5">{{observation}}</p>
                    </div>
                    <div class="col-4 p-2 d-flex">
                        <p class="fs-5 text-bold mx-4">Diagnostic:</p>
                        <p class="fs-5">{{diagnostic}}</p>
                    </div>
                    <div class="col-4 p-2 d-flex">
                        <p class="fs-5 text-bold mx-4">Conseil:</p>
                        <p class="fs-5">{{conseil}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        observation: String,
        diagnostic: String,
        conseil: String,
    },
}
</script>
