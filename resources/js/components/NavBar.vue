<template>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between px-5 py-2" style="width: 100%;">
      <a class="navbar-brand" href="#">
        <img src="https://med.ple-reap.com/assets/img/logo.png" alt="Logo" style="height: 48px; width: auto;">
      </a>
      <a class="alert-link" aria-current="page" href="https://med.ple-reap.com/login" style="color: black;">PLE-REAP: Medicine Website App</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <button @click="logout" class="nav-link">Logout</button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"></a>
          </li>
        </ul>
      </div>
    </nav> -->
    <nav class="navbar navbar-light bg-light justify-content-between">
      <div>
      <a class="navbar-brand" href="#">
        <img src="/assets/logo.png" alt="Logo" style="height: 48px; width: auto;">
      </a>
      <a class="alert-link" aria-current="page" href="/exam" style="color: black;">SmartQ</a>  
      </div>
      <div>
        <button @click="logout" class="btn btn-primary px-3" style="background-color: #292B4E;" @mouseover="hover = true" @mouseleave="hover = false">
            Logout
            <i class="bi bi-box-arrow-right pl-1" v-if="hover"></i>
        </button> 
      </div>
    
  </nav>
</template>
  
<script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        hover: false,
        csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      };
    },
    methods: {
      logout() {
        axios.post('/logout')
        .then(response => {
          window.location.href = '/';
        })
        .catch(error => {
          console.error('Logout error:', error);
        });
      }
    },
  };
</script>
  