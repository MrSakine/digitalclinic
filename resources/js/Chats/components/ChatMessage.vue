<template>
  <ul class="chat">
      <li v-for="(input, i) in messages" :key="i">
        <div class="">
            <div class="shadow-sm p-4 bg-light rounded w-25 mb-3">
                <strong class="fs-5 text-bold font-weight-bold">{{input.user}}</strong>
                <p class="mt-2">{{input.contenu}}</p>
                <span class="float-end font-monospace" style="font-size:14px;">{{input.date}}</span>
            </div>
        </div>
      </li>
  </ul>
</template>

<script>
export default {
  props: {
    messages: Array,
  },
}
</script>

<style scoped>
    ul {
        list-style-type: none;
    }
</style>
