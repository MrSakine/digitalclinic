<template>
  <div class="shadow-sm p-3 mb-2 bg-body rounded">
        <div class="d-flex">
            <div class="flex-grow-1">
                <p class="fs-6 m-0">
                    <span class="text-secondary">Type: {{type}} | </span>
                    <span class="text-secondary">Fait par: {{made_by}} | </span>
                    <span class="text-secondary">Créé: {{date}}</span>
                </p>
                <p class="fs-2 m-0 mx-2"> <i class="bi bi-people"></i> {{typeConsultation}}</p>
                <p class="fs-6">
                    <span class="text-secondary">Heure: {{meeting}} | </span>
                    <span class="text-secondary">Status: <span :class="status === true ? 'no' : 'yes'"></span>
                        {{status === true ? 'Expiré' : 'Valide'}}
                    </span>
                </p>
            </div>
            <div class="mt-4" v-if="status === true">
                <a class="btn btn-danger" @click="onDelete(id)">Supprimer</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        date: String,
        made_by: String,
        type: String,
        typeConsultation: String,
        meeting: String,
        status: Boolean
    },
    emits: ['onDelete'],
    methods: {
        onDelete: function(id) {
            this.$emit('onDelete', {id: id})
        }
    },
}
</script>
