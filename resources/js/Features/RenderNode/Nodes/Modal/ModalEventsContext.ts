import React from "react";
import { ResponseSuccessType } from "../../../../Hooks/useFetch";

interface ModalEventsContextInterface {
	onSubmitSuccess:
		| (<T>(response: ResponseSuccessType<T>) => Promise<void>)
		| null;
}

const ModalEventsContext = React.createContext<ModalEventsContextInterface>({
	onSubmitSuccess: null,
});

export default ModalEventsContext;
