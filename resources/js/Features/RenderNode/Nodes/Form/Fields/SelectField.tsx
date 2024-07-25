import React from "react";
import {
	SelectField as SelectFieldComponent,
	SelectFieldInterface as SelectFieldComponentInterface,
} from "../../../../Fields/SelectField";
import {
	WrapperFieldPropsInterface,
	FieldWrapper,
} from "./partials/FieldWrapper";

export interface SelectFieldInterface
	extends WrapperFieldPropsInterface,
		SelectFieldComponentInterface {
	nodeType: "SelectField";
}

export const SelectField: React.FunctionComponent<SelectFieldInterface> = (
	props,
) => <FieldWrapper props={props} field={SelectFieldComponent} />;
