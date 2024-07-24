import React, { useState } from "react";
import { Bars3Icon, XMarkIcon } from "@heroicons/react/24/outline"; // Define sidebar items with sections

// Define sidebar items with sections
const sidebarItems = [
	{
		section: null,
		items: [
			{
				icon: "M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6",
				text: "Dashboard",
			},
		],
	},
	{
		section: "Analytics",
		items: [
			{
				icon: "M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z",
				text: "Reports",
			},
			{
				icon: "M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z",
				text: "Charts",
			},
		],
	},
	{
		section: "Management",
		items: [
			{
				icon: "M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4",
				text: "Settings",
			},
			{
				icon: "M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z",
				text: "Users",
			},
		],
	},
];

const SidebarItem = ({ icon, text }: any) => (
	<li>
		<a
			href="#"
			className="flex items-center space-x-3 text-gray-600 p-2 rounded-md hover:bg-gray-100 transition duration-150 ease-in-out"
		>
			<svg
				className="h-5 w-5"
				fill="none"
				viewBox="0 0 24 24"
				stroke="currentColor"
			>
				<path
					strokeLinecap="round"
					strokeLinejoin="round"
					strokeWidth={1.5}
					d={icon}
				/>
			</svg>
			<span className="text-sm">{text}</span>
		</a>
	</li>
);

const Sidebar = ({ isOpen }: any) => {
	return (
		<div
			className={`bg-gray-50 text-gray-800 h-screen w-72 fixed top-0 left-0 transition-transform duration-300 ease-in-out ${
				isOpen ? "translate-x-0" : "-translate-x-full"
			} lg:translate-x-0 z-30 overflow-y-auto border-r border-gray-200`}
		>
			<div className="p-5">
				<h2 className="text-xl font-semibold mb-6 text-gray-800">
					Clerknetic
				</h2>
				<nav>
					{sidebarItems.map((section, index) => (
						<div key={index} className="mb-6">
							{section.section && (
								<h3 className="text-xs uppercase text-gray-400 font-medium mb-2 px-2">
									{section.section}
								</h3>
							)}
							<ul className="space-y-1">
								{section.items.map((item, itemIndex) => (
									<SidebarItem
										key={itemIndex}
										icon={item.icon}
										text={item.text}
									/>
								))}
							</ul>
						</div>
					))}
				</nav>
			</div>
		</div>
	);
};

export default function Dashboard() {
	const [sidebarOpen, setSidebarOpen] = useState(false);

	const toggleSidebar = () => setSidebarOpen(!sidebarOpen);

	return (
		<div className="bg-white min-h-screen">
			<Sidebar isOpen={sidebarOpen} />

			<div className="lg:ml-64 transition-all duration-300 ease-in-out">
				<header className="bg-white border-b border-gray-200">
					<div className="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
						<h1 className="text-xl font-semibold text-gray-800">
							Dashboard
						</h1>
						<button
							onClick={toggleSidebar}
							className="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-300"
						>
							{sidebarOpen ? (
								<XMarkIcon className="h-6 w-6" />
							) : (
								<Bars3Icon className="h-6 w-6" />
							)}
						</button>
					</div>
				</header>

				<main className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
					{/* Main section without title */}
					<div className="px-4 py-6 sm:px-0">
						<div className="bg-white border border-gray-200 rounded-md">
							<div className="p-6">
								<p className="text-gray-600">
									Your main dashboard content goes here. Add
									cards, charts, and other components to
									display your data.
								</p>
							</div>
						</div>
					</div>

					{/* Additional sections with titles */}
					<div className="mt-8">
						<h2 className="text-lg font-medium text-gray-800 mb-4 px-4 sm:px-0">
							Recent Activity
						</h2>
						<div className="bg-white border border-gray-200 rounded-md">
							<div className="p-6">
								<p className="text-gray-600">
									Display recent user activity or important
									updates here.
								</p>
							</div>
						</div>
					</div>

					<div className="mt-8">
						<h2 className="text-lg font-medium text-gray-800 mb-4 px-4 sm:px-0">
							Performance Metrics
						</h2>
						<div className="bg-white border border-gray-200 rounded-md">
							<div className="p-6">
								<p className="text-gray-600">
									Show key performance indicators and metrics
									in this section.
								</p>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
	);
}
