<template>
    <div class="row">
      <div class="col-10">
          <div class="progress" style="height: 2rem; border-radius: 2rem;">
          <div class="progress-bar progress-bar-striped progress-bar-animated" :style="{ width: progress + '%' }" role="progressbar" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100" style="background-color: #292B4E;">
            {{ progress }}%
          </div>
        </div>
        <!-- testing button fro the progress bar -->
        <!-- <button class="btn btn-primary mt-3" @click="increaseProgress">Increase</button>
        <button class="btn btn-danger mt-3" @click="resetProgress">Reset</button> -->
      </div>
      
      <div class="col-1">
        <p class="display-4 " style="top: -20px; position: relative;">|</p>
      </div>
      <div class="col-1">
        <i class="bi bi-stopwatch-fill display-4"></i>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        
      };
    },
    props: {
      progress: {
      type: Number,
      required: true
    },
    },
    methods: {
      // function for the value of progress
      increaseProgress() {
        if (this.progress < 100) {
          this.progress += 10; 
        }
      },
      resetProgress() {
        this.progress = 0; // Reset progress to 0%
      },
    },
  };
  </script>
  
  <style scoped>
  /* Optional: Additional styling for buttons or progress bar */
  .progress-bar {
    transition: width 0.5s ease;
  }
  </style>
  