import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { Icon } from '@/components/ui/icon';
import DataTable from '../components/datatable';
import { getStudySpaceColumns } from './columns/space-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Study Space',
    href: route('study-spaces'),
  },
];

export type StudySpace = {
  id: number;
  seat_number: string;
  status: string;
  created_at: string;
  updated_at: string;
}


type StudySpaceProps = {
  spaces: StudySpace[];
}

const StudySpace = ({ spaces }: StudySpaceProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Study Space" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Available Study Spaces'
            tableDescription='Study spaces available in the library'
            addButtonName='Add New Study Space'
            data={spaces} columns={getStudySpaceColumns(spaces)}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default StudySpace