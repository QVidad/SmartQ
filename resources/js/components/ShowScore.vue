<template>
    <div class="container">
        <div class=" justify-content">
            <p class="text-center font-weight-bold display-4 mb-0 pb-0 mt-2">{{ score }}</p> 
        </div>
        <div>
            <h5 class="text-center">out of {{ total }}</h5>
        </div>
    </div>
</template>
<script>
export default {
  props: {
    score: {
      type: Number,
      required: true
    },
    total: {
      type: Number,
      required: true
    },
  },
}
</script>