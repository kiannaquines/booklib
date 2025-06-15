import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from './components/datatable';
import { BookReservation } from './modules/book-reservation';
import { getBookReservationDashboardColumns } from './modules/columns/book-reservation-columns';
import { Armchair, Microscope, NotebookPen, User } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

type DashboardProps = {
    reservations: BookReservation[];
    totalUsers: number;
    totalBooks: number;
    totalEquipment: number;
    totalStudySpaces: number;
    totalEquipmentReservations: number;
}

export default function Dashboard({ reservations, totalUsers, totalBooks, totalEquipment, totalStudySpaces, totalEquipmentReservations }: DashboardProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="grid auto-rows-min gap-4 md:grid-cols-4">
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <User className="h-4 w-4" />
                                <span>Total Users</span>
                            </div>
                            <div className="text-3xl font-bold">{totalUsers ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Total number of users in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Microscope className="h-4 w-4" />
                                <span>Total Books</span>
                            </div>
                            <div className="text-3xl font-bold">{totalEquipment ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Total number of equipment in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Armchair className="h-4 w-4" />
                                <span>Total Study Spaces</span>
                            </div>
                            <div className="text-3xl font-bold">{totalStudySpaces ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Total number of study spaces in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <NotebookPen className="h-4 w-4" />
                                <span>Total Equipment Reservations</span>
                            </div>
                            <div className="text-3xl font-bold">{totalEquipmentReservations ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Total number of equipment reservations</p>
                        </div>
                    </div>
                </div>
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <DataTable
                        tableTitle='Book Reservation'
                        tableDescription='Book reservation of the library'
                        addButtonName='Add New Book Reservation'
                        data={reservations}
                        columns={getBookReservationDashboardColumns(reservations)}
                        displayAddButton={false}
                        filterColumn='book'
                        filterPlaceholder='Search by book'
                    />
                </div>
            </div>
        </AppLayout>
    );
}
