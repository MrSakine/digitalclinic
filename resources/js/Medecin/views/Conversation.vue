<template>
    <Title />
    <div class="container col-12">
        <div class="d-block p-2">
            <patient-info :id="Number(id)" />
            <div class="card">
                <div class="card-header">Messages</div>
                <div class="card-body w-100" style="height: 400px;overflow-y:scroll;">
                    <chat-messages :messages="messages" />
                </div>
                <div class="card-footer">
                    <chat-form @messagesent="addMessage" :user="userEmail" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Title from '../components/Title.vue'
import ChatMessages from '../../Chats/components/ChatMessage.vue'
import ChatForm from '../../Chats/components/ChatForm.vue'
import PatientInfo from '../components/PatientInfo.vue'

export default {
    components: {Title, ChatMessages, ChatForm, PatientInfo},
    data() {
        return {
            messages: [],
            userEmail: localStorage.getItem('authMedecinEmail'),
            id: this.$route.params.id
        }
    },
    methods: {
        addMessage: function(message) {
            axios.post('/api/saveMessage', {
                user: message.user,
                content: message.message,
                id: this.id
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
        Echo.private('patient-chat')
        .listen('MessagePatient', () => {
            this.fetchMessages()
        })
    },
}
</script>
