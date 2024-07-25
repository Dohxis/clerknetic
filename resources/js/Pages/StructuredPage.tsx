import React, { ReactElement } from "react";
import { Layout, LayoutInterface } from "../Features/Layout/Layout";
import { RenderNodes } from "../Features/RenderNode/RenderNodes";
import { PagePropsType } from "../Interfaces/PagePropsType";
import { usePage } from "@inertiajs/react";

const StructuredPage: React.FunctionComponent = () => {
	const { nodes } = usePage<PagePropsType>().props;

	console.log({ nodes });

	return <RenderNodes nodes={nodes} />;
};

(StructuredPage as any).layout = (page: ReactElement<LayoutInterface>) => {
	const { layout, layoutProperties } = page.props;

	return (
		<Layout layout={layout} layoutProperties={layoutProperties}>
			{page}
		</Layout>
	);
};

export default StructuredPage;
