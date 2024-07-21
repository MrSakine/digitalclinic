<template>
    <Head />
    <div class="home_nav_container">
        <NavBar :MessageActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 messageTooltip" type="button">Aide ?</button>
            <div class="shadow-sm p-3 mb-2 bg-body rounded mt-3" v-if="noMessage">
                <no-consultation text="Vous n'aviez pas encore créé de messages de consultation" />
            </div>
            <div class="m-3 p-3" v-if="hasMessages">
                <new-message v-for="(message, index) in data" :key="message.id"
                :id="Number(message.id)"
                :index="Number(index)"
                :medecin_from="message.from"
                :patient_to="message.to"
                :date="message.date"
                :typeConsultation="message.type"
                @dBoite="checkMessage" />
            </div>
        </div>
    </div>
        <div id="messageInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Le système vous montrera la liste des boites de dialogues que vous avez créé.
            Vous pourriez alors cliquer sur le bouton "Parler" pour continuer la discussion avec le patient concerné.
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import noConsultation from '../../Patient/components/noConsultation.vue'
import newMessage from '../components/newMessage.vue'
import Head from '../components/Head.vue'
import jbox from 'jbox'

export default {
    components: {NavBar, noConsultation, newMessage, Head},
    data() {
        return {
            noMessage: false,
            hasMessages: false,
            data: [],
            userEmail: localStorage.getItem('authMedecinEmail'),
        }
    },
    methods: {
        checkMessage: function() {
            axios.post('/api/getMessages', {
                user: this.userEmail
            })
            .then((rep) => {
                this.data = rep.data.details
                if (this.data.length > 0) {
                    this.hasMessages = true
                    this.noMessage = false
                }else{
                    this.hasMessages = false
                    this.noMessage = true
                }
            })
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
}
</script>
