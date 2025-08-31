import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import TableIndex from '@/components/TableIndex';
import FilterForm from '@/components/FilterForm';
import BlueButton from '@/components/BlueButton';

export default function Index(props) {
    const keyFilms = "films";
    const user = usePage().props.auth.user;
    props = usePage().props;

    // State to hold current filters
        const [filters, setFilters] = useState({});
    
    // Handle page change with current filters
    const handlePageChange = (page) => {
        router.get(route('films.index'), { page, ...filters }, { preserveState: true, replace: true });
    };

    // Handle filter submission
    const handleFilter = (newFilters) => {
        setFilters(newFilters);
        // Reset to page 1 when filters change
        router.get(route('films.index'), { page: 1, ...newFilters }, { preserveState: true, replace: true });
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
                currentPage={"films"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Films"} />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <main className="mt-6">
                            <BlueButton link={"home"}>{props.lang.back}</BlueButton>
                            <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.titleClient}</h1>
                            <h3 className='flex justify-center mb-12'>{props.langTable.onlyReadFilms}</h3>
                            <div className="flex flex-wrap justify-center gap-8">
                                <TableIndex
                                    columnsTable={props.langTable.columns}
                                    items={props.films.data}
                                    keyTable={keyFilms}
                                    pagination={props.films}
                                    onPageChange={handlePageChange}
                                    props={props}
                                />
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
                <Head title="Index - Films" />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <main className="mt-6">
                            <BlueButton link={"home"}>{props.lang.back}</BlueButton>
                            <h1 className='flex justify-center text-black dark:text-white mt-8' style={{ fontWeight: 'bolder', width: '100%' }}>{props.langTable.title}</h1>
                            <h2 className='flex justify-center mb-12'>{props.langTable.subtitle}</h2>
                            <FilterForm fieldsCanFilter={props.fieldsCanFilter} onFilter={handleFilter} lang={props.lang} />
                            <TableIndex
                                columnsTable={props.langTable.columns}
                                items={props.films.data}
                                keyTable={keyFilms}
                                pagination={props.films}
                                onPageChange={handlePageChange}
                            />
                        </main>
                    </div>
                </div>
            </AdminLayout>
        );
    }
}
