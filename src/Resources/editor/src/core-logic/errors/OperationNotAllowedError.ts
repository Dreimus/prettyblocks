export interface OperationNotAllowedError extends Error {
  name: "OperationNotAllowedError";
}
export function OperationNotAllowedError(operation: string, reason: string) {
  const error = new Error(
    `Operation ${operation} not allowed.\n${reason}`
  ) as OperationNotAllowedError;
  error.name = "OperationNotAllowedError";
  return error;
}
