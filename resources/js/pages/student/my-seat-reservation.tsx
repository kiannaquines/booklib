import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { SeatReservation } from '../modules/seat-reservation';
import { getSeatReservation } from '@/pages/student/columns/seat-columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Seat Reservation',
        href: route('student.mySeatReservation'),
    },
];

type MySeatReservationProps = {
    mySeatReservations: SeatReservation[];
}


export default function MySeatReservation({ mySeatReservations }: MySeatReservationProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="My Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <DataTable
                        data={mySeatReservations}
                        columns={getSeatReservation()}
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
