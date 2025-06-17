import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getEquipmentColumns } from './columns/equipment-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Equipment',
    href: route('equipments.index'),
  },
];

export type Equipment = {
  id: number;
  name: string;
  status: string;
  created_at: string;
  updated_at: string;
}

type EquipmentProps = {
  equipments: Equipment[];
}

const Equipment = ({ equipments }: EquipmentProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Equipment" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Available Equipment'
            filterColumn='name'
            filterPlaceholder='Search by name'
            tableDescription='Equipment available in the library'
            addButtonName='Add New Equipment'
            data={equipments} columns={getEquipmentColumns(equipments)}
            route={route('equipments.create')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default Equipment