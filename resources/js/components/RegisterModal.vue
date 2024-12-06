<template>
    <div class="modal-overlay" >
      <div class="modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #f5f5f5; border-radius: 20px; width: 35rem;">
          <div class="modal-body content text-dark justify-content-center">
            <div class="text-center">
              <img src="/assets/logo.png" alt="Times Up" style="height: 300px; margin: 0 auto;" />
              <p class="display-4 mt-3" style="font-weight: 900;">New Account</p> 
              <hr class="m3" style="border: 1px solid #ddd;"/>
            </div>
           <!-- Login Form -->
             <form @submit.prevent="handleLogin">
              <div class="form-group">
                <label for="email">Email address</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="email"
                  placeholder="Enter your email"
                  required
                />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  v-model="password"
                  placeholder="Enter your password"
                  required
                />
              </div>
              <button type="submit" class="btn btn-block" style="background-color: #FFCC33;">
                Login
              </button>
              <div class="text-dark text-center mt-3 p-0">
                <a href="">Forgot your password?</a><br>
                <a href="/register">Don't have an account yet? Register here</a>
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
      };
    },
    methods: {
        handleLogin() {
      // Handle the login logic here
      console.log('Email:', this.email);
      console.log('Password:', this.password);
    },
    }
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
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
    top: -8rem;
  }
  
  </style>
  