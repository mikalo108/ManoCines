import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';
import { useEffect } from 'react';
import ChairIcon from '@/components/ChairIcon';

export default function IndexForATime(props) {
    const user = usePage().props.auth.user;
    const [selectedChair, setSelectedChair] = useState(null);

    useEffect(() => {
            if (!user || user?.role === 'Admin') {
                router.get(route('orders.index'));
            }
        }, [user]);

    const Layout = (() => {
        if (user && user.role === 'Admin') {
            return AdminLayout;
        } else if (user) {
            return AuthenticatedLayout;
        } else {
            return GuestLayout;
        }
    })();

    // Get max row and max column from chairs
    const maxRow = props.chairs.reduce((max, chair) => Math.max(max, parseInt(chair.row, 10)), 0);
    const maxColumn = props.chairs.reduce((max, chair) => {
        const colCode = chair.column.charCodeAt(0);
        return Math.max(max, colCode);
    }, 0);

    // Helper to check if chair is selected
    const isSelected = (chair) => {
        return props.chairsSelected && props.chairsSelected.some(c => c.id === chair.id);
    };

    // Handle chair click
    const handleChairClick = (chair) => {
        const isSelected = props.chairsSelected && props.chairsSelected.some(c => c.id === chair.id);
        const isOccupied = chair.state === 'Occupied' && !isSelected;
        if (isOccupied) {
            // Do not allow selection of occupied chair unless it is already selected (to allow deselection)
            return;
        }
        if (isSelected) {
            // Remove chair from selection
            const newSelected = props.chairsSelected.filter(c => c.id !== chair.id);
            const formData = new FormData();
            formData.append('chairSelected', chair.id); // Send chair id for deselection
            newSelected.forEach(c => formData.append('chairsSelected[]', c.id));
            // Send updated selection to backend
            router.post(route('chairs.select', {
                cinema_id: props.cinema_id,
                time_id: props.time_id,
                room_id: props.room_id,
                film_id: props.film_id,
            }), formData);
            setSelectedChair(null);
        } else {
            setSelectedChair(chair);
            // Submit form with chairSelected and chairsSelected
            const formData = new FormData();
            formData.append('chairSelected', chair.id);
            if (props.chairsSelected) {
                props.chairsSelected.forEach(c => formData.append('chairsSelected[]', c.id));
            }
            router.post(route('chairs.select', {
                cinema_id: props.cinema_id,
                time_id: props.time_id,
                room_id: props.room_id,
                film_id: props.film_id,
            }), formData);
        }
    };

    // Generate rows and columns labels
    const rows = [];
    for (let i = 1; i <= maxRow; i++) {
        rows.push(i);
    }
    const columns = [];
    for (let i = 65; i <= maxColumn; i++) {
        columns.push(String.fromCharCode(i));
    }

    // Build chair map as 2D array for rendering
    const chairMap = rows.map(rowNum => {
        return columns.map(colLetter => {
            return props.chairs.find(chair => chair.row === rowNum.toString() && chair.column === colLetter);
        });
    });

    if (props.auth.user.role !== 'Admin') {
        return (
            <Layout
                currentPage={"chairs"}
                locale={props.locale}
                auth={props.auth}
                lang={props.lang}
            >
                <Head title={"Chairs for Time " + props.time_id} />
                <div className="relative flex min-h-screen flex-col selection:bg-[#FF2D20] selection:text-white">
                    <div className="relative w-full px-6 flex flex-col items-center">
                        <div className="flex justify-between mb-4" style={{width:'50%'}}>
                            <BlueButton link={"times.film"} params={[{ key: 'cinema', value: props.cinema_id }, { key: 'film', value: props.film_id }]}>{props.lang.back}</BlueButton>
                                {props.chairsSelected && props.chairsSelected.length > 0 && (
                                <>
                                    <button
                                        onClick={() => router.get(route('products.chairs', {
                                            cinema: props.cinema_id,
                                            film: props.film_id,
                                            room: props.room_id,
                                            time: props.time_id,
                                        }))}
                                        style={{
                                            backgroundColor: '#007bff',
                                            color: 'white',
                                            border: 'none',
                                            padding: '10px 20px',
                                            borderRadius: '4px',
                                            cursor: 'pointer',
                                            fontSize: '16px',
                                        }}
                                        >
                                        {props.langTable.proceedToProducts}
                                    </button>
                                </>
                             )}

                        </div>
                        <h1 className='text-black dark:text-white mt-8 font-bold' style={{fontWeight:'bolder', width:'100%', textAlign: 'center'}}>{props.langTable.titleClient}</h1>
                        <h2 className='mb-8' style={{textAlign: 'center'}}>{props.langTable.subtitleClient}</h2>
                        <h3 className='mb-12' style={{textAlign: 'center'}}>{props.langTable.infoYouCanDo}</h3>
                        <div className="flex flex-col xl:flex-row items-start gap-8 mt-6 mb-12 max-xl:items-center">
                            <div style={{display:'grid', gridTemplateRows:'3', gridTemplateColumns:'2'}} className="gap-2">
                                    <div style={{gridColumn:'1', gridRow:'1'}}>
                                        <ChairIcon occupied={true} selected={false} />
                                    </div>
                                    <div style={{gridColumn:'2', gridRow:'1'}}>
                                        {props.langTable.occupied}
                                    </div>
                                    <div style={{gridColumn:'1', gridRow:'2'}}>
                                        <ChairIcon occupied={false} selected={true} />
                                    </div>
                                    <div style={{gridColumn:'2', gridRow:'2'}}>
                                        {props.langTable.selected}
                                    </div>
                                    <div style={{gridColumn:'1', gridRow:'3'}}>
                                        <ChairIcon occupied={false} selected={false} />
                                    </div>
                                    <div style={{gridColumn:'2', gridRow:'3'}}>
                                        {props.langTable.available}
                                    </div>
                                    <div style={{gridColumn:'1', gridRow:'4', alignContent:'center', justifyContent:'center', display:'flex', paddingTop:'4px', cursor:'pointer'}}>
                                        <img src="/storage/general/trash-solid.svg" alt="Trash icon" className="w-5 h-5" />
                                    </div>
                                    <div style={{gridColumn:'2', gridRow:'4'}}>
                                        {props.langTable.clearAllChairs}
                                    </div>
                            </div>
                            <div className="border rounded p-4 overflow-auto" style={{ maxWidth: '600px', maxHeight: '600px' }}>
                                <table className="border-collapse border border-gray-300 w-full text-center">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            {columns.map(col => (
                                                <th key={col} className="border border-gray-300 px-2">{col}</th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {rows.map((rowNum, idx) => (
                                            <tr key={rowNum}>
                                                <td className="border border-gray-300 px-2 font-semibold">{rowNum}</td>
                                                {chairMap[idx].map((chair, cidx) => {
                                                    if (!chair) {
                                                        return <td key={cidx} className="border border-gray-300 px-2"></td>;
                                                    }
                                                    const isOccupied = chair.state === 'Occupied';
                                                    const selected = isSelected(chair);
                                                    return (
                                                        <td
                                                            key={chair.id}
                                                            className={`border border-gray-300 p-0 cursor-pointer ${selected ? 'ring-4 ring-blue-500' : ''}`}
                                                            onClick={() => !isOccupied && handleChairClick(chair)}
                                                            title={`Row ${chair.row} Column ${chair.column} - ${chair.state}`}
                                                            style={{ width: '40px', height: '40px', margin: 0 }}
                                                        >
                                                            <ChairIcon occupied={isOccupied} selected={selected} />
                                                        </td>
                                                    );
                                                })}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                <div className="mt-2 text-center font-bold">{props.lang.screen}</div>
                            </div>
                            <div className="w-64 border rounded p-4 overflow-auto">
                                <div className='flex flex-column gap-8 mb-8'>
                                    <h2 className="font-semibold mb-2">{props.lang.selectedChairs}</h2>
                                    <img
                                        src="/storage/general/trash-solid.svg"
                                        alt="Remove all"
                                        className="cursor-pointer w-4 h-4"
                                        onClick={() => {
                                            const formData = new FormData();
                                            formData.append('chairSelected', ''); // empty to clear all
                                            router.post(route('chairs.select', {
                                                cinema_id: props.cinema_id,
                                                time_id: props.time_id,
                                                room_id: props.room_id,
                                                film_id: props.film_id,
                                            }), formData);
                                        }}
                                    />
                                </div>
                                
                            {props.chairsSelected && props.chairsSelected.length > 0 ? (
                                <ul className="list-disc list-inside">
                                    {props.chairsSelected.map((chair, index) => (
                                        <li key={chair.id ?? index} className="flex items-center justify-between">
                                            <span>{props.langTable.columns.row} {chair.row} - {props.langTable.columns.column} {chair.column}</span>
                                            <img
                                                src="/storage/general/trash-solid.svg"
                                                alt="Remove"
                                                className="cursor-pointer w-4 h-4"
                                                onClick={() => {
                                                    // Call API to deselect chair
                                                    const formData = new FormData();
                                                    formData.append('chairsSelected', chair.id);
                                                    router.post(route('chairs.select', {
                                                        cinema_id: props.cinema_id,
                                                        time_id: props.time_id,
                                                        room_id: props.room_id,
                                                        film_id: props.film_id,
                                                    }), formData);
                                                }}
                                            />
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <p>{props.langTable.noChairsSelected}</p>
                            )}
                            </div>
                        </div>
                    </div>
                </div>
            </Layout>
        );
    } else {
        router.get(route('chairs.index'));
        return null;
    }
}
