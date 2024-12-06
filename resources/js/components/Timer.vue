<template>
    <div>
        <div class="container" style="position: relative;padding-left: -10px;">
            <div class="row timer pr-5">
                <h1 class="fs-sm-1 fs-md-1 fs-lg-1" style="font-weight: bold;">{{ formattedTime }}</h1>
                <div class="" style="position: relative; top: -10px; ">
                  <div class="text-right fs-md-2 fs-lg-3" >Time Left</div> 
                </div>
            </div> 
        </div>
        
      <timesup ref="timesUpModal" :timeLeft="timeLeft"/>
      
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        
        timeLeft: 5,
        intervalId: null,
      };
    },
    props: {
      time: {
        type: Number,
        required: true
      },
    },
    computed: {
      formattedTime() {
        const hours = Math.floor(this.time / 3600);
        const minutes = Math.floor((this.time % 3600) / 60);
        const seconds = this.time % 60;
        return `${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
      },
    },
    methods: {
      startTimer() {
        this.intervalId = setInterval(() => {
          if (this.time > 0) {
            this.time--;
          } else {
            this.showTimesUpModal();
            clearInterval(this.intervalId);
          }
        }, 1000);
      },
      showTimesUpModal() {
        // Call the show method of the TimesUpModal component
        this.$refs.timesUpModal.show();
      },
    },
    mounted() {
      this.startTimer();
    },
    beforeDestroy() {
      clearInterval(this.intervalId);
    },
  };
  </script>
  
  <style scoped>
  .timer {
    text-align: right;
    font-weight: bold;
  }
  
  @media (max-width: 767) {
    .fs-sm-1 {
      font-size: 20px !important; 
    }
  }
  @media (min-width: 768px) { /* Medium devices (tablets, 768px and up) */
    .fs-md-2 {
      font-size: 8px; /* Equivalent to Bootstrap's .fs-2 */
      position: relative;
      left:6px;
      color: #808080;
    };
    .fs-md-1 {
      font-size: 25px !important;
      color: #808080;
    }
  }

  @media (min-width: 992px) { /* Large devices (desktops, 992px and up) */
    .fs-lg-3 {
      font-size: 14px; /* Equivalent to Bootstrap's .fs-3 */
    };
    .fs-lg-1 {
      font-size: 34px !important;
      color: #808080;
    }
  }
</style>