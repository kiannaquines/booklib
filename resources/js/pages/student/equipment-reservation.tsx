import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Head, router, usePage } from '@inertiajs/react';
import { ArrowLeft, Wrench, CheckCircle2, XCircle, AlertCircle, Info } from 'lucide-react';
import { toast } from 'sonner';
import { Loader2 } from 'lucide-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Equipment Reservation',
        href: route('student.equipmentReservation'),
    },
];

type EquipmentReservationProps = {
    equipments: {
        id: number;
        name: string;
        status: string;
        image: string | null;
        description: string | null;
        max_slots: number;
        reserved_today: number;
        available_slots: number;
    }[];
    remainingReservations: number;
}

export default function EquipmentReservation({ equipments, remainingReservations }: EquipmentReservationProps) {
    const [processing, setProcessing] = useState<number | null>(null);
    const { errors } = usePage().props;

    const handleReserveEquipment = (equipmentId: number) => {
        if (remainingReservations <= 0) {
            toast.error('Reservation Limit Reached', {
                description: 'You have reached the maximum of 25 reservations per day. Please try again tomorrow.',
            });
            return;
        }

        setProcessing(equipmentId);
        router.post(route('student.equipmentReservationCreate'), { equipment: equipmentId.toString() }, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Equipment reservation created successfully');
                setProcessing(null);
            },
            onError: (e) => {
                for (const [field, message] of Object.entries(e)) {
                    toast.error('Oops, please try again', {
                        description: `${message}`,
                    });
                }
                setProcessing(null);
            }
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Equipment Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <div>
                        <h2 className="text-2xl font-bold">Equipment Reservation</h2>
                        <p className="text-sm text-muted-foreground">Browse and reserve available equipment</p>
                    </div>
                    <Button variant="outline" onClick={() => router.visit(route('student.myEquipmentReservation'))}>
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
                            You have reached the maximum limit of 25 equipment reservations per day. Please try again tomorrow.
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

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {equipments.map((equipment) => (
                        <Card key={equipment.id} className="flex flex-col overflow-hidden">
                            <div className="relative h-48 bg-muted overflow-hidden flex items-center justify-center">
                                {equipment.image ? (
                                    <img
                                        src={equipment.image}
                                        alt={equipment.name}
                                        className="w-full h-full object-cover"
                                    />
                                ) : (
                                    <img
                                        src="https://imgs.search.brave.com/Uyh5t_FR5z5491Bm5wCIFLehc9cgg_bzr375F4gJacA/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMudmVjdGVlenku/Y29tL3N5c3RlbS9y/ZXNvdXJjZXMvdGh1/bWJuYWlscy8wMTYv/OTE2LzQ3OS9zbWFs/bC9wbGFjZWhvbGRl/ci1pY29uLWRlc2ln/bi1mcmVlLXZlY3Rv/ci5qcGc"
                                        alt={equipment.name}
                                        className="w-32 h-32 object-contain"
                                    />
                                )}
                                <div className="absolute top-2 right-2">
                                    {equipment.status === 'Available' ? (
                                        <Badge className="bg-green-500 hover:bg-green-600">
                                            <CheckCircle2 className="w-3 h-3 mr-1" />
                                            Available
                                        </Badge>
                                    ) : (
                                        <Badge variant="destructive">
                                            <XCircle className="w-3 h-3 mr-1" />
                                            Unavailable
                                        </Badge>
                                    )}
                                </div>
                            </div>
                            <CardHeader>
                                <CardTitle className="line-clamp-1">{equipment.name}</CardTitle>
                                <CardDescription className="line-clamp-1">Equipment</CardDescription>
                                <div className="mt-2">
                                    <Badge variant="outline" className="text-xs">
                                        {equipment.available_slots}/{equipment.max_slots} slots available
                                    </Badge>
                                </div>
                            </CardHeader>
                            <CardContent className="flex-1">
                                {equipment.description ? (
                                    <p className="text-sm text-muted-foreground line-clamp-3">
                                        {equipment.description}
                                    </p>
                                ) : (
                                    <p className="text-sm text-muted-foreground italic">
                                        No description available
                                    </p>
                                )}
                            </CardContent>
                            <CardFooter>
                                <Button
                                    className="w-full"
                                    disabled={equipment.status === 'Unavailable' || processing === equipment.id || remainingReservations === 0 || equipment.available_slots === 0}
                                    onClick={() => handleReserveEquipment(equipment.id)}
                                >
                                    {processing === equipment.id ? (
                                        <>
                                            <Loader2 className="w-4 h-4 mr-2 animate-spin" />
                                            Reserving...
                                        </>
                                    ) : equipment.available_slots === 0 ? (
                                        <>
                                            <XCircle className="w-4 h-4 mr-2" />
                                            No Slots Available
                                        </>
                                    ) : (
                                        <>
                                            <Wrench className="w-4 h-4 mr-2" />
                                            Reserve Equipment
                                        </>
                                    )}
                                </Button>
                            </CardFooter>
                        </Card>
                    ))}
                </div>

                {equipments.length === 0 && (
                    <div className="flex flex-col items-center justify-center py-12 text-center">
                        <Wrench className="w-16 h-16 text-muted-foreground mb-4" />
                        <h3 className="text-lg font-semibold mb-2">No Equipment Available</h3>
                        <p className="text-muted-foreground">There is no equipment in the library yet.</p>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
