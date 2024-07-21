<template>
    <div class="card-cointainer-parent">
        <div class="card-container">
            <div class="front">
                <div class="image">
                    <img src="/storage/images/chip.png" alt="">
                </div>
                <div class="card-number-box">################</div>
                <div class="flexbox">
                    <div class="box">
                        <span>Titulaire de la carte</span>
                        <div class="card-holder-name">nom complet</div>
                    </div>
                    <div class="box">
                        <span>Expiration</span>
                        <div class="expiration">
                            <span class="exp-month">mois / </span>
                            <span class="exp-year">année</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"></div>
                </div>
            </div>
        </div>
        <form action="">
            <div class="inputBox">
                <span>Numéro de carte</span>
                <input type="tel"
                maxlength="16" class="card-number-input" v-on:input="showTextOnInput"
                name="card-number"
                placeholder="xxxx xxxx xxxx xxxx">
            </div>
            <div class="inputBox">
                <span>Titulaire de la carte</span>
                <input type="text" class="card-holder-input"
                    v-on:input="showTextOnInput" name="card-holder-name" maxlength="15"
                    placeholder="Nom sur la carte">
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span>Mois d'expiration</span>
                    <select class="month-input" name="card-month" @click="showTextOnInput">
                    <option value="mois / " selected disabled>Mois</option>
                    <option value="01">Janvier</option>
                    <option value="02">Février</option>
                    <option value="03">Mars</option>
                    <option value="04">Avril</option>
                    <option value="05">Mai</option>
                    <option value="06">Juin</option>
                    <option value="07">Juillet</option>
                    <option value="08">Août</option>
                    <option value="09">Septembre</option>
                    <option value="10">Octobre</option>
                    <option value="11">Novembre</option>
                    <option value="12">Décembre</option>
                </select>
                </div>
                <div class="inputBox">
                    <span>Année d'expiration</span>
                    <select class="year-input" name="card-year" @click="showTextOnInput">
                    <option value="année" selected disabled>Année</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                </select>
                </div>
                <div class="inputBox">
                    <span>CVV</span>
                    <input type="text" maxlength="4" class="cvv-input" name="card-cvv"
                    @mouseenter="changePerspective(1)" @mouseleave="changePerspective(-1)"
                    @input="showTextOnInput" placeholder="Code de sécurite">
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    methods: {
        showTextOnInput: function(e) {
            if (e.target.name === 'card-number') {
                this.showCardNumber(e)
            }else if (e.target.name === 'card-cvv') {
                this.showCardCvv(e)
            }else if (e.target.name === 'card-month') {
                this.showCardMonth(e)
            }else if (e.target.name === 'card-year') {
                this.showCardYear(e)
            }else{
                this.showCardName(e)
            }
        },
        showCardNumber: function(e) {
            if (e.target.value != '') {
                document.querySelector('.card-number-box').innerText = e.target.value
            }else{
                document.querySelector('.card-number-box').innerText = '################'
            }
        },
        showCardName: function(e) {
            document.querySelector('.card-holder-name').innerText = e.target.value
        },
        showCardCvv: function(e) {
            document.querySelector('.cvv-box').innerText = e.target.value
        },
        showCardMonth: function(e) {
            if (e.target.value != '' && !e.target.disabled) document.querySelector('.exp-month').innerText = e.target.value + ' / '
        },
        showCardYear: function(e) {
            if (e.target.value != '' && !e.target.disabled) document.querySelector('.exp-year').innerText = e.target.value
        },
        changePerspective: function(n) {
            if (n === 1){
                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)'
                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)'
            }else{
                document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)'
                document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)'
            }
        },
    },
}
</script>
