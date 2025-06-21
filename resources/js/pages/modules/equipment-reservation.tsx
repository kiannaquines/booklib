import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getEquipmentReservationColumns } from './columns/equipment-reservation-columns';
import {
  Command,
  CommandEmpty,
  CommandGroup,
  CommandInput,
  CommandItem,
  CommandList,
} from "@/components/ui/command"
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from "@/components/ui/popover"
import { Button } from '@/components/ui/button';
import { CheckIcon, ChevronDownIcon, ChevronsUpDownIcon } from 'lucide-react';
import { cn } from '@/lib/utils';
import { useState } from 'react';
import { Calendar } from '@/components/ui/calendar';
import { toast } from 'sonner';
import GenerateReportTool from './generate-report-tool';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Equipment Reservation',
    href: route('equipment-reservations.index'),
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
          <div className='flex justify-start gap-4 mb-5'>
            <GenerateReportTool
              generateReportRoute={route('equipment-reservation.view')}
              status={[
                {
                  value: "All",
                  label: "All",
                },
                {
                  value: "Pending",
                  label: "Pending",
                },
                {
                  value: "Approved",
                  label: "Approved",
                },
                {
                  value: "Rejected",
                  label: "Rejected",
                },
              ]}
            />
          </div>
          <DataTable
            tableTitle='Equipment Reservation'
            filterColumn='equipment'
            filterPlaceholder='Search by equipment'
            tableDescription='Equipment reservation of the library'
            addButtonName='Add New Equipment Reservation'
            data={equipmentReservations} columns={getEquipmentReservationColumns(equipmentReservations)}
            route={route('equipment-reservations.create')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default EquipmentReservation