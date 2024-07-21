<template>
    <div class="modal fade" id="resultat" aria-hidden="true" aria-labelledby="consultationLabel"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Résultat de Consultation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="clearAll" id="close"></button>
                </div>
                <div class="modal-body">
                    <div class="container border border-1 rounded-3 p-3 mb-2">
                        <form action="#" method="POST" v-on:submit.prevent="resultSubmissionHandler" id="resultatForm">
                            <div>
                                <label for="observation" class="form-label">Observations</label>
                                <textarea name="observation" class="form-control" rows="3" autocomplete="off" @focusin="removeError"
                                v-model="models.mObservation" placeholder="Observations..."></textarea>
                                <span v-bind:class="observationState ? 'text-danger' : ''">
                                    {{observationState ? errorText : ''}}
                                </span>
                            </div>
                            <div>
                                <label for="diagnostic" class="form-label">Diagnostics</label>
                                <textarea name="diagnostic" class="form-control" rows="3" autocomplete="off" @focusin="removeError"
                                v-model="models.mDiagnostic" placeholder="Diagnostics..."></textarea>
                                <span v-bind:class="diagnosticState ? 'text-danger' : ''">
                                    {{diagnosticState ? errorText : ''}}
                                </span>
                            </div>
                            <div>
                                <label for="conseil" class="form-label">Conseils</label>
                                <textarea name="conseil" class="form-control" rows="3" autocomplete="off" @focusin="removeError"
                                v-model="models.mConseil" placeholder="Conseils..."></textarea>
                                <span v-bind:class="conseilState ? 'text-danger' : ''">
                                    {{conseilState ? errorText : ''}}
                                </span>
                            </div>
                            <button class="btn btn-primary float-end mb-2 mt-5" type="submit">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    emits: ['newR'],
    data() {
        return {
            observationState: false,
            diagnosticState: false,
            conseilState: false,
            errorText: "Verifier la valeur du champ",
            models: {
                mObservation: '',
                mDiagnostic: '',
                mConseil: ''
            }
        }
    },
    methods: {
        resultSubmissionHandler: function(e) {
            e.preventDefault()
            let d = document.getElementById('resultatForm'), areas = d.querySelectorAll('textarea')
            for(const i of areas) {
                this.checkInput(i)
            }
            if (
                this.observationState == false
                && this.diagnosticState == false
                && this.conseilState == false
            ){
                if (localStorage.getItem('resultatItems')){
                    localStorage.removeItem('resultatItems')
                }

                localStorage.setItem('resultatItems', JSON.stringify(
                    {
                        observation: this.models.mObservation,
                        diagnostic: this.models.mDiagnostic,
                        conseil: this.models.mConseil
                    }
                ))
                this.$emit('newR')
                document.getElementById('close').click()

            }
            return false
        },
        checkInput: function(input) {
            if (input.name == 'observation') {
                if (!this.checkData(this.models.mObservation) || this.models.mObservation === '') this.observationState = true
                else this.observationState = false
            }else if (input.name == 'diagnostic') {
                if (!this.checkData(this.models.mDiagnostic) || this.models.mDiagnostic === '') this.diagnosticState = true
                else this.diagnosticState = false
            }else {
                if (!this.checkData(this.models.mConseil) || this.models.mConseil === '') this.conseilState = true
                else this.conseilState = false
            }
        },
        checkData: function(input) {
            if (input.match(/^[a-zA-Z\D][^#(0-9)]+$/)) return true
            else return false
        },
        removeError: function(e) {
            if (e.target.name == 'observation') this.observationState = false
            else if (e.target.name == 'diagnostic') this.diagnosticState = false
            else this.conseilState = false
        },
        clearAll: function() {
            this.models.mObservation = ''
            this.observationState = false
            this.models.mDiagnostic = ''
            this.diagnosticState = false
            this.models.mConseil = ''
            this.conseilState = false
        },
        onInput: function(e) {
            e.target.style.height = "auto"
            e.target.style.height = (e.target.scrollHeight) + "px"
        }
    },
    mounted() {
        let textareas = document.querySelectorAll('textarea')
        for (const textarea of textareas) {
            textarea.addEventListener("input", this.onInput, false)
        }
    },
};
</script>

<style scoped>
textarea {
    resize: none;
    overflow-y: hidden;
}
</style>
