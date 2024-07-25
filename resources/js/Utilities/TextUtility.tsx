export const randomString = (): string => {
	return Math.random().toString(36).substring(7);
};

export const nl2br = (text: string) => {
	return text.split("\n").map((line, index) => {
		if (index > 0) {
			return [<br key={`br-${index}`} />, line];
		}

		return line;
	});
};
