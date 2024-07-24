import { NotificationItemType } from "../Features/Notifications/Notifications";
import { NodeType } from "../Features/RenderNode/NodeType";
import { PageProps } from "@inertiajs/core";

export type PagePropsType = PagePropsInterface;

export interface PagePropsInterface extends PageProps {
	nodes: NodeType[];
	baseUrl: string;
	applicationName: string;
	notification: NotificationItemType | null;
	resetFormIdentifier: string | null;
	csrfToken: string;
	errors: Record<string, string>;
	user: {
		name: string;
		email: string;
	} | null;
	balance: string | null;
}
