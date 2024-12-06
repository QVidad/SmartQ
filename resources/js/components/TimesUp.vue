<template>
  <div v-if="isVisible" class="modal-overlay">
    <div class="modal-dialog-centered" role="document">
      <div class="modal-content" style="background-color: #292B4E; border-radius: 20px; width: 35rem;">
        <div class="modal-body text-white justify-content-center text-center">
          <img src="/assets/timesup.png" alt="Times Up" style="height: 300px; margin: 0 auto;" class="py-5"/>
          <h2 style="font-weight: bold;">Time has run out!</h2> 
          <hr class="m-4" style="border: 1px solid #ddd;"/>
          <h4 class="px-5">You will be redirected to the Exam Page shortly, in {{ timeLeft }} seconds.</h4>
          <button type="button" class="btn btn-success m-4 pt-2 px-4" style="border-radius: 10px;" @click="redirectToHome">
            <h4>Go to Exam Page</h4>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    timeLeft: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      isVisible: false
    };
  },
  mounted() {
    this.startCountdown();
  },
  methods: {
    show() {
      this.isVisible = true;
    },
    redirectToHome() {
      window.location.href = '/exam'; // Redirect to the home page
    },
    startCountdown() {
      const timer = setInterval(() => {
        if (this.timeLeft > 0) {
          this.timeLeft--;
        } else {
          clearInterval(timer);
          this.redirectToHome();
        }
      }, 1000);
    }
  }
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 1050;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
