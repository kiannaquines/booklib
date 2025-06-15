import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getBookReservationColumns } from './columns/book-reservation-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Book Reservation',
    href: route('book-reservation'),
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
          <DataTable
            tableTitle='Book Reservation'
            tableDescription='Book reservation of the library'
            addButtonName='Add New Book Reservation'
            data={books} columns={getBookReservationColumns(books)}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default BookReservation