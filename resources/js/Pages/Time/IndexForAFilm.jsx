import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminLayout from '@/Layouts/AdminLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, router, usePage } from '@inertiajs/react';
import BlueButton from '@/components/BlueButton';

export default function IndexForAFilm(props) {
    const user = usePage().props.auth.user;
    const [selectedDate, setSelectedDate] = useState(() => {
        if (props.timeDate) {
            return props.timeDate;
        } else {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            return tomorrow.toISOString().split('T')[0];
        }
    });

    const Layout = (() => {
        if (user && user.role === 'Admin') {
            return AdminLayout;
        } else if (user) {
            return AuthenticatedLayout;
        } else {
            return GuestLayout;
        }
    })();

    const handleDateChange = (e) => {
        const newDate = e.target.value;
        setSelectedDate(newDate);
        router.get(route('times.films', { cinema: props.cinema.id, film: props.film.id, timeDate: newDate }));
    };

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
                        <BlueButton link={"films.cinema"} params={props.cinema.id}>{props.lang.back}</BlueButton>
                        <h1 className='flex justify-center text-black dark:text-white mt-8' style={{fontWeight:'bolder', width:'100%'}}>{props.langTable.titleClient}</h1>
                        <h2 className='flex justify-center mb-8'>{props.langTable.subtitleClient}</h2>
                        <h3 className='flex justify-center mb-12'>{props.langTable.infoYouCanDo}</h3>
                        <main className="mt-6 flex flex-col lg:flex-row gap-8">
                            <div className="flex-1">
                                <iframe
                                    width="100%"
                                    height="400"
                                    src={props.film.trailer}
                                    title={props.film.name}
                                    frameBorder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowFullScreen
                                ></iframe>
                                <h1 className="text-3xl font-bold mt-6">{props.film.name}</h1>
                                <p className="mt-4 mb-8">{props.film.overview}</p>
                                {props.rooms.length > 0 ? (
                                    props.rooms.map((room) => {
                                        const timesForRoom = props.times.filter(time => time.room_id === room.id);
                                        return (
                                            <div key={room.id} className="mb-6">
                                                <h2 className="font-semibold mb-2">Room {room.number}</h2>
                                                <div className="grid grid-cols-3 gap-2">
                                                    {timesForRoom.map(time => {
                                                        const timeObj = new Date(time.time);
                                                        const hours = timeObj.getHours().toString().padStart(2, '0');
                                                        const minutes = timeObj.getMinutes().toString().padStart(2, '0');
                                                        return (
                                                        <div
                                                            key={time.id}
                                                            className="bg-gray-200 p-2 rounded text-center cursor-pointer hover:bg-gray-300"
                                                            onClick={() =>
                                                                router.visit(
                                                                    route('chairs.time', {
                                                                        cinema: props.cinema.id,
                                                                        film: props.film.id,
                                                                        time: time.id,
                                                                        room: time.room_id,
                                                                    })
                                                                )
                                                            }
                                                        >
                                                            {hours}:{minutes}
                                                        </div>
                                                        );
                                                    })}
                                                </div>
                                            </div>
                                        );
                                    })
                                ) : (
                                    <p>{props.langTable.noTimes}</p>
                                )}
                            </div>
                            <div className="w-64">
                                <label htmlFor="timeDate" className="block mb-2 font-semibold">{props.lang.selectDay}</label>
                                <input
                                    type="date"
                                    id="timeDate"
                                    name="timeDate"
                                    value={selectedDate}
                                    onChange={handleDateChange}
                                    className="border border-gray-300 rounded p-2 w-full"
                                />
                            </div>
                        </main>
                    </div>
                </div>
            </Layout>
        );
    } else if (props.auth.user.role === 'Admin') {
        router.get(route('times.index'));
        return null;
    }
}
