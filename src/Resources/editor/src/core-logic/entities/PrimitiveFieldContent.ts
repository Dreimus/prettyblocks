import {PrimitiveFieldType} from "./ElementType";

export type PrimitiveTextType = {
  value: string;
};

export type PrimitiveNumberType = {
  value: number;
};

export type PrimitiveRangeType = PrimitiveNumberType & {
  min: number;
  max: number;
};

export type PrimitiveTextAreaType = PrimitiveTextType;
export type PrimitivePasswordType = PrimitiveTextType;
export type PrimitiveEmailType = PrimitiveTextType;
export type PrimitiveUrlType = PrimitiveTextType;
export type PrimitiveColorType = PrimitiveTextType;

export type PrimitiveBooleanType = {
  value: boolean;
};
export type PrimitiveSwitchType = PrimitiveBooleanType;
export type PrimitiveCheckboxType = Record<string, boolean>;

export type PrimitiveSelectType = {
  value: string;
  options: { label: string; value: string }[];
};
export type PrimitiveRadioType = PrimitiveSelectType;

export type PrimitiveDateType = {
  value: Date;
};

export type PrimitiveIconType = {
  name: string;
  iconList: string[];
};

export type PrimitiveLinkType = {
  label: string;
  href: string;
};

// TODO Fix this
export type PrimitiveFileType = unknown;
export type PrimitiveOembedType = unknown;
export type PrimitiveWysiwygType = PrimitiveTextType & {
  options: unknown;
};
export type PrimitiveMapType = unknown;

// Add mapping to your new primitive field content here
export interface PrimitiveFieldContentMap {
  [PrimitiveFieldType.NUMBER]: PrimitiveNumberType;
  [PrimitiveFieldType.RANGE]: PrimitiveRangeType;
  [PrimitiveFieldType.TEXT]: PrimitiveTextType;
  [PrimitiveFieldType.TEXT_AREA]: PrimitiveTextAreaType;
  [PrimitiveFieldType.PASSWORD]: PrimitivePasswordType;
  [PrimitiveFieldType.EMAIL]: PrimitiveEmailType;
  [PrimitiveFieldType.URL]: PrimitiveUrlType;
  [PrimitiveFieldType.CHECKBOX]: PrimitiveCheckboxType;
  [PrimitiveFieldType.RADIO]: PrimitiveRadioType;
  [PrimitiveFieldType.SELECT]: PrimitiveSelectType;
  [PrimitiveFieldType.SWITCH]: PrimitiveSwitchType;
  [PrimitiveFieldType.FILE]: PrimitiveFileType;
  [PrimitiveFieldType.OEMBED]: PrimitiveOembedType;
  [PrimitiveFieldType.WYSIWYG]: PrimitiveWysiwygType;
  [PrimitiveFieldType.COLOR]: PrimitiveColorType;
  [PrimitiveFieldType.DATE]: PrimitiveDateType;
  [PrimitiveFieldType.MAP]: PrimitiveMapType;
  [PrimitiveFieldType.ICON]: PrimitiveIconType;
  [PrimitiveFieldType.LINK]: PrimitiveLinkType;
}

export type PrimitiveFieldContent<T extends PrimitiveFieldType> = {
  id: string;
  structureId: string;
  type: PrimitiveFieldType;
  label: string;
  optional?: boolean;
  content: PrimitiveFieldContentMap[T];
  hidden?: boolean;
};
