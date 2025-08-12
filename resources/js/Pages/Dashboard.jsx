import TasksView from '@/Components/Task/TasksView';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { Divider } from 'primereact/divider';

export default function Dashboard() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Mis tareas
                </h2>
            }
        >
            <Head title="Mis tareas" />

            <div className='pt-2'>
                <div className=" mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-2xl">
                        <div className="p-6 text-gray-900">
                            <div className=''>
                                <Divider />

                                <TasksView />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
