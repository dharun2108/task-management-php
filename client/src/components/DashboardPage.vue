<template>
<header-component />
  <div class="dashboard-container">
    <task-form @taskAdded="fetchTasks" />
    <task-table :tasks="tasks" @taskUpdated="fetchTasks" />
  </div>
</template>

<script>
import HeaderComponent from "./HeaderComponent.vue";
import TaskForm from "./TaskForm.vue";
import TaskTable from "./TaskTable.vue";
import { fetchTasks } from "@/services/apiService";

export default {
  components: { HeaderComponent, TaskForm, TaskTable },
  data() {
    return {
      userId: localStorage.getItem("user_id"),
      tasks: [],
    };
  },
  methods: {
    async fetchTasks() {
  try {
    const response = await fetchTasks(this.userId); // Using the API service function
    this.tasks = response.data.map(task => ({
      ...task,
      editing: false, 
    }));
  } catch (error) {
    console.error("Error fetching tasks:", error.response ? error.response.data : error.message);
  }
}
,
  },
  mounted() {
    this.fetchTasks();
  },
  beforeMount(){
    if(!localStorage.getItem('token')){
this.$router.push('/register');
    }
  }
};
</script>
