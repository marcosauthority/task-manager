<template>
    <Template>
      <div class="container">
        <br />
        <h3 class="mb-4">Overview</h3>
        <div class="row">
          <h4>Tasks</h4>
        </div>
        <div class="row">
          <Card title="Total" :number="overviewData.totalTasks" bgColor="bg-info" col="6" />
          <Card title="Completed" :number="overviewData.completedTasks" bgColor="bg-primary" col="3" />
          <Card title="Due Today" :number="overviewData.todayTasks" bgColor="bg-danger" col="3" />
        </div>
        <div class="row">
          <h4>Priority</h4>
        </div>
        <div class="row">
          <Card title="High" :number="overviewData.highPriorityTasks" bgColor="bg-danger" col="2" />
          <Card title="Medium" :number="overviewData.mediumPriorityTasks" bgColor="bg-warning" col="2" />
          <Card title="Low" :number="overviewData.lowPriorityTasks" bgColor="bg-success" col="2" />
        </div>
      </div>
    </Template>
  </template>

  <script>
  import Template from './Template.vue';
  import Card from './Card.vue';
  import axios from 'axios';

  export default {
    components: {
      Template,
      Card,
    },
    data() {
      return {
        overviewData: {
          totalTasks: false,
          completedTasks: false,
          todayTasks: false,
          highPriorityTasks: false,
          mediumPriorityTasks: false,
          lowPriorityTasks: false,
        },
      };
    },
    mounted() {
      this.fetchOverviewData();
    },
    methods: {
      fetchOverviewData() {
        axios.get('api/overview')
          .then(response => {
            this.overviewData = response.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
