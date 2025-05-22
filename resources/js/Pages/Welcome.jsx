import { Head } from '@inertiajs/react';
import { useState } from 'react';
import GuestLayout from '../Layouts/GuestLayout';

export default function Welcome(props) {
    const [currentIndex, setCurrentIndex] = useState(0);

    const images = [
        "https://picsum.photos/200/300",
        "https://picsum.photos/201/300",
        "https://picsum.photos/202/300",
    ];

    const prevSlide = () => {
        setCurrentIndex((prevIndex) =>
            prevIndex === 0 ? images.length - 1 : prevIndex - 1
        );
    };

    const nextSlide = () => {
        setCurrentIndex((prevIndex) =>
            prevIndex === images.length - 1 ? 0 : prevIndex + 1
        );
    };

    return (
        <GuestLayout auth={props.auth} copyright={props.copyright}>
            <Head title="Welcome" />
                <div className="relative flex min-h-screen flex-col items-center  selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <main className="mt-6">
                            <h1 className='text-center text-3xl mb-10'>{props.bestsellers}</h1>
                            <div className="grid gap-6 lg:grid-cols-1 lg:gap-8 flex flex-col items-center justify-center">
                                <a
                                    id="carrousel-card"
                                    className="relative flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                                    style={{ padding: '0' }}
                                >
                                    <div
                                        id="screenshot-container"
                                        className="relative flex w-full flex-1 items-stretch justify-center"
                                    >
                                        <img
                                            src={images[currentIndex]}
                                            alt={`Slide ${currentIndex + 1}`}
                                            className="block w-full max-w-md rounded-lg object-cover object-center"
                                        />
                                        <button
                                            type="button"
                                            onClick={prevSlide}
                                            aria-label="Previous Slide"
                                            className="absolute top-0 left-0 h-full w-28 sm:w-32 md:w-36 bg-transparent p-2 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-zinc-600 transition"
                                        >
                                            <svg
                                                className="size-20 shrink-0 stroke-[#4a4242] dark:stroke-white"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                strokeWidth="3"
                                                style={{ transform: 'rotate(180deg)' }}
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            onClick={nextSlide}
                                            aria-label="Next Slide"
                                            className="absolute top-0 right-0 h-full w-28 sm:w-32 md:w-36 bg-transparent p-2 flex items-center justify-center hover:bg-gray-200 dark:hover:bg-zinc-600 transition"
                                        >
                                            <svg
                                                className="size-20 shrink-0 stroke-[#4a4242] dark:stroke-white"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                strokeWidth="3"
                                            >
                                                <path
                                                    strokeLinecap="round"
                                                    strokeLinejoin="round"
                                                    d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </a>
                            </div>
                        </main>

                        
                    </div>
                </div>
        </GuestLayout>
    );
}
