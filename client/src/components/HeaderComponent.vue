<template>
  <div class="header-component">
    <div class="logo-container">
      <img class="logo" src="../assets/logo.svg" />
      <h1>To-Do List</h1>
    </div>

    <div v-if="isLoggedIn" class="logout-container">
      <h2 class="initial">{{ getInitial }}</h2>
      <button @click="handleLogout">Logout</button>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    isLoggedIn() {
      return localStorage.getItem("token"); 
    },
    getInitial() {
      const email = localStorage.getItem("email");
      return email ? email.charAt(0).toUpperCase() : "?";
    },
  },
  methods: {
    handleLogout() {
      localStorage.removeItem("token");
      localStorage.removeItem("email");
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped>
.header-component {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background: #666565;
  color: white;
}

.logo-container {
  display: flex;
  align-items: center;
}

.logo {
  width: 50px;
  height: 50px;
  margin-right: 10px;
}

.logout-container {
  display: flex;
  align-items: center;
}
.logout-container button{
    background-color: white;
    color: black;
}

.initial {
  margin-right: 10px;
  background: white;
  color: black;
  padding: 5px 10px;
  border-radius: 50%;
}
</style>
