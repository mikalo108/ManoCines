import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function IndexForACinema(props) {
    const user = usePage().props.auth.user;

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

    if (props.auth.user.role !== 'Admin') {
        return (
            <Layout
                currentPage={"films"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Films "+props.cinema.name} />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <main className="mt-6">
                            <BlueButton link={"cinemas.index"}>{props.lang.back}</BlueButton>
                            <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.titleClient}</h1>
                            <h2 className='flex justify-center mb-8'>{props.langTable.subtitleClient}</h2>
                            <h3 className='flex justify-center mb-12'>{props.langTable.infoYouCanDo}</h3>
                            <div className="flex flex-wrap justify-center gap-8">
                                {props.films ? (
                                    props.films.map((film) => (
                                    <div key={film.id} className="bg-white rounded-lg shadow-lg p-4 flex flex-col items-center w-80 cursor-pointer group" onClick={() => router.visit(route('times.films', { cinema: props.cinema.id, film: film.id }))}>
                                        <img
                                            src={"/storage/films/"+film.image}
                                            alt={film.name}
                                            className="w-60 h-96 object-cover rounded-xl shadow-md mb-4 group-hover:opacity-80 transition-opacity duration-300"
                                        />
                                        <h2 className="text-2xl font-bold text-center mb-2">{film.name}</h2>
                                        {film.overview && (
                                            <h3 className="text-lg text-gray-600 text-center mb-2">{film.overview}</h3>
                                        )}
                                    </div>
                                    ))
                                ) : (
                                        <h2 className="text-2xl font-bold text-center mb-2">{props.langTable.noData}</h2>
                                )}
                                
                            </div>
                        </main>
                    </div>
                </div>
            </Layout>
        );
    } else if (props.auth.user.role === 'Admin') {
        router.get(route('films.index'));
        return null;
    }
}
