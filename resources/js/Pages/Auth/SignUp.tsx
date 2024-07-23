import { useEffect, FormEventHandler } from "react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import { UnauthorizedLayout } from "@/Layouts/UnauthorizedLayout";
import { GoogleIcon } from "@/Components/Icons/GoogleIcon";
import { Divider } from "@/Components/Divider/Divider";

export default function Register() {
	const { data, setData, post, processing, errors, reset } = useForm({
		name: "",
		email: "",
		password: "",
		password_confirmation: "",
	});

	useEffect(() => {
		return () => {
			reset("password", "password_confirmation");
		};
	}, []);

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route("register"));
	};

	return (
		<UnauthorizedLayout
			title="Create a new account"
			description="Already have an account?"
			desciptionLink={{
				href: "/sign-in",
				text: "Sign in",
			}}
		>
			<Head title="Sign up" />

			<a
				href="#"
				className="inline-flex w-full items-center justify-center space-x-2 rounded-md border border-gray-200 bg-white py-2 text-gray-900 shadow-sm hover:bg-gray-50 mb-8"
			>
				<GoogleIcon />

				<span className="font-medium text-sm">Sign up with Google</span>
			</a>

			<Divider className="mb-6" />

			<form onSubmit={submit}>
				<div>
					<InputLabel htmlFor="name" value="Name" />

					<TextInput
						id="name"
						name="name"
						value={data.name}
						className="mt-1 block w-full"
						autoComplete="name"
						isFocused={true}
						onChange={(e) => setData("name", e.target.value)}
						required
					/>

					<InputError message={errors.name} className="mt-2" />
				</div>

				<div className="mt-4">
					<InputLabel htmlFor="email" value="Email" />

					<TextInput
						id="email"
						type="email"
						name="email"
						value={data.email}
						className="mt-1 block w-full"
						autoComplete="username"
						onChange={(e) => setData("email", e.target.value)}
						required
					/>

					<InputError message={errors.email} className="mt-2" />
				</div>

				<div className="mt-4">
					<InputLabel htmlFor="password" value="Password" />

					<TextInput
						id="password"
						type="password"
						name="password"
						value={data.password}
						className="mt-1 block w-full"
						autoComplete="new-password"
						onChange={(e) => setData("password", e.target.value)}
						required
					/>

					<InputError message={errors.password} className="mt-2" />
				</div>

				<div className="mt-4">
					<InputLabel
						htmlFor="password_confirmation"
						value="Confirm Password"
					/>

					<TextInput
						id="password_confirmation"
						type="password"
						name="password_confirmation"
						value={data.password_confirmation}
						className="mt-1 block w-full"
						autoComplete="new-password"
						onChange={(e) =>
							setData("password_confirmation", e.target.value)
						}
						required
					/>

					<InputError
						message={errors.password_confirmation}
						className="mt-2"
					/>
				</div>

				<PrimaryButton className="mt-6" disabled={processing}>
					Sign up
				</PrimaryButton>
			</form>
		</UnauthorizedLayout>
	);
}
