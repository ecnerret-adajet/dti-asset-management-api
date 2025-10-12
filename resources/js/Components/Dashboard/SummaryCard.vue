<template>
  <div class="col-xl-2 col-md-4 col-sm-6">
    <div
      :class="[
        'card card-custom card-stretch gutter-b',
        cardClass,
        { 'bgi-no-repeat': !colored },
      ]"
      :style="!colored ? cardStyle : ''"
    >
      <div class="card-body">
        <span :class="['svg-icon svg-icon-2x', iconColorClass]" v-html="icon">
        </span>
        <span
          :class="[
            'card-title font-weight-bolder font-size-h2 mb-0 mt-6 d-block',
            colored ? 'text-white' : 'text-dark-75',
          ]"
        >
          {{ value }}
        </span>
        <span
          :class="[
            'font-weight-bold font-size-sm',
            colored ? 'text-white' : 'text-muted',
          ]"
        >
          {{ title }}
        </span>
        <span
          v-if="subtitle"
          :class="[
            'font-weight-normal font-size-xs d-block mt-2',
            colored ? 'text-white opacity-75' : 'text-muted',
          ]"
        >
          {{ subtitle }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  value: {
    type: [String, Number],
    required: true,
  },
  subtitle: {
    type: String,
    default: "",
  },
  icon: {
    type: String,
    required: true,
  },
  color: {
    type: String,
    default: "info", // info, success, danger, warning, primary, dark
  },
  colored: {
    type: Boolean,
    default: false,
  },
});

const cardClass = computed(() => {
  if (props.colored) {
    return `bg-${props.color}`;
  }
  return "";
});

const iconColorClass = computed(() => {
  if (props.colored) {
    return "svg-icon-white";
  }
  return `svg-icon-${props.color}`;
});

const cardStyle = computed(() => {
  return "background-position: right top; background-size: 30% auto; background-image: url(assets/media/svg/shapes/abstract-1.svg);";
});
</script>
