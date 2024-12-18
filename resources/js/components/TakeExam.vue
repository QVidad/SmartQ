<template>
  <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
     <!-- Review Answers Button and Modal -->
    <navigationbutton :title="first"/>
    <!-- Are You Sure Modal -->
    <areyousuremodal ref="areyousureModal"/>
    <!-- Greetings Text -->
    <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
      <p class="h1 p-0 m-0 text-white" style="font-style: italic;">{{ first }}</p>
      <p class="display-4 p-0 m-0 text-white" style="font-weight: bold;">{{ second }}</p>
    </div>
    <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    <div class="px-5 py-3 justify-content-center">
      <!-- Top Part Grid-->
      <div class="row ">
        <div class="col-10"><progressbar/></div>
        <div class="col-2"><timer/></div>
      </div>
      <!-- Bottom Part Grid - Exam Content -->
      <examcontent />
    </div>
    <!-- <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary px-5" style="background-color: #292B4E;">View All</a>
    </div> -->
  </div>
  </div>
</template>

<script>
export default {
  name: 'TakeExam',
  props: {
    first: {
      type: String,
      required: true
    },
    second: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      
    };
  },
  
}
</script>

