import { Page } from "@inertiajs/core";

export type AuthorizedPagePropsType<T> = Page<
	{
		user: {
			name: string;
			email: string;
		};
	} & T
>;
