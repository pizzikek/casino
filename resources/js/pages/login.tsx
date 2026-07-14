import { Head, useForm } from '@inertiajs/react';

import Button from '../components/forms/button'
import InputLabel from '../components/forms/input-label'


export default function Example() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
    });


    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/login');
    };


    return (
        <>
            <Head title="Log In" />
            <div className="grid min-h-full place-content-center px-6 py-12 lg:px-8">
                <div className="flex max-w-max flex-col rounded-3xl border-2 bg-gray-950 p-12">
                    <div className="sm:mx-auto sm:w-full sm:max-w-sm">
                        <img
                            alt="Your Company"
                            src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                            className="mx-auto h-10 w-auto"
                        />
                        <h2 className="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">
                            Sign in to your account
                        </h2>
                    </div>

                    <div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                        <form onSubmit={handleSubmit} className="space-y-6">
                            <InputLabel
                                label="Email Address"
                                name="email"
                                type="email"
                                id="email"
                                value={data.email}
                                onChange={(e) =>
                                    setData('email', e.target.value)
                                }
                            />
                            {errors.email && (
                                <div className="error">{errors.email}</div>
                            )}

                            <InputLabel
                                label="Password"
                                name="password"
                                type="password"
                                id="password"
                                value={data.password}
                                onChange={(e) =>
                                    setData('password', e.target.value)
                                }
                            />
                            {errors.password && (
                                <div className="error">{errors.password}</div>
                            )}

                            <Button label="Sign in" disabled={processing} />
                        </form>

                        <p className="mt-10 text-center text-sm/6 text-gray-400">
                            Dont have an Account?{' '}
                            <a
                                href="/register"
                                className="font-semibold text-indigo-400 hover:text-indigo-300"
                            >
                                Sign up
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </>
    );
}
