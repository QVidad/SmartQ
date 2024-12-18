<template>
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid justify-content-center mt-1">
        <ul class="navbar-nav">
          <li class="nav-item">
            <div class="d-flex justify-content-center">
              <a href="/exam" class="nav-link px-4 pb-0 m-0">
                <div class="row justify-content-center pb-0 mb-0">
                  <h2 class="mb-0"><i class="bi bi-file-earmark-text-fill text-white"></i></h2>
                </div>
                <div class="row justify-content-center pt-0 m-0">
                  <h6 class="text-white">Exam</h6>
                </div>
              </a>
              <div class="mt-2" style="border-left: 2px solid #fff;height: 45px; opacity: 0.5"></div><!-- Divider -->
              <a href="/trial" class="nav-link px-5">
                <div class="row justify-content-center pb-0 mb-0">
                  <h2 class="mb-0"><i class="bi bi-file-earmark-bar-graph-fill text-white"></i></h2>
                </div>
                <div class="row justify-content-center pt-0 mt-0">
                  <h6 class="text-white">Trial</h6>
                </div>
              </a>
              <div class="mt-2" style="border-left: 2px solid #fff;height: 45px; opacity: 0.5"></div><!-- Divider -->
              <a href="/results" class="nav-link px-5 m-0">
                <div class="row justify-content-center pb-0 mb-0">
                  <h2 class="mb-0"><i class="bi bi-person-check text-white"></i></h2>
                </div>
                <div class="row justify-content-center pt-0 mt-0">
                  <h6 class="text-white">Results</h6>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item">
          </li>
        </ul>
      </div>
    </nav>
  </template>

  <script>
  export default {
    data() {
      return {
        activeLink: 'exam', // Default active link
      };
    },
    methods: {
      setActive(link) {
        this.activeLink = link;
      },
    },
  };
  </script>
  