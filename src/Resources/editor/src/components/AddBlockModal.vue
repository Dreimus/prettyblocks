<template>
  <div
    v-if="showModal"
    class="fixed inset-0 z-50 flex justify-center items-center p-4 bg-black/50"
  >
    <div
      class="flex flex-col w-full max-w-5xl max-h-full bg-white rounded-lg shadow-lg"
    >
      <!-- Header -->
      <div
        class="flex items-start justify-between p-5 border-b border-solid border-slate-200"
      >
        <h2 class="text-2xl font-semibold">Blocks disponibles</h2>
      </div>
      <!-- Body -->
      <div
        class="overflow-y-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-5"
      >
        <div v-for="block in availableBlocks">
          <span @click="() => addBlock(block.id)">{{ block.label }}</span>
        </div>
      </div>
      <!-- Footer -->
      <div
        class="flex items-center justify-end p-5 border-t border-solid border-slate-200"
      >
        <button
          class="text-indigo bg-transparent border border-solid border-indigo hover:bg-indigo hover:text-white active:bg-indigo font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none ease-linear transition-all duration-150"
          type="button"
          v-on:click="toggleModal()"
        >
          Fermer
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {ref} from "vue";
import emitter from "tiny-emitter/instance";
import {storeToRefs} from "pinia";
import {useZoneStore} from "../core-logic/store/zoneStore";

let showModal = ref(false);

const toggleModal = () => {
  showModal.value = !showModal.value;
};

const zoneStore = useZoneStore();
const { availableBlocks } = storeToRefs(zoneStore);

emitter.on("toggleAddBlockModal", () => {
  toggleModal();
});

const addBlock = (blockId: string) => {
  zoneStore.addBlock(blockId);
  toggleModal();
};
</script>

<style scoped></style>
