import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getBookCategoryColumns } from './columns/book-category-columns';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Book Categories',
    href: route('book-categories.index'),
  },
];

export type BookCategory = {
  id: number;
  name: string;
  description: string | null;
  books_count: number;
  created_at: string;
  updated_at: string;
}

type BookCategoriesProps = {
  categories: BookCategory[];
}

const BookCategories = ({ categories }: BookCategoriesProps) => {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Book Categories" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <DataTable
            tableTitle='Book Categories'
            filterColumn='name'
            filterPlaceholder='Search by category name'
            tableDescription='Manage book categories in the library'
            addButtonName='Add New Category'
            data={categories}
            columns={getBookCategoryColumns()}
            route={route('book-categories.create')}
          />
        </div>
      </div>
    </AppLayout>
  )
}

export default BookCategories
