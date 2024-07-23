import PrimaryButton from "@/Components/PrimaryButton";
import { Head, Link, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";
import { UnauthorizedLayout } from "@/Layouts/UnauthorizedLayout";

export default function VerifyEmail({ status }: { status?: string }) {
	const { post, processing } = useForm({});

	const submit: FormEventHandler = (e) => {
		e.preventDefault();

		post(route("verification.send"));
	};

	return (
		<UnauthorizedLayout
			title="Email verification"
			description="Verify your email address"
		>
			<Head title="Email verification" />

			{status === "verification-link-sent" && (
				<div className="mb-4 font-medium text-sm text-green-600">
					A new verification link has been sent to the email address
					you provided during registration.
				</div>
			)}

			<form onSubmit={submit}>
				<div className="mt-4 flex items-center justify-between">
					<PrimaryButton disabled={processing}>
						Resend verification email
					</PrimaryButton>

					<Link
						href={route("logout")}
						method="post"
						as="button"
						className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
					>
						Logout
					</Link>
				</div>
			</form>
		</UnauthorizedLayout>
	);
}
