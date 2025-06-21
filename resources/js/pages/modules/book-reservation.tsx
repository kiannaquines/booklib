import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getBookReservationColumns } from './columns/book-reservation-columns';
import GenerateReportTool from './generate-report-tool';
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Book Reservation',
    href: route('book-reservations.index'),
  },
];

export type BookReservation = {
  id: number;
  book: string;
  book_id: number;
  user: string;
  user_id: number;
  seat_number: string;
  space_id: number;
  start_time: string;
  end_time: string;
  created_at: string;
  updated_at: string;
}

type BookReservationProps = {
  books: BookReservation[];
}

const BookReservation = ({ books }: BookReservationProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Book Reservation" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <div className='flex justify-start gap-4 mb-5'>
            <GenerateReportTool
              generateReportRoute={route('book-reservation.view')}
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
            tableTitle='Book Reservation'
            filterColumn='book'
            filterPlaceholder='Search by book'
            tableDescription='Book reservation of the library'
            addButtonName='Add New Book Reservation'
            data={books} columns={getBookReservationColumns(books)}
            route={route('book-reservations.create')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default BookReservation