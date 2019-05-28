<template>
  <div>
    <button class="btn btn-dark" v-if="noclick==false" @click="setNoClick">Back</button>

    <div class="btn-group center col-md-6" v-if="noclick==true">
      <button @click="switchReg" type="button" class="btn btn-primary btn-lg">Register</button>
      <button @click="switchSign" type="button" class="btn btn-secondary btn-lg">Sign in</button>
    </div>

    <div class="container" v-if="sign==true">
      <form>
        <div class="form-group">
          <label>Email address</label>
          <input type="email" class="form-control" placeholder="Enter email" v-model="email">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="password">
        </div>
        <button type="button" @click="signin" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <div class="container" v-if="reg==true">
      <form>
        <div class="form-group">
          <label>Email address</label>
          <input type="email" class="form-control" placeholder="Enter email" v-model="email">
        </div>
        <div class="form-group">
          <label>Username</label>
          <input type="text" class="form-control" placeholder="Enter email" v-model="username">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="password">
        </div>
        <div class="form-group">
          <label>Repeat Password</label>
          <input type="password" class="form-control" placeholder="Password" v-model="c_password">
        </div>
        <button @click="register" type="button" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <div class="container" v-if="errors.length > 0">
      <ul>
        <li v-for="error in errors">
          {{ error }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  beforeMount(){
   this.errors = [];
  },
  data() {
    return {
      reg: false,
      sign: false,
      errors: [],
      c_password: "",
      password: "",
      email: "",
      username: ""
    };
  },
  computed: {
    noclick: function() {
      return this.reg == false && this.sign == false;
    }
  },
  methods: {
    register: function() {
      fetch("/api/register", {
        method: "post",
        body: JSON.stringify({
          name: this.username,
          email: this.email,
          password: this.password,
          c_password: this.c_password
        }),
        headers: {
          "Content-Type": "application/json"
        }
      })
        .then(r => r.json())
        .then(r => {
          console.log(r)
          this.switchSign()
        })
        .catch(e => {
          console.log(e);
        });
    },
    signin: function() {
      fetch("/api/login", {
        method: "post",
        body: JSON.stringify({
          email: this.email,
          password: this.password
        }),
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json"
        }
      })
        .then(r => r.json())
        .then(r => {
          Cookies.set('authToken', r.token)
          window.location.reload()
          console.log(r);
        })
        .catch(e => {
          console.log(e);
          this.errors.push(e)
        });
    },
    switchSign: function() {
      this.reg = false;
      this.sign = true;
    },
    switchReg: function() {
      this.sign = false;
      this.reg = true;
    },
    setNoClick: function() {
      this.sign = false;
      this.reg = false;
    }
  }
};
</script>

<style>
</style>
