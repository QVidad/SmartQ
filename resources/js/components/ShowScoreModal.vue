<template>
  <div v-if="isVisible" class="modal-overlay" @click="closeModal()">
    <div class="modal-dialog-centered" role="document">
      <div class="modal-content" style="background-color: #292B4E; border-radius: 20px; width: 35rem;">
        <div class="modal-body text-white justify-content-center text-center">
          <img src="/assets/timesup.png" alt="Times Up" style="height: 300px; margin: 0 auto;" class="py-5"/>
          <h2 style="font-weight: bold;">Congratulations! You passed the exam.</h2> 
          <hr class="m-4" style="border: 1px solid #ddd;"/>
          <h4 class="px-5">You got {{score}} over {{total}}.<br> Keep up the good work! You have {{ trials }} trials left.</h4>
          <div class="d-flex justify-content-center pt-5">
            <a class="btn btn-danger px-3 text-white rounded mr-3" @click="closeModal()">
                <h5><i class="bi bi-arrow-left"></i>  Go to Homepage</h5>
            </a>
            <a class="btn btn-success px-6 text-white rounded" @click="openScoreModal()">
                <h5>View Feedback  <i class="bi bi-arrow-right"></i></h5>
              </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isVisible: true,
      score: 90,
      total: 100,
      trials: 2,
    };
  },
  methods: {
    show() {
      this.isVisible = true;
    },
    closeModal() {
      this.isVisible = false;
    },
    openScoreModal() {
      this.$refs.showscoreModal.show();
    }
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
  background-color: rgba(0, 0, 0, 0.7);
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
  height: auto; 
  z-index: 1051; /* Ensure the modal is above the overlay */
}

</style>
