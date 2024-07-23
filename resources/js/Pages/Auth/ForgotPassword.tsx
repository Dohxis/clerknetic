import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { UnauthorizedLayout } from "@/Layouts/UnauthorizedLayout";
import InputLabel from "@/Components/InputLabel";

export default function ForgotPassword({ status }: { status?: string }) {
	const { data, setData, post, processing, errors } = useForm({
		email: "",
	});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route("password.email"));
	};

	return (
		<UnauthorizedLayout
			title="Reset password"
			description="Reset link will be sent to your email"
		>
			<Head title="Forgot password" />

			<form onSubmit={submit}>
				<InputLabel htmlFor="email" value="Email" />

				<TextInput
					id="email"
					type="email"
					name="email"
					value={data.email}
					className="mt-1 block w-full"
					isFocused={true}
					onChange={(e) => setData("email", e.target.value)}
				/>

				<InputError message={errors.email} className="mt-2" />

				<PrimaryButton className="mt-6" disabled={processing}>
					Send reset link
				</PrimaryButton>
			</form>
		</UnauthorizedLayout>
	);
}
