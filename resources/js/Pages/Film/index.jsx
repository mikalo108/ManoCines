import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, router } from '@inertiajs/react';
import TableIndex from '@/Components/TableIndex';
import FilterForm from '@/components/FilterForm';

export default function Index(props) {
    const keyFilms = "films";

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

    if (!props.auth.user.role === 'admin') {
        return (
            <AdminLayout
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <div>
                    <h1>Access Denied</h1>
                    <p>You do not have permission to view this page.</p>
                </div>
            </AdminLayout>
        );
    } else if (props.auth.user.role === 'admin') {
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
                            <h1 className='flex justify-center text-black' style={{ fontWeight: 'bolder', width: '100%' }}>{props.langTable.title}</h1>
                            <h2 className='mb-12'>{props.langTable.subtitle}</h2>
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
