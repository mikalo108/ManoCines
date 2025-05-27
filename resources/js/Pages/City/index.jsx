import React from 'react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, Link } from '@inertiajs/react';
import TableIndex from '@/Components/TableIndex';

export default function Index(props) {
    const keyCities="cities";

    if (!props.auth.user.role=== 'admin') {
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
        } else if (props.auth.user.role=== 'admin') {
            return (
                <AdminLayout
                    locale={props.locale} 
                    auth={props.auth} 
                    lang={props.lang}
                >
                <Head title="Index - Cities" />
                <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                        <Link
                            className= "px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            href={route("home")}
                        >
                            Ir atrás
                        </Link>
                        <main className="mt-6">
                            <h1 className='flex justify-center text-black' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.title}</h1>
                            <h2 className='mb-12'>{props.langTable.subtitle}</h2>
                            <TableIndex columnsTable={props.langTable.columns} items={props.cities.data} keyTable={keyCities} />
                        </main>
                    </div>
                </div>
                </AdminLayout>
            );
        }
}
