import { useState } from 'react'
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';
import { ArrowLeft, Loader2, Armchair, CheckCircle2, XCircle, AlertCircle, Info } from 'lucide-react';
import { Label } from '@/components/ui/label';
import { Textarea } from "@/components/ui/textarea"
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Alert, AlertDescription } from '@/components/ui/alert';

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
    remainingReservations: number
}

type SeatReservationFormData = {
    seat: string
    reason: string
}

const SeatReservation = ({ spaces, remainingReservations }: CreateSeatReservationProps) => {
    const [selectedSeat, setSelectedSeat] = useState<string>('');
    const [reason, setReason] = useState<string>('');
    const [processing, setProcessing] = useState(false);
    const { errors } = usePage().props;

    const handleSeatSelect = (seatId: string, status: string) => {
        if (status === 'Available') {
            setSelectedSeat(seatId);
        }
    };

    const handleSubmit = () => {
        if (!selectedSeat) {
            toast.error('Please select a seat');
            return;
        }

        if (remainingReservations <= 0) {
            toast.error('Reservation Limit Reached', {
                description: 'You have reached the maximum of 25 reservations per day. Please try again tomorrow.',
            });
            return;
        }

        setProcessing(true);
        router.post(route('student.seatReservationCreate'), {
            seat: selectedSeat,
            reason: reason
        }, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Seat reservation created successfully');
                setProcessing(false);
                setSelectedSeat('');
                setReason('');
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
    };

    const handleReset = () => {
        setSelectedSeat('');
        setReason('');
        toast.info('Selection cleared');
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Seat Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <div>
                        <h2 className="text-2xl font-bold">Seat Reservation</h2>
                        <p className="text-sm text-muted-foreground">Select an available seat for your study session</p>
                    </div>
                    <Button variant="outline" onClick={() => router.visit(route('student.mySeatReservation'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        My Reservations
                    </Button>
                </div>

                {remainingReservations <= 5 && remainingReservations > 0 && (
                    <Alert className="border-orange-500 bg-orange-50 dark:bg-orange-950">
                        <AlertCircle className="h-4 w-4 text-orange-600" />
                        <AlertDescription className="text-orange-800 dark:text-orange-200">
                            You have {remainingReservations} reservation{remainingReservations !== 1 ? 's' : ''} remaining today.
                        </AlertDescription>
                    </Alert>
                )}

                {remainingReservations === 0 && (
                    <Alert variant="destructive">
                        <XCircle className="h-4 w-4" />
                        <AlertDescription>
                            You have reached the maximum limit of 25 seat reservations per day. Please try again tomorrow.
                        </AlertDescription>
                    </Alert>
                )}

                {remainingReservations > 5 && (
                    <Alert className="border-blue-500 bg-blue-50 dark:bg-blue-950">
                        <Info className="h-4 w-4 text-blue-600" />
                        <AlertDescription className="text-blue-800 dark:text-blue-200">
                            You can make {remainingReservations} more reservations today (max 25 per day).
                        </AlertDescription>
                    </Alert>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Seat Selection Grid */}
                    <div className="lg:col-span-2">
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Armchair className="w-5 h-5" />
                                    Select Your Seat
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="mb-4 flex items-center gap-4 text-sm">
                                    <div className="flex items-center gap-2">
                                        <div className="w-4 h-4 rounded bg-green-500"></div>
                                        <span>Available</span>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <div className="w-4 h-4 rounded bg-red-500"></div>
                                        <span>Occupied</span>
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <div className="w-4 h-4 rounded bg-blue-500 ring-2 ring-blue-600"></div>
                                        <span>Selected</span>
                                    </div>
                                </div>

                                <div className="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
                                    {spaces.map((space) => {
                                        const isAvailable = space.status === 'Available';
                                        const isSelected = selectedSeat === space.id;
                                        
                                        return (
                                            <button
                                                key={space.id}
                                                type="button"
                                                onClick={() => handleSeatSelect(space.id, space.status)}
                                                disabled={!isAvailable}
                                                className={`
                                                    relative aspect-square rounded-lg border-2 flex flex-col items-center justify-center p-2 transition-all
                                                    ${isSelected ? 'bg-blue-500 border-blue-600 text-white ring-2 ring-blue-600 scale-105' : ''}
                                                    ${isAvailable && !isSelected ? 'bg-green-50 border-green-500 hover:bg-green-100 hover:scale-105 dark:bg-green-950 dark:border-green-600' : ''}
                                                    ${!isAvailable ? 'bg-red-50 border-red-300 cursor-not-allowed opacity-50 dark:bg-red-950 dark:border-red-800' : 'cursor-pointer'}
                                                `}
                                            >
                                                <Armchair className={`w-5 h-5 mb-1 ${
                                                    isSelected ? 'text-white' : 
                                                    isAvailable ? 'text-green-600 dark:text-green-400' : 
                                                    'text-red-400 dark:text-red-600'
                                                }`} />
                                                <span className={`text-xs font-semibold ${
                                                    isSelected ? 'text-white' : 
                                                    isAvailable ? 'text-green-700 dark:text-green-300' : 
                                                    'text-red-600 dark:text-red-400'
                                                }`}>
                                                    {space.seat}
                                                </span>
                                                {isSelected && (
                                                    <CheckCircle2 className="absolute -top-1 -right-1 w-4 h-4 text-white bg-blue-600 rounded-full" />
                                                )}
                                                {!isAvailable && (
                                                    <XCircle className="absolute -top-1 -right-1 w-4 h-4 text-white bg-red-600 rounded-full" />
                                                )}
                                            </button>
                                        );
                                    })}
                                </div>

                                {spaces.length === 0 && (
                                    <div className="text-center py-12">
                                        <Armchair className="w-12 h-12 text-muted-foreground mx-auto mb-4" />
                                        <p className="text-muted-foreground">No seats available</p>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    {/* Reservation Details */}
                    <div className="lg:col-span-1">
                        <Card className="sticky top-4">
                            <CardHeader>
                                <CardTitle>Reservation Details</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                {selectedSeat ? (
                                    <>
                                        <div className="p-4 bg-blue-50 dark:bg-blue-950 rounded-lg border border-blue-200 dark:border-blue-800">
                                            <div className="flex items-center gap-2 mb-2">
                                                <Armchair className="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                                <span className="font-semibold text-blue-900 dark:text-blue-100">Selected Seat</span>
                                            </div>
                                            <p className="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                {spaces.find(s => s.id === selectedSeat)?.seat}
                                            </p>
                                        </div>

                                        <div className="space-y-2">
                                            <Label htmlFor="reason">Reason (Optional)</Label>
                                            <Textarea
                                                id="reason"
                                                value={reason}
                                                onChange={(e) => setReason(e.target.value)}
                                                placeholder="Why do you need this seat?"
                                                rows={4}
                                                className="resize-none"
                                            />
                                        </div>

                                        <div className="space-y-2">
                                            <Button
                                                onClick={handleSubmit}
                                                disabled={processing || remainingReservations === 0}
                                                className="w-full"
                                                size="lg"
                                            >
                                                {processing ? (
                                                    <>
                                                        <Loader2 className="w-4 h-4 mr-2 animate-spin" />
                                                        Reserving...
                                                    </>
                                                ) : (
                                                    <>
                                                        <CheckCircle2 className="w-4 h-4 mr-2" />
                                                        Reserve Seat
                                                    </>
                                                )}
                                            </Button>
                                            <Button
                                                variant="outline"
                                                onClick={handleReset}
                                                className="w-full"
                                                disabled={processing}
                                            >
                                                Clear Selection
                                            </Button>
                                        </div>
                                    </>
                                ) : (
                                    <div className="text-center py-8">
                                        <Armchair className="w-12 h-12 text-muted-foreground mx-auto mb-4 opacity-50" />
                                        <p className="text-sm text-muted-foreground">
                                            Select a seat from the grid to continue
                                        </p>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AppLayout>
    )
}

export default SeatReservation
