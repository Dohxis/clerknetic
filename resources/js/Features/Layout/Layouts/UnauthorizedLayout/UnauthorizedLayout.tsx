import { Link } from "@inertiajs/react";
import { PropsWithChildren } from "react";

export interface UnauthorizedLayoutInterface {
	nodeType: "UnauthorizedLayout";
	panelTitle: string;
	panelDescription: string;
	panelDescriptionLinkText: string;
	panelDescriptionLinkHref: string;
}

export interface UnauthorizedLayoutComponentInterface
	extends UnauthorizedLayoutInterface,
		PropsWithChildren {}

export const UnauthorizedLayout = ({
	panelTitle,
	panelDescription,
	panelDescriptionLinkText,
	panelDescriptionLinkHref,
	children,
}: UnauthorizedLayoutComponentInterface) => {
	return (
		<>
			<div className="fixed inset-0 bg-gray-50 z-[-999]" />

			<div
				className="fixed inset-0 opacity-[0.045] z-[-999]"
				style={{
					backgroundImage: 'url("/images/noise.png")',
					backgroundSize: 200,
				}}
			/>

			<div className="flex items-center justify-center min-h-screen px-4 py-8 sm:px-6 lg:px-8">
				<div className="w-full max-w-md">
					<div className="bg-white shadow-md rounded-lg p-8">
						<div className="flex flex-col items-center mb-8">
							<svg
								viewBox="0 0 24 24"
								xmlns="http://www.w3.org/2000/svg"
								fill="currentColor"
								aria-hidden="true"
								className="h-6 w-6 mb-6"
							>
								<path d="M10.9999 2.04938L11 5.07088C7.6077 5.55612 5 8.47352 5 12C5 15.866 8.13401 19 12 19C13.5723 19 15.0236 18.4816 16.1922 17.6064L18.3289 19.7428C16.605 21.1536 14.4014 22 12 22C6.47715 22 2 17.5228 2 12C2 6.81468 5.94662 2.55115 10.9999 2.04938ZM21.9506 13.0001C21.7509 15.0111 20.9555 16.8468 19.7433 18.3283L17.6064 16.1922C18.2926 15.2759 18.7595 14.1859 18.9291 13L21.9506 13.0001ZM13.0011 2.04948C17.725 2.51902 21.4815 6.27589 21.9506 10.9999L18.9291 10.9998C18.4905 7.93452 16.0661 5.50992 13.001 5.07103L13.0011 2.04948Z"></path>
							</svg>

							<h3 className="text-lg font-semibold text-gray-900 mb-2">
								{panelTitle}
							</h3>

							<p className="text-sm text-gray-600">
								{panelDescription}{" "}
								<Link
									href={panelDescriptionLinkHref}
									className="font-medium text-primary-600 hover:text-primary-500 focus:outline-none"
								>
									{panelDescriptionLinkText}
								</Link>
							</p>
						</div>

						<div>{children}</div>
					</div>
				</div>
			</div>
		</>
	);
};
