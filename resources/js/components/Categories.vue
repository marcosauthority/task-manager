<template>
    <Template>
    <div class="container">
        <br />
        <h3>Categories</h3>
        <br />
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.name }}</td>
            <td>
              <button class="btn btn-sm btn-primary" @click="editCategory(category)">Edit</button>
              <button class="btn btn-sm btn-danger" @click="deleteCategory(category.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <h4 v-if="editMode">Edit Category</h4>
      <h4 v-else>Add Category</h4>

      <form @submit.prevent="submitCategory">
        <div class="mb-3">
          <label for="categoryName">Name:</label>
          <input type="text" id="categoryName" v-model="categoryName" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ editMode ? 'Save' : 'Add' }}</button>
        <button class="btn btn-secondary" @click="cancelEdit">Cancel</button>
      </form>
    </div>
</Template>
  </template>

  <script>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
    import Template from './Template.vue';

  export default {
    components: {
      Template,
    },
    data() {
      return {
        categories: [],
        editMode: false,
        categoryId: null,
        categoryName: '',
      };
    },
    methods: {
      fetchCategories() {
        axios.get('/api/categories')
          .then(response => {
            this.categories = response.data.categories;
          })
          .catch(error => {
            console.error(error);
          });
      },
      submitCategory() {
        if (this.editMode) {
          axios.put(`/api/categories/${this.categoryId}`, { name: this.categoryName })
            .then(() => {
              this.cancelEdit();
              this.fetchCategories();
            })
            .catch(error => {
              console.error(error);
            });
        } else {
          axios.post('/api/categories', { name: this.categoryName })
            .then(() => {
              this.categoryName = '';
              this.fetchCategories();
            })
            .catch(error => {
              console.error(error);
            });
        }
      },
      editCategory(category) {
        this.editMode = true;
        this.categoryId = category.id;
        this.categoryName = category.name;
      },
      deleteCategory(categoryId) {
        if (confirm('Are you sure you want to delete this category?')) {
          axios.delete(`/api/categories/${categoryId}`)
            .then(() => {
              this.fetchCategories();
            })
            .catch(error => {
              console.error(error);
            });
        }
      },
      cancelEdit() {
        this.editMode = false;
        this.categoryId = null;
        this.categoryName = '';
      },
    },
    mounted() {
      this.fetchCategories();
    },
  };
  </script>
