import {BlockContent} from "./../entities/BlockContent";
import {FieldContent} from "./../entities/ComponentContent";
import {NavigationState} from "../entities/NavigationState";
import {defineStore} from "pinia";

export const useNavigationStore = defineStore("navigation", {
  state: (): NavigationState => {
    return {
      selectedElement: null,
    };
  },
  getters: {},
  actions: {
    selectElement(element: FieldContent | BlockContent): void {
      this.selectedElement = element;
    },
  },
});
