<template>
  <div>
    <div class="chart-container">
      <LineChart :options="chartOptions" :data="chartData" />
    </div>
  </div>
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement)

export default {
  components: { LineChart: Line },
  data() {
    return {
      chartData: {
        labels: Array.from({ length: 101 }, (_, i) => i), // Score range from 0 to 100
        datasets: [{
          label: 'Score Distribution',
          data: this.generateBellCurve(75, 15), // Mean 75, Std Dev 15
          borderColor: '#292B4E',
          backgroundColor: 'rgba(41, 43, 78, 0.2)',
          borderWidth: 2,
          pointBackgroundColor: '#292B4E',
          pointBorderColor: '#000',
          tension: 0.4,
          fill: true,
        }]
      },
      chartOptions: {
        responsive: true,
        plugins: {
          legend: { position: 'top' },
          title: { display: true, text: 'Exam Score Distribution (Bell Curve)' }
        },
        scales: {
          y: {
            beginAtZero: true,
            title: { display: true, text: 'Frequency' }
          },
          x: {
            title: { display: true, text: 'Score' }
          }
        }
      }
    }
  },
  methods: {
    generateBellCurve(mean, stdDev) {
      const scores = Array.from({ length: 101 }, (_, x) => {
        const exponent = -((x - mean) ** 2) / (2 * (stdDev ** 2));
        return (1 / (stdDev * Math.sqrt(2 * Math.PI))) * Math.exp(exponent) * 1000; // Scaling factor for visibility
      });
      return scores;
    }
  }
}
</script>

<style scoped>
.chart-container {
  width: 100%;
  height: 75vh;
  max-height: 75%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
