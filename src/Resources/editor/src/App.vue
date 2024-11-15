<script setup>
import Layout from "./components/Layout.vue";
import {onMounted} from "vue";
import {fetchAvailableZones} from "./core-logic/infrastructure/fetchAvailableZones";

onMounted(() => {

  fetchAvailableZones();

});

const handleDrag = (dragEvent) => {
  dragEvent.dataTransfer.setDragImage(
    dragEvent.target,
    window.outerWidth,
    window.outerHeight
  );
};

document.addEventListener("dragstart", handleDrag);
</script>

<template>
  <Layout />
</template>
