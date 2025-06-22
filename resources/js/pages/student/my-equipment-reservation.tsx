import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getEquipmentReservationColumns } from '@/pages/student/columns/equipment-columns';
import { EquipmentReservation } from '../modules/equipment-reservation';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Equipment Reservation',
        href: route('student.myEquipmentReservation'),
    },
];

type MyEquipmentReservationProps = {
    myEquipmentReservations: EquipmentReservation[];
};

export default function MyEquipmentReservation({myEquipmentReservations}: MyEquipmentReservationProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="My Equipment Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <DataTable
                        data={myEquipmentReservations}
                        columns={getEquipmentReservationColumns(myEquipmentReservations)}
                        filterColumn={"user"}
                        filterPlaceholder='Search something'
                        tableTitle='My Equipment Reservations'
                        tableDescription='List of my equipment reservations'
                        displayAddButton={false}
                    />
                </div>
            </div>
        </AppLayout>
    );
}
