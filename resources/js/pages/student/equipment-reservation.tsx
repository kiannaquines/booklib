import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Equipment Reservation',
        href: route('student.equipmentReservation'),
    },
];


export default function EquipmentReservation() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Equipment Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <h1>Equipment Reservation</h1>
                </div>
            </div>
        </AppLayout>
    );
}
