<template>
<div>
  <!-- Unanswered Content -->
  <div v-if="!isFinish">
      <div class="row">
        <h2 style="font-weight: bold; padding-bottom: 10px;">Topic 1: Pharmacokinetics</h2>
      </div>
      <div class="row">
        <div class="col-1 text-center">
          <h1 style="font-weight: bold;">{{ number }}</h1>
          <p class="" style="font-size: 15px;">out of {{  total }}</p>
        </div>
        <div class="col">
          <h4 class="text-justify">An 8-year-old boy was admitted to the hospital due to cough, colds, sore throat and earache. On physical examination, the attending physician observed that there was diffuse redness and swelling of the pharynx, especially of the palatine tonsils. His left tympanic membrane was also bulging. Which of the following explains the anatomic basis of the boy’s earache?</h4>
        </div>
      </div>
      <div class="row">
          <div class="col">
            <hr class="my-4" style="margin: 0; border: 1px solid #000000;"/>
          </div>
      </div>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-11">
          <!-- the radio buttons -->
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="option1" value="option1">
            <label class="form-check-label" for="option1">
              <h4>A. Infection from the upper respiratory airway has spread to the middle ear via the Eustachian tube.</h4>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="option2" value="option2">
            <label class="form-check-label" for="option2">
              <h4>B. Due to excessive coughing, trauma has been dealt to the area of the eardrum because of increased intracranial pressure.</h4>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="option3" value="option3">
            <label class="form-check-label" for="option3">
              <h4>C. The relationship between the boy’s respiratory infection and earache cannot be explained anatomically.</h4>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="option4" value="option4">
            <label class="form-check-label" for="option4">
              <h4>D. Excessive manipulation of the ear canal leads to ear pain, as what can be observed in a child who is irritated       
by cough and colds.</h4>
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="question1" id="option5" value="option5">
            <label class="form-check-label" for="option5">
              <h4>E. None of the Above</h4>
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="d-flex justify-content-between pt-3">
            <div></div>
            <div>
              <a v-if="number > 1" href="" class="btn px-3 text-white" style="background-color: #292B4E;">
                <i class="bi bi-arrow-left"></i>
                Previous
              </a>
              <a v-if="number === 1" class="btn px-3 text-white" style="background-color: #808080;">
                <i class="bi bi-arrow-left"></i>
                Previous
              </a>
              <a class="btn px-6 text-white" style="background-color: #292B4E;">
                Next
                <i class="bi bi-arrow-right"></i>
              </a>              
            </div>

            <a class="btn btn-success px-3" @click="finishExam()">
              Finish Exam
              <i class="bi bi-check-lg"></i>
            </a> 
          </div>      
        </div>
    </div>
</div>
<!-- Finish Exam -->
 <div v-else-if="isFinish">
    <!-- the summary -->
     <!-- repeat this div for every question/answer. Use for loop like the review exam -->
    <div>
    <div class="row">
      <div class="col-1">
        <h1 style="font-weight: bold; text-align: center;">{{ number }}</h1>
      </div>
      <div class="col">
        <div class="row"><h5>An 8-year-old boy was admitted to the hospital due to cough, colds, sore throat and earache. On physical examination, the attending physician observed that there was diffuse redness and swelling of the pharynx, especially of the palatine tonsils. His left tympanic membrane was also bulging. Which of the following explains the anatomic basis of the boy’s earache?</h5></div>
        <div class="row"><h5 style="font-weight: bold;">Answer: A. Infection from the upper respiratory airway has spread to the middle ear via the Eustachian tube.</h5></div>
      </div>
    </div>
    <hr class="m-4" style="border: 1px solid #ddd;"/>
    </div>
    <!-- the buttons -->
    <div class="row">
        <div class="col">
          <div class="d-flex justify-content-between pt-3">
            <div></div>
            <div>
              <a class="btn px-3 text-white" style="background-color: #292B4E;" @click="goBackExam()">
                <i class="bi bi-arrow-left"></i>
                Previous
              </a>
              <a class="btn btn-success px-3" @click="openSureModal()">
                Submit
                <i class="bi bi-check-lg"></i>
              </a>
              <areyousuremodal ref="areyousureModal"/>           
            </div>
            <div></div>
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
      number: 1,
      total: 100,
      isFinish: false,
    };
  },
  methods: {
    openSureModal() {
        this.$refs.areyousureModal.show();
    },
    finishExam() {
        this.isFinish = true;
    },
    goBackExam () {
        this.isFinish = false;
    }
  },
}
</script>