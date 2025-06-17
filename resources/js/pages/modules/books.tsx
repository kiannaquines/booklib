import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getBooksColumns } from './columns/books-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Books',
    href: route('books.index'),
  },
];

export type Book = {
  id: number;
  title: string;
  author: string;
  status: string;
  created_at: string;
  updated_at: string;
}

type BooksProps = {
  books: Book[];
}

const Books = ({ books }: BooksProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Books" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Available Books'
            filterColumn='title'
            filterPlaceholder='Search by title'
            tableDescription='Books available in the library'
            addButtonName='Add New Book'
            data={books}
            columns={getBooksColumns(books)}
            route={route('books.create')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default Books