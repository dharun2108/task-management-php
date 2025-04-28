<template>
    <header-component />
    <div class="login-container">
      <form @submit.prevent="loginUser" class="form-container" method="post">
        <h1> Login</h1>
  
        <div>
          <input type="email" placeholder="Enter Email" v-model="form.email" @blur="validateEmail" />
          <br />
          <span class="error" v-if="errors.email">{{ errors.email }}</span>
        </div>
  
        <div>
          <input type="password" placeholder="Enter password" v-model="form.password" @blur="validatePassword" />
          <br />
          <span class="error" v-if="errors.password">{{ errors.password }}</span>
        </div>
  
        <button class="login-submit" type="submit" :disabled="isSubmitting">Login</button>
  
        <div class="to-register">
          <p>Don't have an account? <router-link to="/register"> Register </router-link></p>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import HeaderComponent from './HeaderComponent.vue';
import { useToast } from 'vue-toast-notification';
const toast = useToast();
  
  export default {
    components: { HeaderComponent },
    name: 'login-page',
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        errors: {},
        isSubmitting: false,
      };
    },
    methods: {
      validateEmail() {
        if (!this.form.email) {
          this.errors.email = "* Email is required";
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email)) {
          this.errors.email = "* Invalid email format";
        } else {
          this.errors.email = "";
        }
      },
      validatePassword() {
      const passwordRegex = /^(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
      if (!this.form.password) {
        this.errors.password = "* Password is required";
      } else if (!passwordRegex.test(this.form.password)) {
        this.errors.password =
          "* Password must have at least 6 characters, one uppercase letter, and one special character";
      } else {
        this.errors.password = "";
      }
    },

  
      async loginUser() {
        this.validateEmail();
        this.validatePassword();
  
        if (this.errors.email || this.errors.password) return;
  
        this.isSubmitting = true;
  
        try {
          const response = await axios.post("http://127.0.0.1:8000/api/login", this.form);
  
          if (response.data && response.data.token) {
            localStorage.setItem("token", response.data.token);
            localStorage.setItem("user_id", response.data.user.id);
            localStorage.setItem("email", response.data.user.email);
            // console.log("Login successful:", response.data);
            toast.success("Login successful",{position:'top'});
            this.$router.push('/');
          } else {
            console.error("Unexpected API response:", response);
            alert("Unexpected API response. Please try again.");
          }
        } catch (error) {
          if (error.response) {
            console.error("Login failed:", error.response.data);
            alert(error.response.data.message || "Login failed. Check credentials.");
          } else if (error.request) {
            console.error("No response from server:", error.request);
            alert("Server not responding. Try again later.");
          } else {
            console.error("Error:", error.message);
            alert("An error occurred. Please try again.");
          }
        } finally {
          this.isSubmitting = false;
        }
      }
    },
    beforeMount() {
      if (localStorage.getItem('token')) {
        this.$router.push('/');
      }
    }
  };
  </script>
  
  <style scoped>
  .login-container {
    width: 100%;
    height: 80vh;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .form-container {
    width: 400px;
    max-width: 500px;
    max-height: 500px;
    display: flex;
    box-shadow: 1px 2px 3px;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 20px;
    border-radius: 10px;
    padding: 20px;
    background-color: rgba(222, 250, 248, 0.938);
  }
  
  .form-container input {
    padding: 10px;
    width: 300px;
  }
  
  .login-submit {
    padding: 8px 40px;
    font-size: 16px;
    background-color: rgb(33, 124, 241);
    width: 80%;
  }
  
  .login-submit:disabled {
    background-color: grey;
    cursor: not-allowed;
  }
  
  .error {
    color: red;
    font-size: 14px;
  }
  </style>
  