import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { BookReservation } from '../modules/book-reservation';
import { getBookReservationColumns } from '@/pages/student/columns/book-columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Book Reservation',
        href: route('student.myBookReservation'),
    },
];

type MyBookReservationProps = {
    myBookReservations: BookReservation[];
}


export default function MyBookReservation({ myBookReservations }: MyBookReservationProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="My Book Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <DataTable
                        data={myBookReservations}
                        columns={getBookReservationColumns(myBookReservations)}
                        filterColumn={"user"}
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
