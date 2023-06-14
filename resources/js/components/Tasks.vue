<template>
    <Template>
      <div class="container">
        <br />
        <h3 class="mb-4">Tasks Management</h3>
        <br />

        <button class="btn btn-primary" @click="showForm = true" v-if="!showForm">New Task</button>

        <form @submit.prevent="submitTask" v-if="showForm">
          <h4 v-if="editMode">Edit Task</h4>
          <h4 v-else>Add Task</h4>
          <div class="mb-3">
            <label for="taskName">Name:</label>
            <input type="text" id="taskName" v-model="taskName" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="taskDescription">Description:</label>
            <input type="text" id="taskDescription" v-model="taskDescription" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="taskPriority">Priority:</label>
            <select id="taskPriority" v-model="taskPriority" class="form-control" required>
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="taskDueDate">Due Date:</label>
            <input type="date" id="taskDueDate" v-model="taskDueDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="taskCategory">Category:</label>
            <select id="taskCategory" v-model="taskCategory" class="form-control" required>
              <option value="">Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">{{ editMode ? 'Save' : 'Add' }} Task</button>
          <button class="btn btn-secondary" @click="cancelEdit">Cancel</button>
        </form>

        <hr />
        <h4>Tasks List</h4>
        <hr />
        <div class="mb-3">
          <label for="filterPriority">Filter by Priority:</label>
          <select id="filterPriority" v-model="filterPriority" class="form-control">
            <option value="">All</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col" @click="sort('name')" width="20%">Name</th>
              <th scope="col" @click="sort('description')" width="20%">Description</th>
              <th scope="col" @click="sort('priority')">Priority</th>
              <th scope="col" @click="sort('date_due')">Due Date</th>
              <th scope="col" width="5%">Info</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="task in filteredTasks" :key="task.id">
              <td>{{ task.name }}</td>
              <td>{{ task.description }}</td>
              <td>{{ task.priority }}</td>
              <td>{{ task.date_due }}</td>
              <td>
                <span class="badge bg-success" v-if="task.completed">Completed</span>
                <span class="badge bg-danger" v-if="!isDue(task) && !task.completed && isTaskOverdue(task)">Overdue</span>
                <span class="badge bg-warning" v-if="isDue(task)">Due Today</span>
              </td>
              <td>
                <button class="btn btn-sm btn-primary" @click="editTask(task)" v-if="!task.completed" title="Edit"><font-awesome-icon icon="pen" /></button>
                <button class="btn btn-sm btn-danger" @click="deleteTask(task.id)" title="Delete"><font-awesome-icon icon="trash" /></button>
                <button class="btn btn-sm btn-success" @click="markAsCompleted(task.id)" v-if="!task.completed" title="Mask as Complete"><font-awesome-icon icon="check" /></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Template>
  </template>

  <script>
  import axios from 'axios';
  import Template from './Template.vue';
  import { ref, computed, onMounted } from 'vue';

  export default {
    components: {
      Template,
    },
    setup() {
      const tasks = ref([]);
      const sortKey = ref(null);
      const sortOrders = ref({});
      const taskName = ref('');
      const taskDescription = ref('');
      const taskPriority = ref('low');
      const taskDueDate = ref('');
      const taskCategory = ref('');
      const editMode = ref(false);
      const taskId = ref(null);
      const categories = ref([]);
      const showForm = ref(false);
      const filterPriority = ref('');

      const fetchTasks = async () => {
        const response = await axios.get('/api/tasks');
        tasks.value = response.data.tasks;
      };

      const fetchCategories = async () => {
        const response = await axios.get('/api/categories');
        categories.value = response.data.categories;
      };

      const sort = (key) => {
        sortKey.value = key;
        sortOrders.value[key] = sortOrders.value[key] || 1;
        sortOrders.value[key] *= -1;
      };

      const sortedTasks = computed(() => {
        if (!sortKey.value) {
          return tasks.value;
        }
        return [...tasks.value].sort((a, b) => {
          return sortOrders.value[sortKey.value] * (a[sortKey.value] > b[sortKey.value] ? 1 : -1);
        });
      });

      const filteredTasks = computed(() => {
        if (!filterPriority.value) {
          return sortedTasks.value;
        }
        return sortedTasks.value.filter((task) => task.priority === filterPriority.value);
      });

      const submitTask = async () => {
        showForm.value = false;
        if (editMode.value) {
          const updatedTask = {
            name: taskName.value,
            description: taskDescription.value,
            priority: taskPriority.value,
            date_due: taskDueDate.value,
            category_id: taskCategory.value,
          };

          await axios.put(`/api/tasks/${taskId.value}`, updatedTask);
          clearTaskForm();
        } else {
          const newTask = {
            name: taskName.value,
            description: taskDescription.value,
            priority: taskPriority.value,
            date_due: taskDueDate.value,
            category_id: taskCategory.value,
          };

          await axios.post('/api/tasks', newTask);
          clearTaskForm();
        }

        fetchTasks();
      };

      const editTask = (task) => {
        editMode.value = true;
        taskId.value = task.id;
        taskName.value = task.name;
        taskDescription.value = task.description;
        taskPriority.value = task.priority;
        taskDueDate.value = task.date_due;
        taskCategory.value = task.category_id;
        showForm.value = true;
      };

      const cancelEdit = () => {
        editMode.value = false;
        clearTaskForm();
        showForm.value = false;
      };

      const clearTaskForm = () => {
        taskName.value = '';
        taskDescription.value = '';
        taskPriority.value = 'low';
        taskDueDate.value = '';
        taskCategory.value = '';
        taskId.value = null;
      };

      const deleteTask = async (taskId) => {
        if (confirm('Are you sure you want to delete this task?')) {
          await axios.delete(`/api/tasks/${taskId}`);
          fetchTasks();
        }
      };

      const markAsCompleted = async (taskId) => {
        if (confirm('Are you sure you want to mark this task as completed?')) {
          await axios.patch(`/api/tasks/${taskId}/completed`);
          fetchTasks();
        }
      };

      const isTaskOverdue = (task) => {
        const today = new Date();
        const dueDate = new Date(task.date_due);
        return dueDate < today;
      };

      const isDue = (task) => {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        const dueDate = new Date(task.date_due);
        dueDate.setHours(0, 0, 0, 0);
        return dueDate.getTime() === today.getTime();
      };

      onMounted(() => {
        fetchTasks();
        fetchCategories();
      });

      return {
        tasks,
        sortKey,
        sortOrders,
        taskName,
        taskDescription,
        taskPriority,
        taskDueDate,
        taskCategory,
        editMode,
        taskId,
        categories,
        showForm,
        filterPriority,
        sortedTasks,
        filteredTasks,
        submitTask,
        editTask,
        cancelEdit,
        deleteTask,
        markAsCompleted,
        isTaskOverdue,
        isDue,
      };
    },
  };
  </script>
