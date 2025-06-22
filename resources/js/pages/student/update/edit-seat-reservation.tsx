import { useState } from 'react'
import AppLayout from '@/layouts/app-layout';
import { User, type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';
import { ArrowLeft, FilePenLine, Loader2, Plus, RefreshCcw } from 'lucide-react';
import { Label } from '@/components/ui/label';
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Update Seat Reservation',
        href: route('student.mySeatReservation'),
    },
];

type Spaces = {
    id: string
    status: string
    seat: string
}

type SeatReservation = {
    id: string
    reserved_seat: string
    reason: string
}

type EditSeatReservationProps = {
    spaces: Spaces[]
    seatReservation: SeatReservation
}


type EditSeatReservationFormData = {
    seat: string
    reason: string
}

const EditSeatReservation = ({ spaces, seatReservation }: EditSeatReservationProps) => {
    const { data, setData, reset, clearErrors } = useForm<EditSeatReservationFormData>({
        seat: seatReservation.reserved_seat,
        reason: seatReservation.reason,
    })

    const [processing, setProcessing] = useState(false);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();
        router.put(route('student.updateSeatReservation', seatReservation.id), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Space reservation updated successfully');
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
            <Head title="Update Seat Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('seat-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Seat Reservation
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Update Seat Reservation</h2>
                        <p className="text-sm text-muted-foreground">Update your seat reservation in the library</p>
                    </div>
                    <form onSubmit={handleSubmit} method="POST" className="mt-4">

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="seat">Seat</Label>
                                <Select value={String(data.seat)} onValueChange={(value) => setData('seat', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Seat" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {spaces.map(function (space) {
                                            return (
                                                <SelectItem key={space.id} value={space.id.toString()} disabled={space.status === 'In Use'}>{space.status} - {space.seat}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="reason">Reason</Label>
                                <Textarea value={data.reason} onChange={(e) => setData('reason', e.target.value)} name='reason' id='reason' placeholder="Type your message here." />
                            </div>
                        </div>

                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <FilePenLine className="w-4 h-4 mr-2" />}
                                Update Seat Reservation
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

export default EditSeatReservation;
