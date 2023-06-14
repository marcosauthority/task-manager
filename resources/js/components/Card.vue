<template>
    <div :class="'col-md-' + col">
      <div class="card text-white mb-3" :class="bgColor">
        <div class="card-body">
          <h4 class="card-title">{{ title }}</h4>
          <div class="spinner-border" role="status" v-if="number === false">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="card-text display-4" v-if="number !== false">{{ number }}</p>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: ['title', 'number', 'bgColor', 'col'],
  };
  </script>
