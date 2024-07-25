import React from "react";
import {
	RadiosField as RadiosFieldComponent,
	RadiosFieldInterface as RadiosFieldComponentInterface,
} from "../../../../Fields/RadiosField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface RadiosFieldInterface
	extends WrapperFieldPropsInterface,
		RadiosFieldComponentInterface {
	nodeType: "RadiosField";
}

export const RadiosField: React.FunctionComponent<RadiosFieldInterface> = (
	props,
) => <FieldWrapper props={{ ...props }} field={RadiosFieldComponent} />;
