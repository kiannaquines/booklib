import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Book Reservation',
        href: route('student.myBookReservation'),
    },
];


export default function MyBookReservation() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="My Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <DataTable
                        data={[]}
                        columns={[]}
                        filterColumn={""}
                        filterPlaceholder='Search something'
                        tableTitle='My Book Reservations'
                        tableDescription='List of my book reservations'
                        displayAddButton={false}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
