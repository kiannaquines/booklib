import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/react';
import DataTable from '../components/datatable';
import { getBookReservationColumns } from './columns/book-reservation-columns';
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

  const [open, setOpen] = useState(false)
  const [value, setValue] = useState("")

  const [openFromDate, setOpenFromDate] = useState(false)
  const [fromDate, setFromDate] = useState<Date | undefined>(undefined)
  const [openToDate, setOpenToDate] = useState(false)
  const [toDate, setToDate] = useState<Date | undefined>(undefined)

  const status = [
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
  ]
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Book Reservation" />
      <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
        <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
          <div className='flex justify-start gap-4 mb-5'>
            <Popover open={openFromDate} onOpenChange={setOpenFromDate}>
              <PopoverTrigger asChild>
                <Button
                  variant="outline"
                  id="fromDate"
                  className="w-48 justify-between font-normal"
                >
                  {fromDate ? fromDate.toLocaleDateString() : "Select from date"}
                  <ChevronDownIcon />
                </Button>
              </PopoverTrigger>
              <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                <Calendar
                  mode="single"
                  selected={fromDate}
                  captionLayout="dropdown"
                  onSelect={(date) => {
                    setFromDate(date)
                    setOpenFromDate(false)
                  }}
                />
              </PopoverContent>
            </Popover>

            <Popover open={openToDate} onOpenChange={setOpenToDate}>
              <PopoverTrigger asChild>
                <Button
                  variant="outline"
                  id="toDate"
                  className="w-48 justify-between font-normal"
                >
                  {toDate ? toDate.toLocaleDateString() : "Select to date"}
                  <ChevronDownIcon />
                </Button>
              </PopoverTrigger>
              <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                <Calendar
                  mode="single"
                  selected={toDate}
                  captionLayout="dropdown"
                  onSelect={(date) => {
                    setToDate(date)
                    setOpenToDate(false)
                  }}
                  disabled={(date) => {
                    if (fromDate) {
                      return date < fromDate
                    }
                    return false
                  }}
                />
              </PopoverContent>
            </Popover>

            <Popover open={open} onOpenChange={setOpen}>
              <PopoverTrigger asChild>
                <Button
                  variant="outline"
                  role="combobox"
                  aria-expanded={open}
                  className="w-[200px] justify-between"
                >
                  {value
                    ? status.find((status) => status.value === value)?.label
                    : "Select status..."}
                  <ChevronsUpDownIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                </Button>
              </PopoverTrigger>
              <PopoverContent className="w-[200px] p-0">
                <Command className='font-normal'>
                  <CommandInput placeholder="Search status..." className='font-normal' />
                  <CommandList>
                    <CommandEmpty className='font-normal text-sm text-muted-foreground p-2 text-center'>No status found.</CommandEmpty>
                    <CommandGroup>
                      {status.map((status) => (
                        <CommandItem
                          key={status.value}
                          value={status.value}
                          onSelect={(currentValue) => {
                            setValue(currentValue === value ? "" : currentValue)
                            setOpen(false)
                          }}
                        >
                          <CheckIcon
                            className={cn(
                              "mr-2 h-4 w-4",
                              value === status.value ? "opacity-100" : "opacity-0"
                            )}
                          />
                          {status.label}
                        </CommandItem>
                      ))}
                    </CommandGroup>
                  </CommandList>
                </Command>
              </PopoverContent>
            </Popover>

            <Button onClick={() => {

              if (!fromDate || !toDate || !value) {
                toast.error('Please select from date, to date and status')
              } else {
                window.open(route('book-reservation.view', {
                  fromDate: fromDate,
                  toDate: toDate,
                  status: value,
                }), '_blank')
              }
            }}>Generate Report</Button>

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