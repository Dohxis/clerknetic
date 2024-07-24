import { PropsWithChildren } from "react";
import { TabsMenuDesignType } from "./Features/Tabs/Enums/TabDesign";
import { UserNavigationItemInterface } from "./Features/UserNavigation";

export interface NavigationItemInterface {
	activeMatch: string;
	route: string;
	title: string | null;
	icon: string | null;
}

export interface LayoutCommonInterface extends PropsWithChildren {
	title: string | undefined;
	navigation: NavigationItemInterface[];
	userNavigation: UserNavigationItemInterface[];
	tabs: TabsMenuItemInterface[];
	tabsDesign: TabsMenuDesignType | null;
}

export interface TabsMenuItemInterface {
	title: string;
	link: string;
	count: string | null;
	icon: string | null;
	active: boolean;
}
