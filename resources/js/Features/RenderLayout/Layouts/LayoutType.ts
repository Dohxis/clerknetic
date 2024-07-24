import { AuthorizedLayoutInterface } from "./AuthorizedLayout/AuthorizedLayout";
import { UnauthorizedLayoutInterface } from "./UnauthorizedLayout/UnauthorizedLayout";

export type LayoutType =
	| AuthorizedLayoutInterface
	| UnauthorizedLayoutInterface;
