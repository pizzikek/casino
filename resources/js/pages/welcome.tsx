import { Head } from '@inertiajs/react';

export default function Welcome() {
    return (
        <>
            <Head title="Welcome" />
            <div className="flex h-screen items-center justify-center">
                <div className="place-items-center rounded-[4rem] border-2 bg-gray-950">
                    <div className="place-items-center p-12 text-white">
                        <h1 className="font-bold pb-2">Welcome</h1>
                        <h2>This is my non-money-casino</h2>
                        <h2>to continue please</h2>
                        <br />
                        <div>
                            <a
                                href="/login"
                                className="font-semibold text-indigo-400 hover:text-indigo-300"
                            >
                                login
                            </a>
                            <span> or </span>
                            <a
                                href="/register"
                                className="font-semibold text-indigo-400 hover:text-indigo-300"
                            >
                                sign up
                            </a>
                        </div>
                        <br/>
                        <p>this site does not condone gambling</p>{' '}
                        <p>it is for entertainment purposes only</p>{' '}
                        <p>and does not give you the</p>{' '}
                        <p>ability to lose or win money</p>
                    </div>
                </div>
            </div>
        </>
    );
}
