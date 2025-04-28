<template>
    <table>
   
      <tbody>
        <task-row v-for="task in tasks" :key="task.id" :task="task" @taskUpdated="$emit('taskUpdated')" />
      </tbody>
    </table>
  </template>
  
  <script>
  import TaskRow from "./TaskRow.vue";
  export default {
    components: { TaskRow },
    props: ["tasks"],
  };
  </script>
  
  <style scoped>
  table {
    width: 60%;
    margin-top: 20px;
    border-collapse: collapse;
  }
  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  </style>
  