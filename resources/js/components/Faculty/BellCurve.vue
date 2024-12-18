<template>
  <div>
    <div class="chart-container">
      <LineChart :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script>
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement);

export default {
  components: { LineChart: Line },
  data() {
    return {
      chartData: null,
      chartOptions: {
        responsive: true,
        plugins: {
          legend: { display: true },
          title: {
            display: true,
            text: 'Score Distribution (Bell Curve) Across Subjects'
          }
        },
        scales: {
          x: { title: { display: true, text: 'Score Range' } },
          y: {
            title: { display: true, text: 'Frequency' },
            beginAtZero: true
          }
        }
      }
    }
  },
  props: {
    data: {
      required: true
    }
  },
  created() {
    this.chartData = this.generateBellCurveData();
  },
  methods: {
    generateBellCurveData() {
      // const subjects = [
      //   { name: 'Anatomy', mean: 75, stdDev: 10 },
      //   { name: 'Biochemistry', mean: 70, stdDev: 12 },
      //   { name: 'Physiology', mean: 65, stdDev: 15 },
      //   { name: 'Pathology', mean: 68, stdDev: 10 },
      //   { name: 'Pharmacology', mean: 80, stdDev: 8 },
      //   { name: 'Microbiology', mean: 85, stdDev: 5 },
      //   { name: 'Internal Medicine', mean: 78, stdDev: 9 },
      //   { name: 'Surgery', mean: 72, stdDev: 11 },
      //   { name: 'Pediatrics', mean: 74, stdDev: 10 },
      //   { name: 'Obsterics and Gynecology', mean: 69, stdDev: 13 },
      //   { name: 'Preventive Medicine', mean: 73, stdDev: 10 },
      //   { name: 'Legal Medicine', mean: 77, stdDev: 9 }
      // ];

      const subjects = this.data;

      // Generate x-axis labels representing score ranges
      const labels = Array.from({ length: 101 }, (_, i) => i); // Scores from 0 to 100

      // Generate datasets for each subject
      const datasets = subjects.map(subject => ({
        // label: subject.name,
        label: subject.topic_name,
        data: this.generateNormalDistribution(subject.mean, subject.stdDev, labels),
        borderColor: this.getRandomColor(),
        fill: false,
        pointRadius: 0
      }));

      return {
        labels,
        datasets
      };
    },
    generateNormalDistribution(mean, stdDev, labels) {
      // Generate normal distribution points based on mean and standard deviation
      return labels.map(x => {
        const exponent = -((x - mean) ** 2) / (2 * (stdDev ** 2));
        return (1 / (stdDev * Math.sqrt(2 * Math.PI))) * Math.exp(exponent) * 100; // Scaling for visibility
      });
    },
    getRandomColor() {
      // Generate a random color for each subject
      const letters = '0123456789ABCDEF';
      let color = '#';
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
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
