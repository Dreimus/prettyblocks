export interface CannotFindComponentError extends Error {
  name: "CannotFindComponentError";
}
export function CannotFindComponentError(
  componentId: string,
  contentId = "zone"
) {
  const error = new Error(
    `Cannot find component ${componentId} inside ${contentId}`
  ) as CannotFindComponentError;
  error.name = "CannotFindComponentError";
  return error;
}
