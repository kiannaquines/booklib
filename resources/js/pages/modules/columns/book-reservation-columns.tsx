import { ColumnDef } from "@tanstack/react-table";
import { Checkbox } from "@/components/ui/checkbox";
import { Button } from "@/components/ui/button";
import { ArrowUpDown, MoreHorizontal, Eye, Edit, Trash2 } from "lucide-react";
import {
    DropdownMenu,
    DropdownMenuTrigger,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuItem,
    DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { Badge } from "@/components/ui/badge";
import { router } from "@inertiajs/react";
import { useCallback, useState } from "react";
import { toast } from "sonner";
import { BookReservation } from "../book-reservation";

type DialogIsOpenProps = {
    isOpen: boolean
    setIsOpen: (open: boolean) => void
    handleAction?: () => void
    isDeleting?: boolean
}

function DeleteBookReservationAlertDialog({ isOpen, setIsOpen, handleAction, isDeleting }: DialogIsOpenProps) {
    return (
        <AlertDialog open={isOpen} onOpenChange={setIsOpen}>
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Confirm Deletion</AlertDialogTitle>
                    <AlertDialogDescription>
                        Are you sure you want to delete this book reservation? This action cannot be undone.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancel</AlertDialogCancel>
                    <AlertDialogAction
                        className="bg-red-600 hover:bg-red-700"
                        onClick={handleAction}
                    >
                        {isDeleting ? "Deleting..." : "Delete Reservation"}
                    </AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    );
}

interface BookReservationActionsCellProps {
    bookReservation: BookReservation
}

function BookReservationActionsCell({ bookReservation }: BookReservationActionsCellProps) {
    const [isDeleting, setIsDeleting] = useState(false);
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    const handleDelete = useCallback(() => {
        setIsDeleting(true);
        router.delete(route('book-reservations.destroy', { id: bookReservation.id }), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Book reservation deleted successfully");
            },
            onError: (e) => {
                for (const [field, message] of Object.entries(e)) {
                    toast.error("Failed to delete book reservation", {
                        description: `${message}`,
                    });
                }
            },
            onFinish: () => {
                setIsDeleting(false);
                setIsDeleteDialogOpen(false);
            }
        });
    }, [bookReservation?.id]);

    const openDeleteDialog = useCallback((e: React.MouseEvent) => {
        e.preventDefault();
        setDropdownOpen(false)
        setIsDeleteDialogOpen(true)
    }, []);

    return (
        <div className="flex justify-end">
            <DropdownMenu open={dropdownOpen} onOpenChange={setDropdownOpen}>
                <DropdownMenuTrigger asChild>
                    <Button variant="ghost" className="h-8 w-8 p-0">
                        <span className="sr-only">Open menu</span>
                        <MoreHorizontal className="h-4 w-4" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end" className="w-40">
                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem onClick={() =>
                        router.visit(route('book-reservations.edit', { id: String(bookReservation.id) }))
                    }>
                        <Edit className="mr-2 h-4 w-4" />
                        Edit
                    </DropdownMenuItem>
                    <DropdownMenuItem
                        className="text-red-600 focus:text-red-600 focus:bg-red-50"
                        onClick={openDeleteDialog}
                    >
                        <Trash2 className="mr-2 h-4 w-4" />
                        Delete
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>

            <DeleteBookReservationAlertDialog isOpen={isDeleteDialogOpen} setIsOpen={setIsDeleteDialogOpen} handleAction={handleDelete} isDeleting={isDeleting} />

        </div>
    );

}

type BookReservationColumnProps = {
    bookReservations: BookReservation[]
}

export function getBookReservationColumns(bookReservations: BookReservation[]): ColumnDef<BookReservation>[] {
    return [
        {
            id: "select",
            header: ({ table }) => (
                <Checkbox
                    checked={table.getIsAllPageRowsSelected()}
                    onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
                    aria-label="Select all"
                />
            ),
            cell: ({ row }) => (
                <Checkbox
                    checked={row.getIsSelected()}
                    onCheckedChange={(value) => row.toggleSelected(!!value)}
                    aria-label="Select row"
                />
            ),
            enableSorting: false,
            enableHiding: true,
        },
        {
            accessorKey: "book",
            header: ({ column }) => (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Book
                    <ArrowUpDown className="ml-2 h-4 w-4" />
                </Button>
            ),
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("book")}
                </Badge>
            ),
        },
        {
            accessorKey: "user",
            header: "User",
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("user")}
                </Badge>
            ),
        },
        {
            accessorKey: "start_time",
            header: "Start Time",
            cell: ({ row }) => (
                <div>
                    {row.getValue("start_time")}
                </div>
            ),
        },
        {
            accessorKey: "end_time",
            header: "End Time",
            cell: ({ row }) => (
                <div>
                    {row.getValue("end_time")}
                </div>
            ),
        },
        {
            accessorKey: "status",
            header: "Status",
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("status")}
                </Badge>
            ),
        },
        {
            id: "actions",
            enableHiding: false,
            cell: ({ row }) => {
                return (
                    <BookReservationActionsCell bookReservation={row.original} />
                )
            },
        },
    ];
}


export function getBookReservationDashboardColumns(bookReservations: BookReservation[]): ColumnDef<BookReservation>[] {
    return [
        {
            id: "select",
            header: ({ table }) => (
                <Checkbox
                    checked={table.getIsAllPageRowsSelected()}
                    onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
                    aria-label="Select all"
                />
            ),
            cell: ({ row }) => (
                <Checkbox
                    checked={row.getIsSelected()}
                    onCheckedChange={(value) => row.toggleSelected(!!value)}
                    aria-label="Select row"
                />
            ),
            enableSorting: false,
            enableHiding: true,
        },
        {
            accessorKey: "book",
            header: ({ column }) => (
                <Button
                    variant="ghost"
                    onClick={() => column.toggleSorting(column.getIsSorted() === "asc")}
                >
                    Book
                    <ArrowUpDown className="ml-2 h-4 w-4" />
                </Button>
            ),
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("book")}
                </Badge>
            ),
        },
        {
            accessorKey: "user",
            header: "User",
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("user")}
                </Badge>
            ),
        },
        {
            accessorKey: "status",
            header: "Status",
            cell: ({ row }) => (
                <Badge variant="outline" className="capitalize">
                    {row.getValue("status")}
                </Badge>
            ),
        },
    ];
}