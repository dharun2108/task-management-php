
<template>



<router-view />

</template>

<script >
import LoginPage from './components/LoginPage.vue';
import RegisterPage from './components/RegisterPage.vue';
import DashboardPage from './components/DashboardPage.vue';
import HeaderComponent from './components/HeaderComponent.vue';
export default {
  name:'App',
  components:{
    LoginPage,
    RegisterPage,
    DashboardPage,
    HeaderComponent
    
  }
}


</script>

<style scoped>

</style>
