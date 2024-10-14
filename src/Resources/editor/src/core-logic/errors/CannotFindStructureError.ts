export interface CannotFindStructureError extends Error {
  name: "CannotFindStructureError";
}
export function CannotFindStructureError(msg: string) {
  const error = new Error(msg) as CannotFindStructureError;
  error.name = "CannotFindStructureError";
  return error;
}
