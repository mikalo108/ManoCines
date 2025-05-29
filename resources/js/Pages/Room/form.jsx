import React from 'react';
import FormGenerate from '@/components/FormGenerate';
import BlueButton from '@/components/BlueButton';
import { Head, usePage } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';

export default function Form(props) {
    const keyElements = 'rooms';
    const keyElement = 'room';
    const nameTableES = 'Salas';
    const nameElementES = 'sala';
    const generoES = 'femenino'; // femenino o masculino

    /* Común a partir de aquí */

    const nameTable = props.locale==='en' ? `${keyElements}`.charAt(0).toUpperCase() + `${keyElements}`.slice(1) : nameTableES;
    const newElementLang = props.locale==='en' ? props.lang.newElem : generoES==='femenino' ? props.lang.newElem.slice(0,-1)+"a" : props.lang.newElem;

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
        
    if (user.role !== 'Admin') {
            return (
                <Layout
                    locale={props.locale} 
                    auth={props.auth} 
                    lang={props.lang}
                >
                    <div>
                        <h1>Access Denied</h1>
                        <p>You do not have permission to view this page.</p>
                    </div>
                </Layout>
            );
    } else if (user.role === 'Admin') {
            return (
                <Layout
                    locale={props.locale} 
                    auth={props.auth} 
                    lang={props.lang}
                >
                    <Head title={props[keyElement] ? props.lang.newElem+" - "+nameTable : props.lang.editElem+" - "+nameTable } />
                    <div className="relative flex min-h-screen flex-col items-center selection:bg-[#FF2D20] selection:text-white">
                        <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                            <main className="mt-6">
                                <BlueButton link={`${keyElements}`+".index"}>{props.lang.back}</BlueButton>
                                <h1 className='flex justify-center mt-8 text-black dark:text-white' style={{fontWeight:'bolder', width:'100%'}}>{props[keyElement] ? props.lang.editElem : props.lang.newElem}</h1>
                                <h2 className='flex justify-center mb-12'>{props[keyElement] ? props.lang.editElem : newElementLang} {props.locale==='en' ? keyElement : nameElementES} {props[keyElement] ? 'ID nº'+props[keyElement].id : ''}</h2>
                                <FormGenerate element={props[keyElement] ? props[keyElement] : null} dataControl={props.dataControl} keyElements={keyElements} lang={props.lang} />
                            </main>
                        </div>
                    </div>
                </Layout>
            );
    }
}
