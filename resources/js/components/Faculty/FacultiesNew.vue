<template>
  <div>
  <div class="d-flex justify-content-end">
      <div class="d-flex">
          <a href="/create-faculty" class="m-2 p-2 btn btn-primary btn-sm">
              <i class="bi bi-plus-square"></i> Add Teacher
          </a>
      </div>
  </div>
  <div class="d-flex justify-content-center">
      <div class="table-responsive" style="max-width: 80%;">
          <table class="table table-bordered table-striped">
              <thead>
                  <tr>
                      <th>Name</th>
                      <!-- <th>Actions</th> -->
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="faculty in faculties" :key="faculty.id">
                      <td>{{ faculty.name }}</td>
                      <!-- <td>
                          <div class="btn-group">
                              <a href="" class="mx-1 btn btn-primary btn-sm"><i class="bi bi-file-text-fill"></i> Faculty Report </a>
                          </div>
                      </td> -->
                  </tr>
              </tbody>
          </table>
      </div>
  </div>
  </div>
</template>

<script>
  export default {
      name: 'FacultiesNew',
      data() {
          return {
              
          };
      },
      methods: {
          
      },
      components: {
          
      },
      mounted() {
          // console.log(this.students);
      },
      props: {
          faculties: {
              // type: Object,
              required: true 
          }
      },
  }
</script>
