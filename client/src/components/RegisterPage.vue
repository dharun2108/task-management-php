<template>
  <header-component />

  <div class="register-container">
    <form @submit.prevent="registerUser" class="reg-form-container" method="post">
      <h1>Register</h1>

      <div>
        <input type="text" placeholder="Enter Your Name" v-model="form.name" @blur="validateName" />
        <br />
        <span class="error" v-if="errors.name">{{ errors.name }}</span>
      </div>

      <div>
        <input type="email" placeholder="Enter Email" v-model="form.email" @blur="validateEmail" />
        <br />
        <span class="error" v-if="errors.email">{{ errors.email }}</span>
      </div>

      <div>
        <input
          type="password"
          placeholder="Enter Password"
          v-model="form.password"
          @blur="validatePassword"
        />
        <br />
        <span class="error" v-if="errors.password">{{ errors.password }}</span>
      </div>

      <div>
        <input
          type="password"
          placeholder="Confirm Password"
          v-model="form.password_confirmation"
          @blur="validatePasswordConfirmation"
        />
        <br />
        <span class="error" v-if="errors.password_confirmation">{{
          errors.password_confirmation
        }}</span>
      </div>

      <button class="register-submit" type="submit" :disabled="isSubmitting">Register</button>

      <div class="toLogin">
        <p>Already have an account? <router-link to="/login">Login </router-link></p>
      </div>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import HeaderComponent from "./HeaderComponent.vue";
import { useToast } from "vue-toast-notification";
 const toast=useToast();

export default {
  components: { HeaderComponent },
  name: "register-page",
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: {},
      isSubmitting: false,
    };
  },
  methods: {
    validateName() {
      if (!this.form.name) {
        this.errors.name = "* Name is required";
      } else if (!/^[A-Za-z\s]+$/.test(this.form.name)) {
        this.errors.name = "* Name must contain only alphabets";
      } else {
        this.errors.name = "";
      }
    },

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

    validatePasswordConfirmation() {
      if (!this.form.password_confirmation) {
        this.errors.password_confirmation = "* Password confirmation is required";
      } else if (this.form.password !== this.form.password_confirmation) {
        this.errors.password_confirmation = "* Passwords do not match";
      } else {
        this.errors.password_confirmation = "";
      }
    },

    async registerUser() {
      this.validateName();
      this.validateEmail();
      this.validatePassword();
      this.validatePasswordConfirmation();

      if (Object.values(this.errors).some((error) => error !== "")) {
        return;
      }

      this.isSubmitting = true;

      try {
        await axios.post(`${import.meta.env.VITE_API_BASE_URL}/register`, this.form);
        toast.success("registration successful",{position:'top'});
        this.$router.push("/login");
      } catch (error) {
        alert("Registration failed! Check console for details.");
        console.log(error.response.data);
      } finally {
        this.isSubmitting = false;
      }
    },
  },
  beforeMount() {
    if (localStorage.getItem("token")) {
      this.$router.push("/");
    }
  },
};
</script>

<style scoped>
.register-container {
  width: 100vw;
  height: 80vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.reg-form-container {
  width: 400px;
  max-height: 500px;
  display: flex;
  justify-content: center;
  box-shadow: 1px 2px 3px;
  align-items: center;
  flex-direction: column;
  gap: 20px;
  border-radius: 10px;
  padding: 20px;
  background-color: rgba(222, 250, 248, 0.938);

}

.reg-form-container input {
  padding: 10px;
  width: 300px;
}

.register-submit {
  padding: 8px 40px;
  font-size: 16px;
  background-color: rgb(33, 124, 241);
  width: 81%;
}

.register-submit:disabled {
  background-color: grey;
  cursor: not-allowed;
}

.error {
  color: red;
  font-size: 14px;
}
</style>
