<template>
    <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
      <!-- Greetings Text -->
      <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
        <!-- <p class="h1 p-0 m-0 text-white" style="font-style: italic;">{{ title }}</p> -->
        <p class="display-4 p-0 m-0 text-white" style="font-weight: bold;">{{ title }}</p>
      </div>
      <div>
        <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
          <!-- <div class="">
            <h3 class="card-title" style="font-weight: bold;">{{ title }}</h3>
          </div> -->

          <!-- <div class="px-5 py-3 justify-content-center">
            // card grid
            <div class="container-fluid justify-content-center p-0 m-0">
              <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 ">
                <div v-for="index in total" :key="index" class="grid-item">
                  <div class="col pb-3">
                    <examscard category="Anatomy" title="Cardiovascular System"></examscard>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="my-2">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </template>
  
<script>
  export default {
    name: 'ResponsiveCard',
    props: {
      title: {
        type: String,
        required: true
      },
    },
    data() {
      return {
        
      };
    },
    mounted() {

    }
  }
</script>
  
  