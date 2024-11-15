import type {BlockStructure} from "./../entities/BlockStructure";
import type {PrimitiveFieldContentMap} from "../entities/PrimitiveFieldContent";
import {PrimitiveFieldType} from "../entities/ElementType";
import {addBlock} from "../usecases/addBlock";
import {addComponent} from "../usecases/addComponent";
import {defineStore} from "pinia";
import {deleteBlockById} from "../usecases/deleteBlock";
import {deleteComponentById} from "../usecases/deleteComponent";
import {duplicateElement} from "../usecases/duplicateElement";
import {editPrimitiveField} from "../usecases/editPrimitiveField";
import {moveBlock} from "../usecases/moveBlock";
import {moveComponent} from "../usecases/moveComponent";
import {renameElement} from "../usecases/renameElement";
import {toggleComponent} from "../usecases/toggleComponent";
import {setZone} from "../usecases/setZone";
import {saveContent} from "../usecases/saveContent";
import {BlockContent} from "../entities/BlockContent";
import {Zone} from "../entities/Zone";

export const useZoneStore = defineStore("zone", {
  state: (): {
    availableBlocks: BlockStructure[];
    zonesContent: BlockContent[];
    availableZones: Zone[];
    selectedZoneId: string;
    content: BlockContent[];
  } => {
    return {
      availableBlocks: [],
      content: [],
      selectedZoneId: null,
      zonesContent: [],
      availableZones: [],
    };
  },
  getters: {
    getBlockStructure: (state) => {
      return (blockId: string) => {
        console.log("Searching for blockId", blockId);
        console.log("Available blocks", state.availableBlocks);
        return state.availableBlocks.find(
          (block: BlockStructure) => block.id === blockId
        );
      };
    },
    getZoneContent: (state) => {
      return (zoneId: string) => {
        return state.zonesContent[zoneId];
      };
    },
    getAvailableZones: (state) => {
      return state.availableZones;
    },
    getSelectedZoneId: (state) => {
      return state.selectedZoneId;
    },
    getAvailableBlocks: (state) => {
      return state.availableBlocks;
    },
  },
  actions: {
    updateAvailableBlocks(blocks: BlockStructure[]) {
      this.availableBlocks = blocks;
    },
    setZone(zoneId: string) {
      setZone(this, zoneId);
    },
    addBlock(blockId: string) {
      addBlock(this, blockId);
    },
    moveBlock(blockId: string, newIndex: number) {
      moveBlock(this, blockId, newIndex);
    },
    deleteBlockById(blockId: string) {
      deleteBlockById(this, blockId);
    },
    addComponent(blockId: string, root: string, componentId: string) {
      addComponent(this, blockId, root, componentId);
    },
    deleteComponentById(componentId: string) {
      deleteComponentById(this, componentId);
    },
    moveComponent(componentId: string, newIndex: number) {
      moveComponent(this, componentId, newIndex);
    },
    editPrimitiveField<T extends PrimitiveFieldType>(
      componentId: string,
      newValue: PrimitiveFieldContentMap[T]
    ) {
      editPrimitiveField(this, componentId, newValue);
    },
    renameElement(blockId: string, newLabel: string) {
      renameElement(this, blockId, newLabel);
    },
    toggleElement(componentId: string) {
      toggleComponent(this, componentId);
    },
    duplicateElement(componentId: string) {
      duplicateElement(this, componentId);
    },
    saveContent(this) {
      return saveContent(this);
    }
  },
});
