<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <button @click="logout" class="btn btn-danger">Logout</button>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Chat</div>

          <div class="card">
            <div class="card-body">
              <div v-for="message in messages" :key="message.id">
                <h5
                  class="card-title"
                >{{ message.author.name }} ({{ message.author.email }}) | {{ message.created_at }}</h5>
                <p class="card-text">{{ message.content }}</p>
                <hr>
              </div>
            </div>
          </div>

          <div class="card-body">
            <form>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Your message:</label>
                <textarea class="form-control" rows="3" v-model="newMessage"></textarea>
              </div>
              <button
                @click="sendMessage"
                type="button"
                class="btn btn-dark"
                :disabled="newMessage.length==0"
              >Send</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newMessage: "",
      messages: []
    };
  },
  beforeMount() {
    this.loadMessages();
  },
  mounted(){
    window.Echo.private('chat').listen('MessageSent', ({message})=>{
        this.loadMessages();
    })
  },
  methods: {
    loadMessages: function() {
      fetch("/api/load", {
        method: "post",
        headers: {
          Accept: "application/json",
          Authorization: "Bearer " + Cookies.get("authToken")
        }
      })
        .then(r => r.json())
        .then(r => {
          this.messages = r;
          console.log(r);
        })
        .catch(e => {
          console.log(e);
        });
    },
    logout: function() {
      fetch("/api/logout", {
        method: "post",
        headers: {
          Accept: "application/json",
          "Content-type": "application/json",
          Authorization: "Bearer " + Cookies.get("authToken")
        }
      })
        .then(r => r.json())
        .then(r => {
          Cookies.remove("authToken");
          window.location.reload();
          console.log(r);
        })
        .catch(e => {
          console.log(e);
        });
    },
    sendMessage: function() {
      fetch("/api/send", {
        method: "post",
        body: JSON.stringify({
          message: this.newMessage
        }),
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          Authorization: "Bearer " + Cookies.get("authToken")
        }
      })
        .then(r => r.json())
        .then(r => {
          this.messages = r;
          console.log(r);
        })
        .catch(e => {
          console.log(e);
        });
    }
  }
};
</script>
