import { useState } from 'react'
import AppLayout from '@/layouts/app-layout';
import { User, type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Loader2, Plus, RefreshCcw } from 'lucide-react';
import { Label } from '@/components/ui/label';
import { Textarea } from "@/components/ui/textarea"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Seat Reservation',
        href: route('student.mySeatReservation'),
    },
];

type Spaces = {
    id: string
    status: string
    seat: string
}

type CreateSeatReservationProps = {
    spaces: Spaces[]
}

type SeatReservationFormData = {
    seat: string
    reason: string
}

const SeatReservation = ({ spaces }: CreateSeatReservationProps) => {
    const { data, setData, reset, clearErrors } = useForm<SeatReservationFormData>({
        seat: '',
        reason: '',
    })

    const [processing, setProcessing] = useState(false);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();
        router.post(route('student.seatReservationCreate'), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Space reservation created successfully');
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
            <Head title="Create Seat Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('seat-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Seat Reservation
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Create Seat Reservation</h2>
                        <p className="text-sm text-muted-foreground">Create a new seat reservation in the library</p>
                    </div>
                    <form onSubmit={handleSubmit} method="POST" className="mt-4">

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="seat">Seat</Label>
                                <Select value={data.seat} onValueChange={(value) => setData('seat', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Seat" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {spaces.map(function (space) {
                                            return (
                                                <SelectItem key={space.id} value={space.id.toString()}>{space.status} - {space.seat}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="reason">Reason</Label>
                                <Textarea name='reason' id='reason' placeholder="Type your message here." />
                            </div>
                        </div>

                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <Plus className="w-4 h-4 mr-2" />}
                                Create Seat Reservation
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

export default SeatReservation
