import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Head, router, useForm } from '@inertiajs/react';
import { ArrowLeft, FilePenLine } from 'lucide-react';
import { toast } from 'sonner';
import { Plus, RefreshCcw, Loader2 } from 'lucide-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Equipment Reservation',
        href: route('student.equipmentReservation'),
    },
];

type EditEquipmentReservationFormData = {
    equipment: string;
}



type EditEquipmentReservationProps = {
    equipmentReservation: {
        id: number;
        equipment_id: string;
    }
    equipments: {
        id: number;
        name: string;
        status: string;
    }[];
}

export default function EditEquipmentReservation({ equipments, equipmentReservation }: EditEquipmentReservationProps) {

    const [processing, setProcessing] = useState(false)

    const { data, setData, reset, clearErrors } = useForm<EditEquipmentReservationFormData>({
        equipment: equipmentReservation.equipment_id,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setProcessing(true);
        router.put(route('student.updateEquipmentReservation', equipmentReservation.id), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Equipment reservation updated successfully');
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
            <Head title="Edit Equipment Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('equipment-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Equipment Reservations
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Edit Equipment Reservation</h2>
                        <p className="text-sm text-muted-foreground">Edit an existing equipment reservation in the library</p>
                    </div>
                    <form onSubmit={handleSubmit} method="POST" className="mt-4">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="equipment">Equipment</Label>
                                <Select value={String(data.equipment)} onValueChange={(value) => setData('equipment', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select Equipment" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {equipments.map(function (equipment) {
                                            return (
                                                <SelectItem key={equipment.id} value={equipment.id.toString()} disabled={equipment.status === 'In Use'}>{equipment.status} - {equipment.name}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <FilePenLine className="w-4 h-4 mr-2" />}
                                Update Equipment Reservation
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
