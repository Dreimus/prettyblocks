<!-- IframeUrlManager.vue -->
<script setup>
import {defineComponent, ref} from 'vue';
import emitter from 'tiny-emitter/instance';
import Button from "./Button.vue";
defineComponent({
  Button,
});

const url = ref(prettyblocks.routes.front_office);

const updateIframeUrl = () => {
  if (url.value.trim() !== '') {
    emitter.emit('changeUrl', null, url.value);
  }
};
</script>

<template>
  <div class="iframe-url-manager">
    <input v-model="url" class="iframe-url-manager__url" placeholder="Entrez une URL" />
    <Button @click="updateIframeUrl" @keyup.enter="updateIframeUrl" type="primary">Accéder</Button>
  </div>
</template>

<style>
.iframe-url-manager {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.iframe-url-manager__url {
  flex: 1;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 40vw;
}
</style>
