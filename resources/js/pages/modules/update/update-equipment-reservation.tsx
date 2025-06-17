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
import { ArrowLeft, FilePenLine, Loader2, RefreshCcw } from "lucide-react";
import { useForm } from "@inertiajs/react";
import { toast } from "sonner";
import * as React from "react";
import { StudySpace, User } from "./update-book-reservation";

type Equipment = {
    id: number;
    name: string;
    status: string;
}

type EquipmentReservation = {
    id: string;
    user_id: string;
    equipment_id: string;
    study_space_id: string;
    status: string;

}

type UpdateEquipmentReservationProps = {
    equipmentReservation: EquipmentReservation;
    equipments: Equipment[];
    studySpaces: StudySpace[];
    users: User[];
}

type UpdateEquipmentReservationFormData = {
    id: string;
    user_id: string;
    equipment_id: string;
    study_space_id: string;
    status: string;
}

const UpdateEquipmentReservation = ({ equipmentReservation, equipments, studySpaces, users }: UpdateEquipmentReservationProps) => {

    const [processing, setProcessing] = React.useState(false)

    const { data, setData, reset, clearErrors } = useForm<UpdateEquipmentReservationFormData>({
        id: equipmentReservation.id,
        user_id: String(equipmentReservation.user_id),
        equipment_id: String(equipmentReservation.equipment_id),
        study_space_id: String(equipmentReservation.study_space_id),
        status: equipmentReservation.status,
    });

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Equipment Reservation',
            href: route('equipment-reservations.index'),
        },
        {
            title: 'Edit Equipment Reservation',
            href: route('equipment-reservations.edit', { id: data.id }),
        },
    ];

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setProcessing(true);
        router.put(route('equipment-reservations.update', { id: data.id }), data, {
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
            <Head title="Equipment Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('equipment-reservations.index'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Equipment Reservations
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Update Equipment Reservation</h2>
                        <p className="text-sm text-muted-foreground">Update an equipment reservation in the library</p>
                    </div>
                    <form onSubmit={handleSubmit} method="POST" className="mt-4">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="user_id">User</Label>
                                <Select value={String(data.user_id)} onValueChange={(value) => setData('user_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select User" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {users.map(function (user) {
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
                                <Label htmlFor="equipment_id">Equipment</Label>
                                <Select value={String(data.equipment_id)} onValueChange={(value) => setData('equipment_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Select Equipment" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {equipments.map(function (equipment) {
                                            return (
                                                <SelectItem key={equipment.id} value={equipment.id.toString()} disabled={equipment.status === 'Unavailable'}>{equipment.status} - {equipment.name}</SelectItem>
                                            )
                                        })}
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="study_space_id">Study Space</Label>
                                <Select value={String(data.study_space_id)} onValueChange={(value) => setData('study_space_id', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Study Space" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {studySpaces.map(function (space) {
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
                                        {['Pending', 'Approved', 'Rejected'].map(function (status) {
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
    )
}

export default UpdateEquipmentReservation