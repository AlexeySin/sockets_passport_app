<template>
  <div>
    <chat-component v-if="chat"></chat-component>
    <guest-component v-if="guest"></guest-component>
  </div>
</template>

<script>
export default {
  mounted() {
      if(!Cookies.get('authToken')) {
          this.chat = false
          this.guest = true
      } else {
          this.guest = false
          this.chat = true
      }
  },
  data() {
    return {
      chat: false,
      guest: false
    };
  }
};
</script>

<style>
</style>
