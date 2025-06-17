import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from './components/datatable';
import { BookReservation } from './modules/book-reservation';
import { getBookReservationDashboardColumns } from './modules/columns/book-reservation-columns';
import { Armchair, Microscope, NotebookPen, User } from 'lucide-react';
import { Bar, BarChart, CartesianGrid, XAxis, ResponsiveContainer, YAxis } from "recharts"
import {
    ChartConfig,
    ChartContainer,
    ChartTooltip,
    ChartTooltipContent,
} from "@/components/ui/chart"


const chartData = [
    { month: "January", book: 132 },
    { month: "February", book: 278 },
    { month: "March", book: 198 },
    { month: "April", book: 67 },
    { month: "May", book: 245 },
    { month: "June", book: 162 },
    { month: "July", book: 310 },
    { month: "August", book: 97 },
    { month: "September", book: 184 },
    { month: "October", book: 222 },
    { month: "November", book: 143 },
    { month: "December", book: 267 },
];

const equipmentChartData = [
    { month: "January", equipment: 153 },
    { month: "February", equipment: 201 },
    { month: "March", equipment: 180 },
    { month: "April", equipment: 99 },
    { month: "May", equipment: 231 },
    { month: "June", equipment: 172 },
    { month: "July", equipment: 305 },
    { month: "August", equipment: 121 },
    { month: "September", equipment: 159 },
    { month: "October", equipment: 245 },
    { month: "November", equipment: 130 },
    { month: "December", equipment: 288 },
];

const chartConfig = {
    book: {
        label: "Reservations ",
        color: "var(--chart-1)",
    },
} satisfies ChartConfig

const equipmentChartConfig = {
    equipment: {
        label: "Equipment Reservations",
        color: "var(--chart-2)",
    },
} satisfies ChartConfig

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('dashboard'),
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
                                <span>Users</span>
                            </div>
                            <div className="text-3xl font-bold">{totalUsers ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Number of users in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Microscope className="h-4 w-4" />
                                <span>Books</span>
                            </div>
                            <div className="text-3xl font-bold">{totalEquipment ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Number of equipment in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Armchair className="h-4 w-4" />
                                <span>Study Spaces</span>
                            </div>
                            <div className="text-3xl font-bold">{totalStudySpaces ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Number of study spaces in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <NotebookPen className="h-4 w-4" />
                                <span>Equipment Reservations</span>
                            </div>
                            <div className="text-3xl font-bold">{totalEquipmentReservations ?? 0}</div>
                            <p className="text-xs text-muted-foreground">Number of equipment reservations</p>
                        </div>
                    </div>
                </div>
                <div className='grid grid-cols-1 gap-4 md:grid-cols-2'>
                    <div className="w-full border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border p-6 bg-background h-96 flex flex-col">
                        <div className="mb-4">
                            <h2 className="text-lg font-semibold">Book Reservations</h2>
                            <p className="text-sm text-muted-foreground">
                                Book reservation trends over the last 12 months
                            </p>
                        </div>
                        <ChartContainer config={chartConfig} className="h-[calc(100%-56px)]">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart accessibilityLayer data={chartData}>
                                    <CartesianGrid vertical={true} />
                                    <XAxis
                                        dataKey="month"
                                        tickLine={true}
                                        tickMargin={10}
                                        axisLine={false}
                                        tickFormatter={(value) => value.slice(0, 3)}
                                    />
                                    <YAxis
                                        dataKey="book"
                                        tickLine={true}
                                        tickMargin={10}
                                        axisLine={false}
                                    />
                                    <ChartTooltip content={<ChartTooltipContent />} />
                                    <Bar dataKey="book" fill="var(--color-book)" radius={4} />
                                </BarChart>
                            </ResponsiveContainer>
                        </ChartContainer>
                    </div>
                    <div className="w-full border-sidebar-border/70 dark:border-sidebar-border relative overflow-hidden rounded-xl border p-6 bg-background h-96 flex flex-col">
                        <div className="mb-4">
                            <h2 className="text-lg font-semibold">Equipment Reservations</h2>
                            <p className="text-sm text-muted-foreground">
                                Equipment reservation trends over the last 12 months
                            </p>
                        </div>
                        <ChartContainer config={equipmentChartConfig} className="h-[calc(100%-56px)]">
                            <ResponsiveContainer width="100%" height="100%">
                                <BarChart accessibilityLayer data={equipmentChartData}>
                                    <CartesianGrid vertical={true} />
                                    <XAxis
                                        dataKey="month"
                                        tickLine={true}
                                        tickMargin={10}
                                        axisLine={false}
                                        tickFormatter={(value) => value.slice(0, 3)}
                                    />
                                    <YAxis
                                        dataKey="equipment"
                                        tickLine={true}
                                        tickMargin={10}
                                        axisLine={false}
                                    />
                                    <ChartTooltip content={<ChartTooltipContent />} />
                                    <Bar dataKey="equipment" fill="var(--color-equipment)" radius={4} />
                                </BarChart>
                            </ResponsiveContainer>
                        </ChartContainer>
                    </div>
                </div>
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5 bg-background">
                    <DataTable
                        tableTitle='Book Reservations'
                        tableDescription='Book reservations of the library'
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
