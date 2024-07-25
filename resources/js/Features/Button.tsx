import { forwardRef, ReactNode, useEffect, useState } from "react";
import { LoadingIcon } from "./Icons/LoadingIcon";
import { Link } from "./Link";

export interface ButtonInterface {
	type?: "button" | "submit";
	link?: string | null;
	design?: "primary" | "secondary" | "secondary-with-border" | "ternary";
	color?: "primary" | "red" | "yellow" | "gray";
	loading?: boolean;
	disabled?: boolean;
	silentDisabled?: boolean;
	blank?: boolean;
	onClick?: () => void;
	className?: string;
	contentClassName?: string;
	children?: ReactNode;
}

/* eslint-disable react/prop-types */
export const Button = forwardRef<HTMLButtonElement, ButtonInterface>(
	(
		{
			type = "button",
			link = null,
			design = "primary",
			color = "primary",
			loading: givenLoading = false,
			disabled = false,
			silentDisabled = false,
			blank,
			onClick,
			className = "",
			contentClassName = "",
			children,
		},
		ref,
	) => {
		const [timeoutLoadingEnded, setTimeoutLoadingEnded] = useState(true);

		useEffect(() => {
			// Sets minimum loading time
			if (givenLoading && timeoutLoadingEnded) {
				setTimeoutLoadingEnded(false);

				setTimeout(() => setTimeoutLoadingEnded(true), 200);
			}
		}, [givenLoading]);

		const loading = givenLoading || !timeoutLoadingEnded;

		const primaryColorClassName = {
			primary: `[--btn-bg:theme(colors.primary.600)] [--btn-border:theme(colors.primary.700/90%)]`,
			red: `[--btn-bg:theme(colors.red.600)] [--btn-border:theme(colors.red.700/90%)]`,
			yellow: `[--btn-bg:theme(colors.yellow.600)] [--btn-border:theme(colors.yellow.700/90%)]`,
			gray: `[--btn-bg:theme(colors.gray.600)] [--btn-border:theme(colors.gray.700/90%)]`,
		}[color];

		const colorClassName = {
			primary: `bg-primary-600 focus:shadow-outline ${
				loading || silentDisabled
					? ""
					: "hover:bg-primary-700 disabled:bg-gray-400"
			}`,
			red: `bg-red-600 focus:shadow-outline-red ${
				silentDisabled ? "" : "hover:bg-red-700 disabled:bg-red-600"
			}`,
			yellow: `bg-yellow-600 focus:shadow-outline-yellow ${
				silentDisabled
					? ""
					: "hover:bg-yellow-700 disabled:bg-yellow-600"
			}`,
			gray: `bg-gray-500 focus:shadow-outline-gray ${
				silentDisabled ? "" : "hover:bg-gray-600 disabled:bg-gray-500"
			}`,
		}[color];

		const getDesignClassName = () => {
			if (design === "primary") {
				return `text-white ${colorClassName}`;
			}

			if (design === "secondary") {
				return `text-gray-700 bg-gray-100 ${
					silentDisabled
						? ""
						: "hover:bg-gray-200 disabled:bg-gray-100"
				}`;
			}

			if (design === "secondary-with-border") {
				return `bg-white text-gray-700 border border-gray-300 ${
					silentDisabled ? "" : "hover:bg-gray-100 disabled:bg-white"
				}`;
			}

			/**
			 * Ternary design
			 */
			return `bg-white text-gray-700 ${
				silentDisabled ? "" : "hover:bg-gray-100 disabled:bg-white"
			}`;
		};

		return (
			<Link
				ref={ref}
				className={
					design === "primary"
						? `${primaryColorClassName} [--btn-hover-overlay:theme(colors.white/10%)] after:-z-10 after:absolute after:active:bg-[--btn-hover-overlay] after:disabled:shadow-none after:hover:bg-[--btn-hover-overlay] after:inset-0 after:rounded-[calc(theme(borderRadius.md)-1px)] after:shadow-[shadow:inset_0_1px_theme(colors.white/15%)] before:-z-10 before:absolute before:bg-[--btn-bg] before:disabled:shadow-none before:inset-0 before:rounded-[calc(theme(borderRadius.md)-1px)] before:shadow bg-[--btn-border] border border-transparent cursor-pointer disabled:opacity-50 focus:outline-none font-semibold isolate flex items-center justify-center relative rounded-md px-4 py-2 text-white w-full text-sm`
						: `relative flex min-h-[2.25rem] w-full items-center justify-center rounded-md px-4 py-1 text-sm font-medium transition duration-150 disabled:cursor-default ${
								silentDisabled ? "" : "disabled:opacity-40"
							} ${getDesignClassName()} ${className}`
				}
				type={type}
				link={link}
				loading={loading}
				disabled={disabled || silentDisabled}
				blank={blank}
				onClick={onClick}
			>
				<div
					className={`flex items-center text-left leading-tight ${
						loading ? "opacity-0" : ""
					} ${contentClassName}`}
				>
					{children}
				</div>

				{loading && (
					<div className="pointer-events-none absolute inset-0 flex items-center justify-center">
						<LoadingIcon className="h-4 w-4 animate-spin" />
					</div>
				)}
			</Link>
		);
	},
);
