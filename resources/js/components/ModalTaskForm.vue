<template>
    <div class="modal" :class="{ 'show': showModal }" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Task</h5>
            <button type="button" class="btn-close" @click="closeModal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submit">
              <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" v-model="task.name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type="text" id="description" v-model="task.description" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Priority:</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="low" value="low" v-model="task.priority">
                  <label class="form-check-label" for="low">Low</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="medium" value="medium" v-model="task.priority">
                  <label class="form-check-label" for="medium">Medium</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="high" value="high" v-model="task.priority">
                  <label class="form-check-label" for="high">High</label>
                </div>
              </div>
              <div class="mb-3">
                <label for="due-date" class="form-label">Due Date:</label>
                <input type="date" id="due-date" v-model="task.date_due" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';
  import { ref } from 'vue';

  export default {
    props: {
      showModal: {
        type: Boolean,
        required: true,
      },
    },
    emits: ['closeModal'],
    data() {
      return {
        task: {
          name: '',
          description: '',
          priority: '',
          date_due: '',
        },
      };
    },
    methods: {
      submit() {
        axios
          .post('/api/tasks', this.task)
          .then(() => {
            this.task.name = '';
            this.task.description = '';
            this.task.priority = '';
            this.task.date_due = '';
            this.$emit('closeModal');
          })
          .catch((error) => {
            console.error(error);
          });
      },
      closeModal() {
        this.$emit('closeModal');
      },
    },
  };
  </script>
