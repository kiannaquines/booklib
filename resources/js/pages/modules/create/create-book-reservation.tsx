import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, router } from "@inertiajs/react";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button";
import { ArrowLeft, Loader2, Plus, RefreshCcw } from "lucide-react";
import * as React from "react"
import { useForm } from "@inertiajs/react";
import { toast } from "sonner";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Book Reservation',
        href: route('book-reservations.index'),
    },
    {
        title: 'Create Book Reservation',
        href: route('book-reservations.create'),
    },
];

export type User = {
    id: number;
    name: string;
}

export type Book = {
    id: number;
    title: string;
    status: string;
}

export type StudySpace = {
    id: number;
    seat_number: string;
    status: string;
}

type CreateBookReservationProps = {
    users: User[];
    books: Book[];
    spaces: StudySpace[];
}

type CreateBookReservationFormData = {
    user_id: string;
    book_id: string;
    status: string;
    study_space_id: string;
}

const CreateBookReservation = ({ users, books, spaces }: CreateBookReservationProps) => {

    const [processing, setProcessing] = React.useState(false)

    const {data, setData, reset, clearErrors} = useForm<CreateBookReservationFormData>({
        user_id: '',
        book_id: '',
        status: '',
        study_space_id: '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setProcessing(true);
        router.post(route('book-reservations.store'), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Book reservation created successfully');
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
            <Head title="Book Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('book-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Book Reservations
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Create Book Reservation</h2>
                        <p className="text-sm text-muted-foreground">Create a new book reservation in the library</p>
                    </div>
                    <form className="mt-4" onSubmit={handleSubmit} method="POST">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="user_id">User</Label>
                                <Select value={data.user_id} onValueChange={(value) => setData('user_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select User" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {users.map(function(user){
                                            return (
                                                <SelectItem key={user.id} value={user.id.toString()}>{user.name}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="book_id">Book</Label>
                                <Select value={data.book_id} onValueChange={(value) => setData('book_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Book" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {books.map(function(book){
                                            return (
                                                <SelectItem key={book.id} value={book.id.toString()} disabled={book.status === 'Unavailable'}>{book.status} - {book.title}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="study_space_id">Study Space</Label>
                                <Select value={data.study_space_id} onValueChange={(value) => setData('study_space_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Study Space" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {spaces.map(function(space){
                                            return (
                                                <SelectItem key={space.id} value={space.id.toString()} disabled={space.status === 'Unavailable'}>{space.status} - {space.seat_number}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="status">Status</Label>
                                <Select value={data.status} onValueChange={(value) => setData('status', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {['Pending', 'Approved', 'Rejected'].map(function(status){
                                            return (
                                                <SelectItem key={status} value={status}>{status}</SelectItem>
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
    )
}

export default CreateBookReservation