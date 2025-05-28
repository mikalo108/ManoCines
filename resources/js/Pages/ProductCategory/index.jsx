import React, { useState } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, router } from '@inertiajs/react';
import TableIndex from '@/components/TableIndex';
import FilterForm from '@/components/FilterForm';
import BlueButton from '@/components/BlueButton';

export default function Index(props) {
    const keyProductCategories = "product-categories";

    // State to hold current filters
        const [filters, setFilters] = useState({});
    
        // Handle page change with current filters
        const handlePageChange = (page) => {
            router.get(route('product-categories.index'), { page, ...filters }, { preserveState: true, replace: true });
        };
    
        // Handle filter submission
        const handleFilter = (newFilters) => {
            setFilters(newFilters);
            // Reset to page 1 when filters change
            router.get(route('product-categories.index'), { page: 1, ...newFilters }, { preserveState: true, replace: true });
        };

    if (props.auth.user.role !== 'admin') {
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
            <Head title="Index - Product Categories" />
            <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <main className="mt-6">
                        <BlueButton link={"home"}>{props.lang.back}</BlueButton>
                        <h1 className='flex justify-center text-black' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.title}</h1>
                        <h2 className='mb-12'>{props.langTable.subtitle}</h2>
                        <FilterForm fieldsCanFilter={props.fieldsCanFilter} onFilter={handleFilter} lang={props.lang} />
                        <TableIndex 
                            columnsTable={props.langTable.columns} 
                            items={props.productCategories.data} 
                            keyTable={keyProductCategories} 
                            pagination={props.productCategories} 
                            onPageChange={handlePageChange} 
                        />
                    </main>
                </div>
            </div>
                    
            </AdminLayout>
        );
    }
}
