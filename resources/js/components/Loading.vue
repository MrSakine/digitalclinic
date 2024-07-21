<template>
  <div class="loading">
    <span class="mb-3"></span>
    <p class="d-block text-light text-center fs-5">{{text}}</p>
  </div>
</template>


<script>
export default {
  name: "loading",
  props: {
    text: String
  }
}
</script>


<style lang="scss" scoped>
   .loading {
    top: 0;
    left: 0;
    z-index: 10000000 !important;
    width: 100%;
    height: 100%;
    background: rgba(71, 70, 70, 0.5);
    position: fixed;
    display: block;
    justify-content: center;
    align-items: center;

    @keyframes spin {
      to {
        transform: rotateZ(360deg);
      }
    }

    span{
      display: block;
      margin: 0 auto;
      margin-top: 40vh;
      width: 70px;
      height: 70px;
      border: 3px solid transparent;
      border-top-color: #fff;
      border-bottom-color: #fff;
      border-radius: 50%;
      animation: spin ease 1000ms infinite;
    }
  }
</style>