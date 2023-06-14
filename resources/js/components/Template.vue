<template>
    <div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">

      <div class="container">
        <a class="navbar-brand" href="#">Tasks Manager</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link class="nav-link" to="/home">Overview</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/tasks">Tasks</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/categories">Categories</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/logout">Logout</router-link>
            </li>
          </ul>
        </div>
      </div>
      </nav>

        <slot></slot>

      <footer class="footer">
        <!-- Insira aqui o conteúdo do rodapé -->
      </footer>
    </div>
  </template>

  <script>
  import { mapActions } from 'vuex';

  export default {
    methods: {
      ...mapActions([
        'logout'
      ]),
    },
  };
  </script>
