<template>
  <form class="task-form" @submit.prevent="addTask">
    <input class="title" type="text" placeholder="Title" required v-model="newTask" />
    <input  class="description" placeholder="Description" v-model="newDescription" required />
    <button type="submit">+ Add</button>
  </form>
</template>

<script>
import { addTask } from "@/services/apiService";

export default {
  data() {
    return { 
      newTask: "", 
      newDescription: "",  
      userId: localStorage.getItem("user_id") 
    };
  },
  methods: {
    async addTask() {
      if (!this.newTask.trim() || !this.newDescription.trim()) return;
      try {
        const response = await addTask(this.newTask.trim(), this.newDescription.trim(), this.userId);
   

        this.$emit("taskAdded");
        this.newTask = "";
        this.newDescription = ""; 
      } catch (error) {
        console.log(error.response.data);
      }
    },
  }
};
</script>
