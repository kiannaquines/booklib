import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Icon } from '@/components/ui/icon';
import DataTable from '../components/datatable';
import { getUsersColumns } from './columns/users-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Users',
    href: route('users'),
  },
];

export type User = {
  id: number;
  name: string;
  email: string;
  number: string;
  created_at: string;
  updated_at: string;
}


type UsersProps = {
  users: User[];
}

const Users = ({ users }: UsersProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Users" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Users'
            tableDescription='Users of the library'
            addButtonName='Add New User'
            data={users} columns={getUsersColumns(users)}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default Users