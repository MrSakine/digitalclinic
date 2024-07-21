<template>
    <div id="fiche" class="container">
        <div class="text-dark text-center fs-1 text-decoration-underline">
            Fiche de consultation
        </div>

        <div class="container text-end">
            Date Création : {{ creationDate }}
        </div>
        <div class="d-flex justify-content-between rows-3">
            <div>
                Nom et Prémon: {{ maladeNom }} {{ maladeprenom }} <br />
                Age: {{ maladeAge }} <br />
                Adresse: {{ adresse }} <br />
                Genre : {{ genre }} <br />
            </div>
            <div id="title">CLINIC DIGITAL</div>
            <div>
                Type de consulation : {{typeConsulation}} <br/>
                Température : {{ temperature }}°C<br />
                Groupe Sanguin : {{ groupeSanguin }}<br />
            </div>
        </div>
        <hr />
        <div class="fs-3 text-center text-decoration">
            Description de la maladie
        </div>
        <div class="text-center">
            {{ description }}
        </div>
        <div class="container text-center round">
            <hr />
            Antécédents Médicaux : {{ AntecedantMedicaux }}
        </div>
        <div class="container text-center round">
            <hr />
            Traitement initial : {{ traitementInitial }}
        </div>
        <br />
        <br />
    </div>
</template>
<script>
export default {
    data() {
        return {
            
        }
    },
    props: {
        maladeNom: String,
        maladeprenom: String,
        adresse: String,
        maladeAge: Number,
        genre: String,
        creationDate: String,
        description: String,
        groupeSanguin: String,
        AntecedantMedicaux: String,
        traitementInitial: String,
        typeConsulation: String,
        temperature: Number
    },
};
</script>
