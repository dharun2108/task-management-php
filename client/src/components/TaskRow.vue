<template>
  <tr>
    <td>
      <input type="checkbox" :checked="task.completed" @change="toggleTask(task)" />
    </td>
    <td>
      <input v-if="task.editing" type="text" v-model="task.title" @keyup.enter="updateTask(task)" />
      <span v-else :class="{ completed: task.completed }"> {{ task.title }} </span>
    </td>
    <td>
      <textarea v-if="task.editing" v-model="task.description" @keyup.enter="updateTask(task)"></textarea>
      <span :class="{ completed: task.completed }" v-else> {{ task.description }} </span>
    </td>
    <td  :class="{ 'completed-text':task.completed}" >{{ task.completed ? "Completed" : "Pending..." }}</td>
    <td>
      <button class="edit-btn" @click="editTask(task)">{{ task.editing ? "Save" : "Edit" }}</button>
      <button class="delete-btn" @click="deleteTask(task.id)">Delete</button>
    </td>
  </tr>
</template>

<script>
import { toggleTask, updateTask, deleteTask } from "@/services/apiService";
import { useToast } from "vue-toast-notification";
const toast=useToast();
export default {
  props: ["task"],
  methods: {
    async toggleTask(task) {
      try {
        await toggleTask(task.id);
        task.completed = !task.completed;
        this.$emit("taskUpdated");
      } catch (error) {
        console.error("Failed to toggle task:", error);
      }
    },

    async updateTask(task) {
      if (task.title=='' || task.description=='') {
        task.editing = false;
      };
      try {
        await updateTask(task.id, task.title.trim(), task.description.trim());
        task.editing = false;
        this.$emit("taskUpdated");
        toast.success("task updated !!",{position:'top'})
      } catch (error) {
        console.error("Failed to update task:", error);
      }
    },

    editTask(task) {
      if (task.editing) {
        this.updateTask(task);
      }
      task.editing = !task.editing;
    },

    async deleteTask(id) {
      try {
        await deleteTask(id);
        this.$emit("taskUpdated");
        toast.error("task deleted !!",{position:'top'});
      } catch (error) {
        console.error("Failed to delete task:", error);
      }
    },
  },
};
</script>

<style scoped>
.completed {
  text-decoration: line-through;
  color: rgb(190, 28, 7);
}
.completed-text{
  color:rgb(4, 160, 63);
}
</style>
