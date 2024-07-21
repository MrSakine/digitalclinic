<template>
    <Title />
    <div class="container col-12">
        <div class="d-block p-2">
            <medecin-info :id="Number(id)" />
            <div class="card">
                <div class="card-header">Messages</div>
                <div class="card-body w-100" style="height: 400px;overflow-y:scroll;">
                    <chat-message :messages="messages" />
                </div>
                <div class="card-footer">
                    <chat-form @messagesent="addMessage" :user="userEmail" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ChatMessage from '../../Chats/components/ChatMessage.vue'
import ChatForm from '../../Chats/components/ChatForm.vue'
import Title from '../../Medecin/components/Title.vue'
import MedecinInfo from '../components/MedecinInfo.vue'

export default {
    components: {ChatMessage, ChatForm, Title, MedecinInfo},
    data() {
        return {
            userEmail: localStorage.getItem('authPatientEmail'),
            id: this.$route.params.id,
            messages: []
        }
    },
    methods: {
        addMessage: function(message) {
            axios.post('/api/saveMessage', {
                user: message.user,
                content: message.message,
                id: this.id,
                medecin_from: localStorage.getItem('medecin_from')
            })
            .then((rep) => {
                if (rep.data.status === true && rep.data.message_sent == 1) {
                    this.fetchMessages()
                }
            })
            .catch(err => console.log(err.response.data))
        },
        fetchMessages: function() {
            axios.post('/api/fetchMessages', {
                user: this.userEmail,
                id: this.id
            })
            .then((rep) => {
                this.messages = rep.data.details
            })
            .catch(err => console.log(err.response.data))
        }
    },
    mounted() {
        this.fetchMessages()
        Echo.private('medecin-chat')
        .listen('MessageMedecin', () => {
            this.fetchMessages()
        })
    },
}
</script>
