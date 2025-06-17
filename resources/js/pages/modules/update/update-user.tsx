import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Head, router, useForm } from "@inertiajs/react";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select"
import { Button } from "@/components/ui/button";
import { ArrowLeft, FilePenLine, Loader2, Plus, RefreshCcw } from "lucide-react";
import { useState } from "react";
import { toast } from "sonner";


type UserFormData = {
    id: string;
    name: string;
    email: string;
    number: string;
    status: string;
    role: string;
}

type UpdateUserProps = {
    user: UserFormData;
    role: string;
}

const UpdateUser = ({ user, role }: UpdateUserProps) => {

    const { data, setData, reset, clearErrors } = useForm<UserFormData>({
        id: user.id,
        name: user.name,
        email: user.email,
        number: user.number,
        status: user.status,
        role: role,
    });

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Users',
            href: route('users'),
        },
        {
            title: 'Edit User',
            href: route('edit-user', { id: data.id }),
        },
    ];

    const [processing, setProcessing] = useState(false);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();

        router.put(route('users.update', { id: data.id }), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('User updated successfully');
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
            <Head title="User Creation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route('users'))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Users
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1 mb-4">
                        <h2 className="text-lg font-semibold">Update User</h2>
                        <p className="text-sm text-muted-foreground">Update a user in the database</p>
                    </div>
                    <form onSubmit={handleSubmit} method="POST" className="mt-5">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="name">Full Name</Label>
                                <Input id="name" value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="Name" />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="email">Email</Label>
                                <Input id="email" value={data.email} onChange={(e) => setData('email', e.target.value)} placeholder="Email" />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="number">Phone Number</Label>
                                <Input id="number" value={data.number} onChange={(e) => setData('number', e.target.value)} placeholder="Phone Number" />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="role">Role</Label>
                                <Select value={data.role} onValueChange={(value) => setData('role', value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Role" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="user">User</SelectItem>
                                        <SelectItem value="admin">Admin</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <FilePenLine className="w-4 h-4 mr-2" />}
                                Update User
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

export default UpdateUser