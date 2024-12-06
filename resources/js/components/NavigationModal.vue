<template>
  <div v-if="isVisible" class="modal-overlay" @click="closeModal()">
    <div class="modal-content float-right">
      <div class="modal-header">
        <div class="modal-title">
          <button class="close text-white" @click="closeModal()">
            <i class="bi bi-x-lg xbutton"></i>
          </button>
          <h5 style="font-style: italic;">{{ title }}</h5>
          <h2 style="font-weight: bold; position: relative; top: -5px">Review Answers</h2>
        </div>
      </div>
      <div class="modal-body scrollable-content">
        <div class="grid-container">
          <div v-for="index in total" :key="index" class="grid-item">
            {{ index }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
  },
  data() {
    return {
      isVisible: false,
      total: 100,
    };
  },
  methods: {
    show() {
      this.isVisible = true;
    },
    closeModal() {
      this.isVisible = false;
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
  height: 100%; 
  z-index: 1051; /* Ensure the modal is above the overlay */
}

.float-right {
  position: fixed;
  top: 0px;
  right:  0px;
}

.close {
  left: -10px;
  cursor: pointer;
}

.xbutton {
  background-color: #ffcc33; 
  padding: 10px;
  height: 10px; 
  width: 10px;
  color: black;
  position: relative;
  left: -17rem;
  border-radius: 10px;
  margin-right: 10px;
}

.scrollable-content {
  top: 15px;
  max-height: 87%;
  overflow-y: auto;
}

/* Customized Scroll Bar */

.scrollable-content::-webkit-scrollbar {
  width: 12px;
}

.scrollable-content::-webkit-scrollbar-track {
  background: #292B4E;
  border-style: solid;
  border-color: white;
  border-radius: 6px;
}

.scrollable-content::-webkit-scrollbar-thumb {
  background: #FFCC33;
  border-radius: 6px;
}

.scrollable-content::-webkit-scrollbar-thumb:hover {
    background: #E6B800;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(6, 1fr); /* Adjust this number for different grid widths */
  gap: 20px;
  justify-content: center;
  align-items: center;
}

.grid-item {
  background-color: transparent;
  border: 3px solid #3CB371; 
  color: white;
  font-size: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 45px; /* Adjust width */
  height: 45px; /* Adjust height */
  border-radius: 10px; /* Adjust border-radius for square/round edges */
}
</style>
