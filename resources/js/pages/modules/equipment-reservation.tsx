import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getEquipmentReservationColumns } from './columns/equipment-reservation-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Equipment Reservation',
    href: route('equipment-reservations'),
  },
];


export type EquipmentReservation = {
  id: number;
  equipment_id: number;
  equipment: string;
  user_id: number;
  user: string;
  study_space_id: number;
  study_space: string;
  start_time: string;
  end_time: string;
  created_at: string;
  updated_at: string;
}

type EquipmentReservationProps = {
  equipmentReservations: EquipmentReservation[];
}

const EquipmentReservation = ({ equipmentReservations }: EquipmentReservationProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Equipment Reservation" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Equipment Reservation'
            filterColumn='equipment'
            filterPlaceholder='Search by equipment'
            tableDescription='Equipment reservation of the library'
            addButtonName='Add New Equipment Reservation'
            data={equipmentReservations} columns={getEquipmentReservationColumns(equipmentReservations)}
            route={route('create-equipment-reservation')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default EquipmentReservation