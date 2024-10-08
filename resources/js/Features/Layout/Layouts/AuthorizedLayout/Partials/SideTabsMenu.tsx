import { Icon } from "~/Features/Icon";
import { TabsMenuItemInterface } from "~/Features/Layout/Layout";
import { Link } from "~/Features/Link";
import React from "react";

interface SideTabsMenuInterface {
	tabs: TabsMenuItemInterface[];
}

export const SideTabsMenu: React.FunctionComponent<SideTabsMenuInterface> = ({
	tabs,
}) => (
	<nav className="flex w-64 flex-none flex-col space-y-1">
		{tabs.map(({ active, link, title, count, icon }) => (
			<Link
				key={title}
				link={link}
				className={`group focus:shadow-outline flex items-center space-x-3 rounded-md border-primary-600 p-2 text-sm font-medium transition-all duration-150 focus:relative ${
					active
						? "bg-white text-primary-700 shadow"
						: "text-gray-800 hover:bg-white"
				}`}
			>
				{icon !== null && (
					<Icon
						className={`h-6 w-6 flex-none ${
							active ? "text-primary-600" : "text-gray-400"
						}`}
						icon={icon}
					/>
				)}

				<div className="flex-1">{title}</div>

				{count !== null && (
					<div
						className={`ml-3 rounded-full px-2 py-[2px] text-xs text-gray-800 ${
							active
								? "bg-gray-100"
								: "bg-white group-hover:bg-gray-100"
						}`}
					>
						{count}
					</div>
				)}
			</Link>
		))}
	</nav>
);
