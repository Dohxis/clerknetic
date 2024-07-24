import React, { PropsWithChildren } from "react";
import { Layout } from "./Layout";
import { LayoutCommonInterface } from "./LayoutCommonInterface";
import { LayoutType } from "./Layouts/LayoutType";
import { AuthorizedLayout } from "./Layouts/AuthorizedLayout/AuthorizedLayout";
import { UnauthorizedLayout } from "./Layouts/UnauthorizedLayout/UnauthorizedLayout";

interface RenderLayoutInterface extends PropsWithChildren {
	layout: LayoutType;
	commonProperties: LayoutCommonInterface;
}

export const RenderLayout: React.FC<RenderLayoutInterface> = ({
	layout,
	commonProperties,
	children,
}) => {
	const LayoutComponent = {
		AuthorizedLayout: AuthorizedLayout,
		UnauthorizedLayout: UnauthorizedLayout,
	}[layout.nodeType];

	/* eslint-disable @typescript-eslint/no-explicit-any */
	if (LayoutComponent) {
		return (
			<Layout {...commonProperties}>
				<LayoutComponent {...commonProperties} {...(layout as any)}>
					{children}
				</LayoutComponent>
			</Layout>
		);
	}

	console.warn(`Layout "${layout.nodeType}" was not found!`);

	return null;
};
