<template>
    <Head />
    <div class="home_nav_container">
        <d-nav :gererMessages="true" :nbNotifications="0"></d-nav>
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 mx-2 mt-3 messageTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 bg-body rounded" v-if="noMessage">
                <no-consultation text="Vous n'aviez pas encore eu de messages de consultation" />
            </div>
            <div class="border-top border-secondary border-top-2 m-3 p-3" v-if="hasMessages">
                <new-message v-for="(message, index) in data" :key="message.id" style="overflow-x: hidden;"
                :id="Number(message.id)"
                :index="Number(index)"
                :medecin_from="message.from"
                :date="message.date"
                :typeConsultation="message.type"
                data-aos="slide-left" data-aos-duration="1000" />
            </div>
        </div>
    </div>
    <div id="messageInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Vous devez attendre qu'un medecin vous contacte pour etre en mesure de voir vos différentes boites de dialogues.
            Cliquer sur le bouton "Parler" et le système vous redigera vers le contenu de la boite correspondante.
            Vous pourriez alors envoyer des messages au medecin sur la consultation concernée
        </span>
    </div>
</template>

<script>
import DNav from '../components/DashBoardNavBar.vue'
import newMessage from '../components/newMessage.vue'
import noConsultation from '../components/noConsultation.vue'
import Head from '../components/Head.vue'
import jbox from 'jbox'

export default {
    components: { DNav, newMessage, noConsultation, Head },
    data() {
        return {
            data: [],
            hasMessages: false,
            noMessage: false,
            userEmail: localStorage.getItem('authPatientEmail')
        }
    },
    mounted() {
        new jbox('Tooltip', {
            attach: '.messageTooltip',
            trigger: 'mouseenter',
            content: $('#messageInfo'),
            position: {
                x: 'right',
                y: 'bottom'
            },
            outside: 'x',
            theme: 'TooltipBorder',
            width: 500
        })
        this.checkMessage()
    },
    methods: {
        checkMessage: function() {
            axios.post('/api/getMessages', {
                user: this.userEmail
            })
            .then((rep) => {
                this.data = rep.data.details
                if (this.data.length > 0) {
                    localStorage.setItem("medecin_from", this.data[0].email)
                    this.hasMessages = true
                    this.noMessage = false
                }else{
                    this.hasMessages = false
                    this.noMessage = true
                }
            })
        }
    },
}
</script>
