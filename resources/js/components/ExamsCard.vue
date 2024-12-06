<template>
  <div class="card shadow-sm" style="width: 18rem;">
    <img class="card-img-top p-2" :src="imageSrc" :alt="category + ' Image'">
    <div class="card-body">
      <h4 class="card-title" style="font-weight: bold">{{ category }} Exam</h4>
      <div class="d-flex justify-content-end pt-3">
        <a :href="examlink" class="btn btn-primary px-3" style="background-color: #292B4E;">
          Begin Exam
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ExamsCard',
  props: {
    category: {
      type: String,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    examlink: {
      type: String,
      required: true
    },
  },
  computed: {
    imageSrc() {
      const imageMap = {
        Biochemistry: '/assets/biochemistry.jpg',
        Pharmacology: '/assets/pharmacology.png',
        Anatomy: '/assets/anatomy.jpg',
        Internal_Medicine: '/assets/internal.png',
        Legal: '/assets/legal.png',
        Microbiology: '/assets/microbiology.png',
        Obstetrics: '/assets/obstetrics.png',
        Pathology: '/assets/pathology.png',
        Pediatrics: '/assets/pediatrics.png',
        Physiology: '/assets/physiology.png',
        Preventive_Medicine: '/assets/preventive.png',
        Surgery: '/assets/surgery.png',
        Actual: '/assets/exam.jpg',
      };

      return imageMap[this.category] || '/assets/default.jpg';
    }
  }
}
</script>
