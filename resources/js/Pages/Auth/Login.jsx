import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Login(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const user = usePage().props.auth.user;

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    useEffect(() => {
        document.documentElement.lang = props.locale || 'en';
    }, [props.locale]);

    if(user) {
        redirect(route('dashboard'));
    }

    return (
        <GuestLayout 
            locale={props.locale} 
            auth={props.auth}
            lang={props.lang}
        >
            <Head title="Log in" />

            {props.status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {props.status}
                </div>
            )}

            <form onSubmit={submit} style={{ marginInline: '35%' }}>
                <div>
                    <InputLabel htmlFor="email" value="Email" className='dark:text-gray-200'/>

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full dark:bg-gray-800 dark:text-gray-200"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" className='dark:text-gray-200' />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full dark:bg-gray-800 dark:text-gray-200"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4 block">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                        />
                        <span className="ms-2 text-sm text-gray-600">
                            Remember me
                        </span>
                    </label>
                </div>

                <div className="mt-4 flex items-center justify-end">
                    {props.canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            {props.lang.forgot_password}
                        </Link>
                    )}

                    <PrimaryButton className="ms-4" disabled={processing}>
                        {props.lang.login}
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
