import React, { PropsWithChildren } from "react";
import {
	AuthorizedLayout,
	AuthorizedLayoutInterface,
} from "./Layouts/AuthorizedLayout/AuthorizedLayout";
import {
	UnauthorizedLayout,
	UnauthorizedLayoutInterface,
} from "./Layouts/UnauthorizedLayout/UnauthorizedLayout";
import { Notifications } from "~/Features/Notifications/Notifications";
import { Head } from "@inertiajs/react";
import { TabDesignType } from "~/Features/RenderNode/Nodes/Tabs/Enums/TabDesign";

export interface NavigationItemInterface {
	title: string | null;
	icon: string | null;
	route: string;
	activeMatch: string;
}

export interface UserNavigationItemInterface {
	title: string | null;
	route: string;
}

export interface TabsMenuItemInterface {
	title: string;
	link: string;
	count: string | null;
	icon: string | null;
	active: boolean;
}

export interface LayoutPropertiesInterface {
	title: string | null;
	navigation: NavigationItemInterface[];
	userNavigation: UserNavigationItemInterface[];
	tabs: TabsMenuItemInterface[];
	tabsDesign: TabDesignType | null;
}

export interface LayoutInterface extends PropsWithChildren {
	layout: AuthorizedLayoutInterface | UnauthorizedLayoutInterface;
	layoutProperties: LayoutPropertiesInterface;
}

export const Layout: React.FunctionComponent<LayoutInterface> = ({
	layout,
	layoutProperties,
	children,
}) => {
	const LayoutComponent = {
		AuthorizedLayout: AuthorizedLayout,
		UnauthorizedLayout: UnauthorizedLayout,
	}[layout.nodeType];

	if (LayoutComponent) {
		return (
			<Notifications>
				<Head title={layoutProperties.title ?? undefined} />

				{/* @ts-ignore */}
				<LayoutComponent {...layout} {...layoutProperties}>
					{children}
				</LayoutComponent>
			</Notifications>
		);
	}

	return null;
};
