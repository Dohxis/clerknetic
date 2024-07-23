import { useEffect, FormEventHandler } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm } from "@inertiajs/react";
import { UnauthorizedLayout } from "@/Layouts/UnauthorizedLayout";

export default function ConfirmPassword() {
	const { data, setData, post, processing, errors, reset } = useForm({
		password: "",
	});

	useEffect(() => {
		return () => {
			reset("password");
		};
	}, []);

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route("password.confirm"));
	};

	return (
		<UnauthorizedLayout
			title="Confirm Password"
			description="Confirm your password before continuing"
		>
			<Head title="Confirm password" />

			<form onSubmit={submit}>
				<InputLabel htmlFor="password" value="Password" />

				<TextInput
					id="password"
					type="password"
					name="password"
					value={data.password}
					className="mt-1 block w-full"
					isFocused={true}
					onChange={(e) => setData("password", e.target.value)}
				/>

				<InputError message={errors.password} className="mt-2" />

				<PrimaryButton className="mt-6" disabled={processing}>
					Confirm password
				</PrimaryButton>
			</form>
		</UnauthorizedLayout>
	);
}
