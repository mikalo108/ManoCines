import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function IndexForAFilm(props) {
    const user = usePage().props.auth.user;

    const Layout = (() => {
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
                <Head title={"Films " + props.cinema.name} />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <BlueButton link={"times.film"} params={[[cinema, cinema.id],[film, film.id]]}>{props.lang.back}</BlueButton>
                        <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.titleClient}</h1>
                        <h2 className='flex justify-center mb-8'>{props.langTable.subtitleClient}</h2>
                        <h3 className='flex justify-center mb-12'>{props.langTable.infoYouCanDo}</h3>
                        <main className="mt-6 flex flex-col lg:flex-row gap-8">
                           
                        </main>
                    </div>
                </div>
            </Layout>
        );
    } else if (props.auth.user.role === 'Admin') {
        router.get(route('chairs.index'));
        return null;
    }
}
