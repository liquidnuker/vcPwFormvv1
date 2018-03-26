<template>
<div id="vee-form">
  <!-- name target -->
  <p>Register</p>
  <form class="form1" 
  id="form" name="form" @submit="validate($event, 'register')" method="POST">
    <!-- username -->
    <label for="username">username: required|alpha|max:6</label>
    <small v-show="errors.has('username')" role="alert">{{ errors.first('username') }}</small>
    <input id="username" v-validate="'required|alpha|max:12'" type="text" name="username" v-model="name">

    <!-- password -->
    <label for="password">Password</label>
    <small v-show="fields.failed('password')" role="alert">{{ errors.first('password') }}</small>
    <input id="password" v-validate="'required|confirmed:password_confirm'" name="password" type="password" v-model="password">
    
    <!-- passwordconfirm -->
    <label for="password_confirm">Confirm Password</label>
    <input id="password_confirm" name="password_confirm" type="password" v-model="passwordconfirm">

    <button type="submit">Submit</button>    
  </form>
  <br />
  <br />
  <!-- login -->
  <p>Login</p>
  <form class="form2" @submit="validate($event, 'login')">
  <!-- username -->
    <label for="l_username">username: required|alpha|max:6</label>
    <small v-show="errors.has('l_username')" role="alert">{{ errors.first('l_username') }}</small>
    <input id="l_username" v-validate="'required|alpha|max:12'" type="text" name="l_username" v-model="l_name">

    <!-- password -->
    <label for="l_password">Password</label>
    <small v-show="fields.failed('l_password')" role="alert">{{ errors.first('l_password') }}</small>
    <input id="l_password" v-validate="'required'" name="l_password" type="password" v-model="l_password">

    <button type="submit">Submit</button>
  </form>
</div>
</template>
<script>
import axios from "axios";
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);

import { Validator } from 'vee-validate';
const validator = new Validator();

export default {
  data() {
      return {
        name: "",
        password: "",
        passwordconfirm: "",

        l_name: "",
        l_password: "",

      };
    },
    mounted: function () {
    },
    methods: {
      handleFileUpload: function (e) {
        this.file = e.target.files[0];
        // this.file = this.$refs.file.files[0];
      },
      register: function () {
        let regData = new FormData();
        regData.append("f_name", this.name);
        regData.append("f_password", this.password);
        regData.append("f_passwordconfirm", this.passwordconfirm);
       
        // let self = this;
        axios.post("./src/php/validate_register.php", regData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        }).then(function (response) {
          console.log(response.data);
        }).catch(function () {
          console.log("error");
        });
      },
      login: function() {
        let loginData = new FormData();
        loginData.append("l_name", this.l_name);
        loginData.append("l_password", this.l_password);
        console.log(loginData);

        // let self = this;
        axios.post("./src/php/validate_login.php", loginData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        }).then(function (response) {
          // console.log(response.data);
          console.log(response.data.loggedin + " user: " +
          response.data.loggedinuser);
        }).catch(function () {
          console.log("error");
        });
      },
      validate: function (e, mode) {
        e.preventDefault(); 

        if (mode === "register") {
          this.register();
        } else {
          this.login();
        }

        // this.$validator.validateAll().then(() => {
        //   // ok
        //   console.log("valid");
        //   // this.register();
        // }).catch(() => {
        //   console.log("invalid");
        //   // return false;   
        // });
               
      }
    }
}; 
</script>