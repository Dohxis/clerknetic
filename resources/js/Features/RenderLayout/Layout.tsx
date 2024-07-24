import { usePage } from "@inertiajs/react";
import React, { useEffect } from "react";
import { PagePropsType } from "../../Interfaces/PagePropsType";
import { Notifications } from "../Notifications/Notifications";
import { LayoutCommonInterface } from "./LayoutCommonInterface";

export const Layout: React.FC<LayoutCommonInterface> = ({
	title,
	children,
}) => {
	const { applicationName } = usePage<PagePropsType>().props;

	useEffect(() => {
		if (title !== null) {
			document.title = `${title} - ${applicationName}`;
		}
	}, [title]);

	return <Notifications>{children}</Notifications>;
};
