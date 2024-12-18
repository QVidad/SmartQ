<template>
  <div>
    <div class="chart-container">
      <Bar :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
  components: { Bar },
  data() {
    return {
      chartData: null,
      chartOptions: {
        responsive: true,
        plugins: {
          legend: { display: true },
          title: {
            display: true,
            text: 'Students Performance in Subjects'
          }
        },
        scales: {
          x: {
            stacked: true, // Enable stacking for the x-axis
            title: { display: true, text: 'Subjects' }
          },
          y: {
            stacked: true, // Enable stacking for the y-axis
            title: { display: true, text: 'Number of Students' },
            beginAtZero: true
          }
        }
      }
    };
  },
  props: {
    data: {
      required: true
    }
  },
  created() {
    this.chartData = this.fetchData();
  },
  methods: {
    fetchData() {
      // const passFailData = [
      //   { subject: 'Anatomy', passed: 18, failed: 7 },
      //   { subject: 'Biochemistry', passed: 15, failed: 10 },
      //   { subject: 'Physiology', passed: 20, failed: 5 },
      //   { subject: 'Pathology', passed: 17, failed: 8 },
      //   { subject: 'Pharmacology', passed: 22, failed: 3 },
      //   { subject: 'Microbiology', passed: 25, failed: 0 },
      //   { subject: 'Internal Medicine', passed: 23, failed: 2 },
      //   { subject: 'Surgery', passed: 16, failed: 9 },
      //   { subject: 'Pediatrics', passed: 18, failed: 7 },
      //   { subject: 'Obstetrics and Gynecology', passed: 14, failed: 11 },
      //   { subject: 'Preventive Medicine', passed: 19, failed: 6 },
      //   { subject: 'Legal Medicine', passed: 21, failed: 4 }
      // ];

      // const labels = passFailData.map(item => item.subject);
      // const passedData = passFailData.map(item => item.passed);
      // const failedData = passFailData.map(item => item.failed);
      console.log(this.data)

      const labels = this.data.map(item => item.topic_name);
      const passedData = this.data.map(item => item.students_passed);
      const failedData = this.data.map(item => item.students_failed);

      return {
        labels,
        datasets: [
          {
            label: 'Failed',
            data: failedData,
            backgroundColor: '#EF5350',
          },
          {
            label: 'Passed',
            data: passedData,
            backgroundColor: '#66BB6A',
          }
        ]
      };
    }
  }
};
</script>

<style scoped>
.chart-container {
  width: 100%;
  height: 75vh;
  max-height: 75%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
</style>
