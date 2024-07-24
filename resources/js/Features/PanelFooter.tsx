import React, { PropsWithChildren } from "react";

interface PanelFooterInterface extends PropsWithChildren {
	className?: string;
}

export const PanelFooter: React.FC<PanelFooterInterface> = ({
	className,
	children,
}) => {
	return (
		<div
			className={`bg-gray-50 px-4 py-3 sm:px-6 lg:rounded-b-md ${className}`}
		>
			{children}
		</div>
	);
};
