import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import TableIndex from '@/components/TableIndex';
import FilterForm from '@/components/FilterForm';
import BlueButton from '@/components/BlueButton';

export default function Index(props) {
    const keyCinemas = "cinemas";
    const user = usePage().props.auth.user;

    // State to hold current filters
        const [filters, setFilters] = useState({});
    
        // Handle page change with current filters
        const handlePageChange = (page) => {
            router.get(route('cinemas.index'), { page, ...filters }, { preserveState: true, replace: true });
        };
    
        // Handle filter submission
        const handleFilter = (newFilters) => {
            setFilters(newFilters);
            // Reset to page 1 when filters change
            router.get(route('cinemas.index'), { page: 1, ...newFilters }, { preserveState: true, replace: true });
        };
    
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
            currentPage={"cinemas"}
            locale={props.locale} 
            auth={props.auth} 
            lang={props.lang}
            >
            <Head title="Cinemas" />
            <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <main className="mt-6">
                    <BlueButton link={"home"}>{props.lang.back}</BlueButton>
                    <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.titleClient}</h1>
                    <h2 className='flex justify-center mb-8'>{props.langTable.subtitleClient}</h2>
                    <h3 className='flex justify-center mb-12'>{props.langTable.infoYouCanDo}</h3>
                    <form
                        method="GET"
                        onSubmit={e => {
                            e.preventDefault();
                            router.get(route('cinemas.index'), {
                            ...filters,
                            cinemaCityId: e.target.elements.cinemaCityId.value,
                            }, { preserveState: true, replace: true });
                        }}
                        className="flex flex-col items-center mb-8"
                    >
                        <label htmlFor="cinemaCityId" className="mb-2 font-semibold">
                            {props.langTable.selectCity}
                        </label>
                        <select
                            id="cinemaCityId"
                            name="cinemaCityId"
                            defaultValue={props.fieldsCanFilter[2].field || ""}
                            className="border rounded px-3 py-2 mb-4"
                            onChange={e => {
                            router.get(route('cinemas.index'), {
                                ...filters,
                                cinemaCityId: e.target.value,
                            }, { preserveState: true, replace: true });
                            }}
                        >
                            <option value="">{props.langTable.chooseCity}</option>
                            {props.citiesAvailable.map(city => (
                            <option key={city} value={city}>
                                {city}
                            </option>
                            ))}
                        </select>
                    </form>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        {props.cinemas.data.map((cinema) => (
                            <div
                                key={cinema.id}
                                className="border rounded-2xl p-8 flex flex-col items-start shadow-sm bg-white"
                                style={{ minWidth: 280, maxWidth: 350 }}
                            >
                                <h2 className="text-4xl font-bold mb-2 text-black">{cinema.name}</h2>
                                <a
                                    href={`https://maps.google.com/?q=${encodeURIComponent(cinema.address)}`}
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="text-2xl text-gray-500 underline underline-offset-4 mb-6"
                                    style={{ fontWeight: 400 }}
                                >
                                    {cinema.address}
                                </a>
                                <button
                                    className="mt-2 px-8 py-4 rounded-2xl border text-2xl bg-gray-200 text-black hover:bg-gray-300 transition"
                                    onClick={() => router.get(route('films.cinema', cinema.id))}
                                >
                                    Go
                                </button>
                            </div>
                        ))}
                    </div>
                </main>
                </div>
            </div>
            </Layout>
        );
    } else if (props.auth.user.role === 'Admin') {
        return (
            <AdminLayout
                locale={props.locale} 
                auth={props.auth} 
                lang={props.lang}
            >
            <Head title="Index - Cinemas" />
            <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <main className="mt-6">
                        <BlueButton link={"home"}>{props.lang.back}</BlueButton>
                        <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.title}</h1>
                        <h2 className='flex justify-center mb-12'>{props.langTable.subtitle}</h2>
                        <FilterForm fieldsCanFilter={props.fieldsCanFilter} onFilter={handleFilter} lang={props.lang} />
                        <TableIndex 
                            columnsTable={props.langTable.columns} 
                            items={props.cinemas.data} 
                            keyTable={keyCinemas} 
                            pagination={props.cinemas} 
                            onPageChange={handlePageChange} 
                        />
                    </main>
                </div>
            </div>
                    
            </AdminLayout>
        );
    }
}
