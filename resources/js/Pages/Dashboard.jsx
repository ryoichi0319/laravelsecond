import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Dashboard({ auth }) {
   const trial = auth.user.trial_ends_at
    return (
        <AuthenticatedLayout
            user={auth.user.name}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            <Head title="Dashboard" />
            <div className="py-12">
            {console.log(auth.user)}

                
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">You're logged in!</div>
                        {trial && (<p>無料期間です</p>)}


                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
