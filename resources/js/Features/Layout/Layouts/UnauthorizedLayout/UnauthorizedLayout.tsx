import { Link, usePage } from "@inertiajs/react";
import React, { PropsWithChildren } from "react";
import { useTranslation } from "react-i18next";
import { PagePropsType } from "../../../../Interfaces/PagePropsType";
import { Logo } from "../../../Logo";
import { NodeType } from "../../../RenderNode/NodeType";
import { RenderNode } from "../../../RenderNode/RenderNode";
import { LayoutPropertiesInterface } from "@/Features/Layout/Layout";

export interface UnauthorizedLayoutInterface {
	nodeType: "UnauthorizedLayout";
}

export interface UnauthorizedLayoutComponentInterface
	extends LayoutPropertiesInterface,
		PropsWithChildren {
	subTitle: NodeType | null;
	width: "lg" | "2xl";
}

export const UnauthorizedLayout: React.FunctionComponent<
	UnauthorizedLayoutComponentInterface
> = ({ title, subTitle, width, children }) => {
	const { t } = useTranslation();

	const { applicationName } = usePage<PagePropsType>().props;

	return (
		<main className="flex items-stretch justify-center bg-white sm:min-h-screen">
			<div className="relative z-10 flex w-full flex-none flex-col items-center justify-between lg:w-1/2 lg:shadow-md">
				<div />

				<div
					className={`w-full space-y-6 px-4 pt-7 pb-6 sm:space-y-8 sm:px-6 sm:pb-16 sm:pt-6 ${
						width === "lg" ? "max-w-lg" : "max-w-2xl"
					}`}
				>
					<div>
						<Link
							href="/"
							className="mb-5 inline-flex items-center space-x-3 text-xl font-semibold uppercase text-primary-700 sm:mb-6"
						>
							<Logo className="h-7 w-7" />
							<span>{applicationName}</span>
						</Link>

						{title !== null && (
							<h2 className="text-2xl font-extrabold text-gray-900 sm:mb-2 sm:text-3xl">
								{title}
							</h2>
						)}

						{subTitle !== null && (
							<p className="text-sm text-gray-600">
								<RenderNode {...(subTitle as any)} />
							</p>
						)}
					</div>

					<div>{children}</div>
				</div>

				<footer className="px-4 pb-3 text-center text-xs text-gray-300">
					{t("© {{ year }} {{ name }}. All rights reserved.", {
						year: new Date().getFullYear(),
						name: applicationName,
					})}
				</footer>
			</div>

			<div
				className="relative hidden flex-1 bg-cover bg-right bg-no-repeat lg:block"
				style={{
					backgroundImage:
						'url("/images/other/UnauthorizedBackground.jpg")',
				}}
			/>
		</main>
	);
};
