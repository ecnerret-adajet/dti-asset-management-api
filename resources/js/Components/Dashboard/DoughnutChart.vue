<script setup>
import { Doughnut } from 'vue-chartjs'
import {
  Chart as ChartJS,
  ArcElement,
  Tooltip,
  Legend
} from 'chart.js'

ChartJS.register(ArcElement, Tooltip, Legend)

const props = defineProps({
  data: {
    type: Object,
    required: true
  },
  options: {
    type: Object,
    default: () => ({
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: true,
          position: 'bottom',
        },
      },
    })
  }
})
</script>

<template>
  <Doughnut v-if="data && data.labels && data.datasets" :data="data" :options="options" />
  <div v-else class="text-center text-muted py-5">No data available</div>
</template>
