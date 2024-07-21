<template>
  <div class="input-group">
    <textarea rows="1" name="message" class="form-control input-sm edit" @keyup.enter="sendMessage" v-model="newMessage"
      placeholder="Ecrire un message ici...">
    </textarea>
    <span class="input-group-btn"><button class="btn btn-info btn-sm mx-2" @click="sendMessage">Envoyer</button></span>
  </div>
</template>
<script>
export default {
  props: ["user"],
  emits: ['messagesent'],
  data() {
    return {
      newMessage: "",
    }
  },
  methods: {
    sendMessage: function() {
      this.$emit("messagesent", { user: this.user, message: this.newMessage })
      this.newMessage = ""
      const tx = document.getElementsByTagName("textarea")[0]
      tx.setAttribute("style", "height:" + (35) + "px;overflow-y:hidden;")
    },
    onInput: function(e) {
      e.target.style.height = "auto"
      e.target.style.height = (e.target.scrollHeight) + "px"
    }
  },
  mounted() {
    const tx = document.getElementsByTagName("textarea")[0]
    tx.setAttribute("style", "height:" + (tx.scrollHeight) + "px;overflow-y:hidden;")
    tx.addEventListener("input", this.onInput, false)
  },
}
</script>

<style scoped>
  .edit {
    resize: none;
  }
</style>
