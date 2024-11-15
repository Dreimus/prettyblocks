import {useNavigationStore} from "../store/navigationStore";
import {useZoneStore} from "../store/zoneStore";
import {ElementType} from "../entities/ElementType";
import {FieldContent} from "../entities/ComponentContent";
import {BlockContent} from "../entities/BlockContent";
import {findComponentByIdInBlock} from "../utils/finder";


function checkIfBlockOrParentIsSelectedElement(blockId: string, editedElement: FieldContent | BlockContent) {
  return blockId === editedElement.id;
}

function checkIfComponentOrParentIsSelectedElement(componentId: string, editedElement: FieldContent | BlockContent) {

  if (componentId === editedElement.id) {
    return true;
  }

  let zoneStore = useZoneStore();


  return false;
}


export const closeNavigationOnElementOrParentDeletion = (elementId: string, elementType: ElementType) => {

  let mustCloseNavigation = false;
  let navigationStore = useNavigationStore()

  if (!navigationStore.selectedElement) {
    return;
  }


  navigationStore.resetElement()
  return;

  // @todo: implement this

  // switch (elementType) {
  //   case ElementType.BLOCK_TYPE:
  //     mustCloseNavigation = checkIfBlockOrParentIsSelectedElement(elementId, navigationStore.selectedElement);
  //     break;
  //   case ElementType.COMPONENT_TYPE:
  //     mustCloseNavigation = checkIfComponentOrParentIsSelectedElement(elementId, navigationStore.selectedElement);
  //     break;
  // }
  //
  // if (mustCloseNavigation) {
  //   navigationStore.resetElement();
  // }

}
