import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import { toast } from 'sonner';
import { Plus, RefreshCcw, Loader2 } from 'lucide-react';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Book Reservation',
        href: route('student.bookReservation'),
    },
];

type EditBookReservationFormData = {
    book_id: string;
}

type EditBookReservationProps = {
    books: {
        id: number;
        title: string;
        status: string;
    }[];
}

export default function EditBookReservation({ books }: EditBookReservationProps) {
    const [processing, setProcessing] = useState(false)

    const { data, setData, reset, clearErrors } = useForm<EditBookReservationFormData>({
        book_id: '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setProcessing(true);
        router.post(route('student.bookReservationUpdate'), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Book reservation updated successfully');
                setProcessing(false);
                reset();
            },
            onError: (e) => {
                for (const [field, message] of Object.entries(e)) {
                    toast.error('Oops, please try again', {
                        description: `${message}`,
                    });
                }
                setProcessing(false);
            }
        });
    }

    const handleReset = () => {
        reset();
        clearErrors();
        toast.info('Form inputs reset.');
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Update Book Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('book-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Book Reservations
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Update Book Reservation</h2>
                        <p className="text-sm text-muted-foreground">Update your book reservation in the library</p>
                    </div>
                    <form className="mt-4" onSubmit={handleSubmit} method="POST">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="book_id">Book</Label>
                                <Select value={data.book_id} onValueChange={(value) => setData('book_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Book" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {books.map(function (book) {
                                            return (
                                                <SelectItem key={book.id} value={book.id.toString()} disabled={book.status === 'Unavailable'}>{book.status} - {book.title}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <Plus className="w-4 h-4 mr-2" />}
                                Create Book Reservation
                            </Button>
                            <Button type="button" variant="outline" onClick={handleReset}>
                                <RefreshCcw className="w-4 h-4 mr-2" />
                                Reset
                            </Button>
                        </div>

                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
