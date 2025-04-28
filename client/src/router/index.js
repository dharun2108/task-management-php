import { createRouter, createWebHistory } from "vue-router";
import LoginPage from "../components/LoginPage.vue";
import RegisterPage from "../components/RegisterPage.vue";
import DashboardPage from "../components/DashboardPage.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/login",
      component: LoginPage,
    },

    {
      path: "/register",
      component: RegisterPage,
    },
    {
      path:"/",
      component:DashboardPage,
    },
 
  ],
});

export default router;
