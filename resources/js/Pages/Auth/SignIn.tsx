import { useEffect, FormEventHandler } from "react";
import Checkbox from "@/Components/Checkbox";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import { UnauthorizedLayout } from "@/Layouts/UnauthorizedLayout";
import { Divider } from "@/Components/Divider/Divider";
import { GoogleIcon } from "@/Components/Icons/GoogleIcon";

export default function Login({
	canResetPassword,
}: {
	canResetPassword: boolean;
}) {
	const { data, setData, post, processing, errors, reset } = useForm({
		email: "",
		password: "",
		remember: false,
	});

	useEffect(() => {
		return () => {
			reset("password");
		};
	}, []);

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route("login"));
	};

	return (
		<UnauthorizedLayout
			title="Sign in to your account"
			description="Don't have an account?"
			desciptionLink={{
				href: "/sign-up",
				text: "Sign up",
			}}
		>
			<Head title="Sign in" />

			<a
				href="#"
				className="inline-flex w-full items-center justify-center space-x-2 rounded-md border border-gray-200 bg-white py-2 text-gray-900 shadow-sm hover:bg-gray-50 mb-8"
			>
				<GoogleIcon />

				<span className="font-medium text-sm">Sign in with Google</span>
			</a>

			<Divider className="mb-6" />

			<form onSubmit={submit}>
				<div>
					<InputLabel htmlFor="email" value="Email" />

					<TextInput
						id="email"
						type="email"
						name="email"
						value={data.email}
						className="mt-1 block w-full"
						autoComplete="username"
						isFocused={true}
						onChange={(e) => setData("email", e.target.value)}
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
						autoComplete="current-password"
						onChange={(e) => setData("password", e.target.value)}
					/>

					<InputError message={errors.password} className="mt-2" />
				</div>

				<div className="block mt-4">
					<label className="flex items-center">
						<Checkbox
							name="remember"
							checked={data.remember}
							onChange={(e) =>
								setData("remember", e.target.checked)
							}
						/>
						<span className="ms-2 text-sm text-gray-600">
							Remember me
						</span>
					</label>
				</div>

				<div className="flex flex-col mt-4">
					<PrimaryButton className="mb-4" disabled={processing}>
						Sign in
					</PrimaryButton>

					{canResetPassword && (
						<p className="text-sm text-gray-600 mb-2">
							Forgot your password?{" "}
							<Link
								href={route("password.request")}
								className="text-emerald-700 font-medium hover:text-emerald-800"
							>
								Reset password
							</Link>
						</p>
					)}
				</div>
			</form>
		</UnauthorizedLayout>
	);
}
