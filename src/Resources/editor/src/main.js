import "./index.css";
import "@vueup/vue-quill/dist/vue-quill.snow.css";

import App from "./App.vue";
import {QuillEditor} from "@vueup/vue-quill";
import {createApp} from "vue";
import {createPinia} from "pinia";

const app = createApp(App).use(createPinia());
app.component("QuillEditor", QuillEditor);
app.mount("#app");

window.vueInstance = app;
