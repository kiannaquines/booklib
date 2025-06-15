import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from './components/datatable';
import { Icon } from '@/components/ui/icon';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Icon className="h-4 w-4" />
                                <span>Total Users</span>
                            </div>
                            <div className="text-3xl font-bold">100</div>
                            <p className="text-xs text-muted-foreground">Total number of users in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Icon className="h-4 w-4" />
                                <span>Total Equipment</span>
                            </div>
                            <div className="text-3xl font-bold">100</div>
                            <p className="text-xs text-muted-foreground">Total number of equipment in the system</p>
                        </div>
                    </div>
                    <div className="relative h-36 overflow-hidden rounded-xl border p-4">
                        <div className="flex flex-col justify-between h-full">
                            <div className="flex items-center justify-between text-sm font-medium text-muted-foreground">
                                <Icon className="h-4 w-4" />
                                <span>Total Study Spaces</span>
                            </div>
                            <div className="text-3xl font-bold">100</div>
                            <p className="text-xs text-muted-foreground">Total number of study spaces in the system</p>
                        </div>
                    </div>
                </div>
                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <DataTable data={[]} columns={[]} displayAddButton={false} />
                </div>
            </div>
        </AppLayout>
    );
}
