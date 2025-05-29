import { Head, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout.jsx';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.jsx';
import AdminLayout from '@/Layouts/AdminLayout.jsx';

export default function Welcome(props) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const user = usePage().props.auth.user;
    const films = props['allFilms'] || [];

    const tablesES = [
        { name: 'Ciudades', route: 'cities.index', key: 'cities' },
        { name: 'Cines', route: 'cinemas.index', key: 'cinemas' },
        { name: 'Salas', route: 'rooms.index', key: 'rooms' },
        { name: 'Butacas', route: 'chairs.index', key: 'chairs' },
        { name: 'Reservas Temporales', route: 'temporal-reserves.index', key: 'temporal-reserves' },
        { name: 'Películas', route: 'films.index', key: 'films' },
        { name: 'Horarios', route: 'times.index', key: 'times' },
        { name: 'Pedidos', route: 'orders.index', key: 'orders' },
        { name: 'Pedidos <-> Productos', route: 'order-products.index', key: 'order-products' },
        { name: 'Pedidos <-> Entradas', route: 'order-tickets.index', key: 'order-tickets' },
        { name: 'Productos', route: 'products.index', key: 'products' },
        { name: 'Categorias de Productos', route: 'product-categories.index', key: 'product-categories' },
        { name: 'Productos <-> Cines', route: 'product-cinemas.index', key: 'product-cinemas' },
        { name: 'Usuarios', route: 'users.index', key: 'users' },
        { name: 'Perfiles', route: 'profiles.index', key: 'profiles' },
    ];

    const tablesEN = [
        { name: 'Cities', route: 'cities.index', key: 'cities' },
        { name: 'Cinemas', route: 'cinemas.index', key: 'cinemas' },
        { name: 'Rooms', route: 'rooms.index', key: 'rooms' },
        { name: 'Chairs', route: 'chairs.index', key: 'chairs' },
        { name: 'Temporal Reserves', route: 'temporal-reserves.index', key: 'temporal-reserves' },
        { name: 'Films', route: 'films.index', key: 'films' },
        { name: 'Times', route: 'times.index', key: 'times' },
        { name: 'Orders', route: 'orders.index', key: 'orders' },
        { name: 'Orders <-> Products', route: 'order-products.index', key: 'order-products' },
        { name: 'Orders <-> Tickets', route: 'order-tickets.index', key: 'order-tickets' },
        { name: 'Products', route: 'products.index', key: 'products' },
        { name: 'Product Categories', route: 'product-categories.index', key: 'product-categories' },
        { name: 'Products <-> Cinemas', route: 'product-cinemas.index', key: 'product-cinemas' },
        { name: 'Users', route: 'users.index', key: 'users' },
        { name: 'Profiles', route: 'profiles.index', key: 'profiles' },
    ];

    const tables = props.locale === 'es' ? tablesES : tablesEN;

    const prevSlide = () => {
        setCurrentIndex((prevIndex) =>
            prevIndex === 0 ? films.length - 1 : prevIndex - 1
        );
    };

    const nextSlide = () => {
        setCurrentIndex((prevIndex) =>
            prevIndex === films.length - 1 ? 0 : prevIndex + 1
        );
    };

    useEffect(() => {
        document.documentElement.lang = props.locale || 'en';
    }, [props.locale]);

    const Layout = (() => {
        // Determine which layout to use based on user role
        if (user && user.role === 'Admin') {
            return AdminLayout;
        } else if (user) {
            return AuthenticatedLayout;
        } else {
            return GuestLayout;
        }
    })();

    if (user) {
        return (
            <Layout
            locale={props.locale} 
            auth={props.auth} 
            lang={props.lang}
            >
            <Head title="Welcome" />
            <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
            <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main className="mt-6">
                <div className="grid gap-6 lg:grid-cols-3 lg:gap-8 md:grid-cols-2 max-md:grid-cols-1 flex flex-col items-center justify-center">
                    {tables.map((table) => (
                    <div
                        key={table.key}
                        className="max-w-sm rounded-2xl shadow-lg bg-white p-6 dark:bg-neutral-900 border border-transparent dark:border-gray-300"
                        style={{ marginInline: '20%' }}
                    >
                        <h2 className="text-xl font-semibold text-gray-900 dark:text-white">{table.name}</h2>
                        <a 
                        href={route(table.route)}
                        className="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors inline-block"
                        >
                        {props.lang.goto}
                        </a>
                    </div>
                    ))}
                </div>
                </main>
            </div>
            </div>
            </Layout>
        );
    } else {
        return (
            <Layout 
                locale={props.locale} 
                auth={props.auth} 
                lang={props.lang} 
            >
                <Head title="Welcome" />
                <div className="relative flex min-h-screen flex-col items-center  selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <main className="mt-6">
                            <h1 className='text-center text-3xl mb-10'>{props.lang.last10Movies}</h1>
                            <div className="grid gap-6 grid-cols-1 lg:gap-8 flex flex-col items-center justify-center">
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
                                            src={'storage/films/' + films[currentIndex]?.image}
                                            alt={`Slide ${currentIndex + 1}`}
                                            className="block w-full max-w-md rounded-lg object-cover object-center"
                                        />
                                        <button
                                            type="button"
                                            onClick={prevSlide}
                                            style={{ '--tw-bg-opacity': '0.4' }}
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
                                            style={{ '--tw-bg-opacity': '0.4' }}
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
            </Layout>
        );
    }
}
