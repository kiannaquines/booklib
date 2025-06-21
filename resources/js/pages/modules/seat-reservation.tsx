import * as React from 'react';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getSeatReservation } from './columns/seat-reservation-columns';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Seat Reservation',
        href: route('seat-reservations.index'),
    },
];

export type SeatReservation = {
    id: string
    seat: string
    user: string
    created_at: string
    updated_at: string
}

type SeatReservationProps = {
    seatReservations: SeatReservation[]
}

const SeatReservation = ({ seatReservations }: SeatReservationProps) => {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title='Seat Reservation' />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <DataTable
                        tableTitle='Seat Reservations'
                        filterColumn='user'
                        filterPlaceholder='Search by name'
                        tableDescription='Seat Reservation list'
                        addButtonName='Add New Seat Reservation'
                        data={seatReservations} columns={getSeatReservation()}
                        route={route('seat-reservations.create')}
                    />
                </div>
            </div>
        </AppLayout>
    )
}

export default SeatReservation
