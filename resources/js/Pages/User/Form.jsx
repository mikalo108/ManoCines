import React from 'react';
import FormGenerate from '@/components/FormGenerate';
import AdminLayout from '@/Layouts/AdminLayout';
import BlueButton from '@/components/BlueButton';
import { Head } from '@inertiajs/react';

export default function Form(props) {
    const keyElements = 'users';
    const keyElement = 'user';
    const nameTableES = 'Usuarios';
    const nameElementES = 'usuario';
    const generoES = 'masculino'; // femenino o masculino

    /* Común a partir de aquí */

    const nameTable = props.locale==='en' ? `${keyElements}`.charAt(0).toUpperCase() + `${keyElements}`.slice(1) : nameTableES;
    const newElementLang = props.locale==='en' ? props.lang.newElem : generoES==='femenino' ? props.lang.newElem.slice(0,-1)+"a" : props.lang.newElem;

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
                </AdminLayout>
            );
    }
}
