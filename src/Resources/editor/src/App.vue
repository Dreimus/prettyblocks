<script setup>
import Layout from "./components/Layout.vue";
import {onMounted} from "vue";
import {fetchAvailableBlocks} from "./core-logic/usecases/fetchAvailableBlocks";
import {fetchAvailableZones} from "./core-logic/usecases/fetchAvailableZones";

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
