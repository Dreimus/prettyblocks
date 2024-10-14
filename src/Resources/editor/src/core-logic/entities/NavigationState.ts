import {BlockContent} from "./BlockContent";
import {FieldContent} from "./ComponentContent";

export type NavigationState = {
  selectedElement: FieldContent | BlockContent;
};
