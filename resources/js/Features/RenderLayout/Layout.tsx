import { Head } from "@inertiajs/react";
import React from "react";
import { Notifications } from "../Notifications/Notifications";
import { LayoutCommonInterface } from "./LayoutCommonInterface";

export const Layout: React.FC<LayoutCommonInterface> = ({
	title,
	children,
}) => {
	return (
		<>
			<Head title={title} />

			<Notifications>{children}</Notifications>
		</>
	);
};
