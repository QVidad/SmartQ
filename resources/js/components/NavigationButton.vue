<template>
    <div>
    <button class="btn shadow-sm floating-button" @click="openModal">
        <h1><i class="bi bi-database-check"></i></h1>
    </button> 
    <!-- Navigation Modal -->
    <navigationmodal ref="navigationModal" :title="title"/>
    </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    }
},
methods: {
    openModal() {
       // Call the show method of the NavigationModal component
       this.$refs.navigationModal.show();
    }
  },
}
</script>
<style scoped>
.floating-button {
  position: fixed;
  top: 13rem;
  right:  0px;
  height: 3rem;
  z-index: 1000;
  background-color: #FFCC33; 
  color: #292B4E; 
  border-top-left-radius: 1rem; 
  border-bottom-left-radius: 1rem;
}

.floating-button:hover {
  background-color: #E6B800; 
}
</style>