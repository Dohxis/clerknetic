import React from "react";
import { NodeType } from "../NodeType";
import { RenderNode } from "../RenderNode";
import { nl2br } from "~/Utilities/TextUtility";

export interface TextInterface {
	nodeType: "Text";
	nodesAndStrings: (string | NodeType)[];
	color: string | null;
}

export const Text: React.FunctionComponent<TextInterface> = ({
	nodesAndStrings,
	color,
}) => {
	return (
		<span
			style={{
				color: color ?? undefined,
			}}
		>
			{nodesAndStrings.map((nodeOrString, index) => {
				if (typeof nodeOrString === "string") {
					return nl2br(nodeOrString);
				}

				return <RenderNode key={index} {...nodeOrString} />;
			})}
		</span>
	);
};
