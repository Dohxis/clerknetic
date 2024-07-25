import React from "react";

export interface ImageInterface {
	nodeType: "Image";
	src: string;
	alt: string;
}

export const Image: React.FunctionComponent<ImageInterface> = ({
	src,
	alt,
}) => <img src={src} alt={alt} />;
