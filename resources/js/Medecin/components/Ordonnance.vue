<template>
    <div class="modal fade" id="ordonnance" aria-hidden="true" aria-labelledby="consultationLabel"
    tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ordonnance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeOrdonnance"></button>
            </div>
            <div class="modal-body">
                <div class="container border border-2 border-gray w-100 h-50 rounded mt-5 p-2">
                    <h1 class="OrdoTitre">Ordonnance</h1>
                    <table class="table table-bordered table-primary table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Médicaments</th>
                                <th scope="col">Posologies</th>
                                <th scope="col">Quantité</th>
                            </tr>
                        </thead>
                        <tbody id="element_container"></tbody>
                        <button
                            type="button"
                            class="btn btn-outline-success btn-sm mb-3"
                            @click="addMedicament"
                        >
                            Ajouter
                        </button>
                    </table>
                    <button class="btn btn-success" @click="submitHandler" type="submit">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import Ordonnance from "../../objects/Ordonnance.js"
import NavBar from './NavBar.vue'

export default {
    components: {  NavBar },
    emits: ['newOrdo'],
    data: function () {
        return {
            i: 1,
            errors: {
                1: false,
                2: false,
                3: false
            },
            cannotAddNewPage: true
        }
    },
    props: {
        doctorNom: String,
        doctorAdresse: String,
        doctorePhone: Number,
        maladeNom: String,
        maladeprenom: String,
        maladeAge: Date,
        maladeAdresse: String,
        maladePoids: Number,
        maladeSexe: Boolean,
        medicament: String,
        posologie: String,
        DateSignature: Date,
    },
    methods: {
        addMedicament: function (e) {
            e.preventDefault()
            let table = document.getElementById("element_container")
            if (table.childElementCount > 0) {
                this.backupValues()
                if (this.cannotAddNewPage) return false
            }

            let newEl = document.createElement("tr")
            newEl.innerHTML = `
                <td> <input
                            class="form-control w-100"
                            type="text"
                            name="medicament"
                        />
                        <span class="text-danger"></span></td>
                <td> <input
                            class="form-control w-100"
                            type="text"
                            name="posologie"
                        /><span class="text-danger"></span></td>
                <td><input
                            class="form-control w-100"
                            type="number"
                            name="quantite"
                            min="1"
                            max="20"
                        /><span class="text-danger"></span></td>
                <td><button type="button" class="btn btn-danger btn-sm">Supprimer</button></td>
            `;
            table.appendChild(newEl);
            newEl.querySelector("td button").onclick = function (e) {
                table.removeChild(e.target.parentNode.parentNode);
            }
            let inputs = newEl.querySelectorAll('td')
            for(var i=0; i < inputs.length - 1; i++) {
                inputs[i].querySelector('input').addEventListener(
                    'focusin',
                    (e) => {
                        e.target.parentNode.querySelector('span').innerHTML = ''
                    }
                )
            }
        },
         backupValues: function() {
            let table = document.getElementById("element_container"),
            can_pass = []
            for(var i of table.children){
                for(var k=1; k<i.children.length; k++){
                    let child = `td:nth-child(${k}) input`
                    let error = `td:nth-child(${k}) span`
                    if(i.querySelector(child).value == '') {
                        this.errors.k = true
                        this.cannotAddNewPage = true
                        can_pass.push(true)
                        i.querySelector(error).innerHTML = "Verifier la valeur du champ"
                    }else{
                        this.errors.k = false
                        this.cannotAddNewPage = false
                        can_pass.push(false)
                    }

                }
            }

            for (const e of can_pass) {
                if (e) {
                    this.cannotAddNewPage = true
                }
            }
        },
        submitHandler: function(e) {
            e.preventDefault()
            this.backupValues()
            if (this.cannotAddNewPage === false){
                let table = document.getElementById("element_container"), ordonnances = []
                for(var i of table.children) {
                    let tmp = []
                    for(var k=1; k < i.children.length; k++) {
                        let child = `td:nth-child(${k}) input`
                        tmp.push(i.querySelector(child).value)
                    }
                    ordonnances.push(new Ordonnance(tmp[0], tmp[1], tmp[2]))
                    tmp = null
                }
                localStorage.setItem('ordonnances', JSON.stringify({
                    obj: ordonnances
                }))
                this.$emit('newOrdo')
                document.getElementById('closeOrdonnance').click()

            }else{
                return false
            }
        }
    },
};
</script>

<style scoped>
.OrdoTitre {
    text-align: center;
    text-size-adjust: calc();
}
</style>
