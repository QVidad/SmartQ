<template>
    <div class="modal-overlay" >
      <div class="modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #f5f5f5; border-radius: 20px; width: 35rem;">
          <div class="modal-body content text-dark justify-content-center">
            <div class="text-center">
              <img src="/assets/max.png" alt="Max Attempt" style="width: 400px; margin: 0 auto;" />
              <p class="display-4 mt-3" style="font-weight: 900;">You've Run Out of Attempt!</p> 
              <hr class="m3" style="border: 1px solid #ddd;"/>
            </div>
           <!-- Login Form -->
             <form @submit.prevent="handleLogin">
              <div v-if="errors" class="alert alert-danger" role="alert">
                Login failed
              </div>
              <h4 class="px-5 text-center">You've reached the maximum number of attempts. This exam is no longer available for you to take.</h4>
              <br>
              <button href="/exam" class="btn btn-block" style="background-color: #FFCC33;">
                Go back to Exam Page
              </button>
              <div class="text-dark text-center mt-3 p-0">
                <!-- <a href="">Forgot your password?</a><br>
                <a href="/reg">Don't have an account yet? Register here</a> -->
              </div>
            </form>   
          </div>
          
        </div>
      </div>
    </div>
  </template>
  
  <script>
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        errors: null
      };
    },
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 5vh;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050; /* Ensure this is above other content */
  }
  
  .modal-content {
    background-color: #292B4E;
    color: white;
    border-radius: 8px;
    padding: 20px;
    max-width: 500px;
    width: 100%;
    height: 40rem; 
    z-index: 1051; /* Ensure the modal is above the overlay */
  }

  .content {
    position: relative;
    top: -0;
  }
  
  </style>
  