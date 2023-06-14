<template>
    <div class="container d-flex justify-content-center align-items-center vh-100">
      <div class="card w-100" style="max-width: 400px;">
        <div class="card-body">
          <h2 class="card-title">Login</h2>

          <div v-if="error" class="alert alert-danger">
            {{ error }}
          </div>

          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" v-model="email" class="form-control">
            </div>

            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" v-model="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  </template>

<script>
import { ref } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default{
  setup() {
    const store = useStore();
    const router = useRouter();
    const email = ref('');
    const password = ref('');
    const error = ref(null);

    const submit = async () => {
        try {
            const response = await axios.post(`/api/login`,{
            email: email.value,
            password: password.value,
            });

            store.commit('setToken', response.data.message.token);

            router.push('/home');

        } catch (axiosError) {
            if (axiosError.response) {
            error.value = axiosError.response.data.message;
            } else {
            error.value = 'An error occurred.';
            }
        }
    };

    return {
      email,
      password,
      error,
      submit,
    };
  },
};
</script>

<style scoped>
.error {
  color: red;
}
</style>
