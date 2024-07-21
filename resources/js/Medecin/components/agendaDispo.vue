<template>
    <tr v-for="(d, i) in data" :key="i">
        <th>{{i+1}}</th>
        <th>{{d.jour}}</th>
        <th>
            {{d.disponibilite}}
        </th>
        <th v-if="d.state === false">
            <button class="btn btn-success" @click="showInput($event, false)" data-title="Pour créer une horaire">Créer</button>
        </th>
        <th v-else>
            <button class="btn btn-warning" @click="showInput($event, true)" data-title="Pour modifier une horaire">Modifier</button>
            <button class="btn btn-danger mx-2" @click="deleteAgenda" data-title="Pour supprimer une horaire">Supprimer</button>
        </th>
    </tr>
    <div style="display: none" id="grabMe">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span>Heure de début - Exemple: 8h</span>
            </li>
            <li class="list-group-item">
                <span>Heure de fin - Exemple: 16h</span>
            </li>
        </ul>
    </div>
</template>

<script>
import jBox from 'jbox'

export default {
    props: {
        data: Array
    },
    emits: ['added', 'edited', 'deleted'],
    data() {
        return {
            d: '',
            b: '',
            editHtml: document.createElement('th'),
            actionHtml: document.createElement('th'),
            error: document.createElement('span'),
            editState: false,
        }
    },
    methods: {
        showInput: function(e, state) {
            if (this.editState) {
                alert("Veuillez d'abord annuler l'operation en cours")
                return false
            }
            let parent = e.target.parentNode.parentNode,
            jour = parent.querySelector('th:nth-child(2)')
            this.d = parent.querySelector('th:nth-child(3)')
            this.b = parent.querySelector('th:nth-child(4)')
            if (state === false)
                this.editHtml.innerHTML = `<div class="">
                <input type="text" class="agendaInput" placeholder="début" min="1" maxlength="3"/>
                <span class="mx-2">&#9473;</span>
                <input type="text" class="agendaInput" placeholder="fin" min="1" maxlength="3"/>
                <i class="bi bi-question-octagon mx-2 tooltip-info" style="cursor:pointer;"></i>
                </div>`
            else{
                let dispo = this.d.textContent.split("-")
                this.editHtml.innerHTML = `<div class="">
                <input type="text" class="agendaInput" placeholder="début" min="1" maxlength="3" value="${dispo[0].trim()}"/>
                <span class="mx-2">&#9473;</span>
                <input type="text" class="agendaInput" placeholder="fin" min="1" maxlength="3" value="${dispo[1].trim()}"/>
                <i class="bi bi-question-octagon mx-2 tooltip-info" style="cursor:pointer;"></i>
                </div>`
            }
            this.actionHtml.innerHTML = `
            <div class="">
                <button class="btn btn-secondary">Annuler</button>
                <button class="btn btn-info mx-2">Valider</button>
            </div>`
            parent.insertBefore(this.editHtml, this.d)
            parent.insertBefore(this.actionHtml, this.b)
            parent.removeChild(this.d)
            parent.removeChild(this.b)
            this.editState = true
            new jBox('Tooltip', {
                attach: '.tooltip-info',
                trigger: 'mouseenter',
                title: 'Information',
                position: 'left',
                content: $('#grabMe'),
                theme: 'TooltipBorder'
            })
            let undo = this.actionHtml.querySelector('div button:nth-child(1)'),
            valid = this.actionHtml.querySelector('div button:nth-child(2)'),
            main = this.editHtml.querySelectorAll('.agendaInput'),
            first = main[0],
            second = main[1]
            undo.addEventListener('click', function(e) {
                this.editState = false
                parent.insertBefore(this.d, this.editHtml)
                parent.insertBefore(this.b, this.actionHtml)
                parent.removeChild(this.editHtml)
                parent.removeChild(this.actionHtml)
            }.bind(this))
            valid.addEventListener('click', function(){
                let f = this.onSubmit(first),
                s = this.onSubmit(second)
                first.addEventListener('focusin', function(e) {e.target.classList.remove('error')})
                second.addEventListener('focusin', function(e) {e.target.classList.remove('error')})
                if (f && s) {
                    if (state === false) {
                        axios.post('/api/saveagenda', {
                            jour: jour.textContent,
                            disponibilite: first.value + " - " + second.value
                        })
                        .then(res => {
                            if (res.data.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: res.data.message,
                                    confirmButtonText: 'Ok'
                                })
                                this.$emit('added')
                                this.editState = false
                                parent.insertBefore(this.d, this.editHtml)
                                parent.insertBefore(this.b, this.actionHtml)
                                parent.removeChild(this.editHtml)
                                parent.removeChild(this.actionHtml)
                            }
                        })
                        .catch(err => console.log(err))
                    }else{
                        axios.put(`/api/editagenda/jour/${jour.textContent}`, {
                            jour: jour.textContent,
                            disponibilite: first.value + " - " + second.value
                        })
                        .then(res => {
                            if (res.data.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: res.data.message,
                                    confirmButtonText: 'Ok'
                                })
                                this.$emit('edited')
                                this.editState = false
                                parent.insertBefore(this.d, this.editHtml)
                                parent.insertBefore(this.b, this.actionHtml)
                                parent.removeChild(this.editHtml)
                                parent.removeChild(this.actionHtml)
                            }
                        })
                        .catch(err => console.log(err))
                    }
                }
            }.bind(this))
        },
        onSubmit: function(input) {
            if (this.checkInput(input.value)) {
                input.classList.remove('error')
                return true
            }else{
                input.classList.add('error')
                return false
            }
        },
        checkInput: function(value) {
            return value !== '' && value.length >= 1 && /^[0-9]{1,2}(H|h)$/.test(value)
        },
        checkFirstValue: function(value) {},
        checkSecondValue: function(value) {},
        deleteAgenda: function(e) {
            let parent = e.target.parentNode.parentNode,
            jour = parent.querySelector('th:nth-child(2)')
            axios.delete(`/api/deleteagenda/jour/${jour.textContent}`, {})
            .then(res => {
                if (res.data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès',
                        text: res.data.message,
                        confirmButtonText: 'Ok'
                    })
                    this.$emit('deleted')
                }
            })
            .catch(err => console.log(err))
        }
    },
}
</script>
