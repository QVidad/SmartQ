<template>
  <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
    <h3 class="card-title" style="font-weight: bold;">Available Exams</h3>
    <div class="px-5 py-3 justify-content-center">
      <!-- card grid -->
      <div class="container-fluid justify-content-center p-0 m-0">
        <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 ">
          <div class="col pb-3">
            <examscard category="Anatomy" title="Cardiovascular System"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Biochemistry" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Internal_Medicine" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Legal" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Microbiology" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Obstetrics" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Pathology" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Pediatrics" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Pharmacology" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Physiology" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Preventive_Medicine" title="General Principles of Pharmacology"></examscard>
          </div>
          <div class="col pb-3">
            <examscard category="Surgery" title="General Principles of Pharmacology"></examscard>
          </div>
        </div>
      </div>
      
      
    </div>
    <!-- <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary px-5" style="background-color: #292B4E;">View All</a>
    </div> -->
  </div>
</template>

<script>
export default {
  name: 'ResponsiveCard',
}
</script>
