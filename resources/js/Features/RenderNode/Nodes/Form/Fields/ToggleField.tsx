import React from "react";
import {
	ToggleField as ToggleFieldComponent,
	ToggleFieldInterface as ToggleFieldComponentInterface,
} from "../../../../Fields/ToggleField";
import {
	FieldWrapper,
	WrapperFieldPropsInterface,
} from "./partials/FieldWrapper";

export interface ToggleFieldInterface
	extends WrapperFieldPropsInterface,
		ToggleFieldComponentInterface {
	nodeType: "ToggleField";
}

export const ToggleField: React.FunctionComponent<ToggleFieldInterface> = (
	props,
) => <FieldWrapper props={props} field={ToggleFieldComponent} />;
