import { Head, Link } from '@inertiajs/react';

export default function Welcome({ auth }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="min-h-screen bg-indigo-50 flex flex-col justify-center items-center p-6 text-center">
                
                {/* Hero Icon/Emoji */}
                <div className="text-8xl mb-6 shadow-sm">
                    🐶
                </div>

                <h1 className="text-5xl font-extrabold text-indigo-600 mb-6 tracking-tight">
                    Kids Routine Tracker
                </h1>
                
                <p className="text-xl text-gray-700 mb-10 max-w-2xl leading-relaxed">
                    A fun, interactive app that helps parents establish morning and evening routines for infants and toddlers. Complete daily habits to unlock cute animal badges!
                </p>
                
                <div className="flex gap-4">
                    {auth.user ? (
                        <Link 
                            href={route('tracker.index')} 
                            className="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105"
                        >
                            Go to Dashboard
                        </Link>
                    ) : (
                        <>
                            <Link 
                                href={route('login')} 
                                className="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105"
                            >
                                Log In
                            </Link>
                            <Link 
                                href={route('register')} 
                                className="bg-white text-indigo-600 hover:bg-indigo-50 border-2 border-indigo-100 font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </>
    );
}