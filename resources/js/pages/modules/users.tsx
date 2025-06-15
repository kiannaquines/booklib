import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Icon } from '@/components/ui/icon';
import DataTable from '../components/datatable';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Users',
    href: route('users'),
  },
];

const Users = () => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Users" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable data={[]} columns={[]} />
        </div>
      </div>
    </AppLayout>
  )
}

export default Users