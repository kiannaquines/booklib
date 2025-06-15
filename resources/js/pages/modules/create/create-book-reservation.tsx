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
import { ArrowLeft, BadgeInfo, Plus, RefreshCcw } from "lucide-react";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover"
import { Calendar } from "@/components/ui/calendar"

import { ChevronDownIcon } from "lucide-react"
import * as React from "react"
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert"

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Book Reservation',
        href: route('book-reservation'),
    },
    {
        title: 'Create Book Reservation',
        href: route('create-book-reservation'),
    },
];

const CreateBookReservation = () => {

    const [open, setOpen] = React.useState(false)
    const [date, setDate] = React.useState<Date | undefined>(undefined)

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Book Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit('/book-reservations')}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Book Reservations
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Create Book Reservation</h2>
                        <p className="text-sm text-muted-foreground">Create a new book reservation in the library</p>
                    </div>
                    <form className="mt-4">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="user_id">User</Label>
                                <Select>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="User" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="1">User 1</SelectItem>
                                        <SelectItem value="2">User 2</SelectItem>
                                        <SelectItem value="3">User 3</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="book_id">Book</Label>
                                <Select>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Book" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="1">Book 1</SelectItem>
                                        <SelectItem value="2">Book 2</SelectItem>
                                        <SelectItem value="3">Book 3</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="study_space_id">Study Space</Label>
                                <Select>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Study Space" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="1">Study Space 1</SelectItem>
                                        <SelectItem value="2">Study Space 2</SelectItem>
                                        <SelectItem value="3">Study Space 3</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="status">Status</Label>
                                <Select>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder="Status" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="available">Available</SelectItem>
                                        <SelectItem value="unavailable">Unavailable</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <Alert variant="default" className="mt-4">
                            <BadgeInfo />
                            <AlertTitle>Book Reservation Start & End Time</AlertTitle>
                            <AlertDescription className="flex items-center gap-2">
                                <p>Please select the start and end time for the book reservation.</p>
                            </AlertDescription>
                        </Alert>

                        <div className="flex w-full items-center gap-4 mt-4">
                            <div className="flex flex-row space-y-1.5 gap-3">
                                <div className="flex flex-col gap-3">
                                    <Label htmlFor="date" className="px-1">
                                        Start Date
                                    </Label>
                                    <Popover open={open} onOpenChange={setOpen}>
                                        <PopoverTrigger asChild>
                                            <Button
                                                variant="outline"
                                                id="date"
                                                className="w-50 justify-between font-normal"
                                            >
                                                {date ? date.toLocaleDateString() : "Select date"}
                                                <ChevronDownIcon />
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                                            <Calendar
                                                mode="single"
                                                selected={date}
                                                captionLayout="dropdown"
                                                onSelect={(date) => {
                                                    setDate(date)
                                                    setOpen(false)
                                                }}
                                            />
                                        </PopoverContent>
                                    </Popover>
                                </div>
                                <div className="flex flex-col gap-3">
                                    <Label htmlFor="time" className="px-1">
                                        Start Time
                                    </Label>
                                    <Input
                                        type="time"
                                        id="time"
                                        step="1"
                                        defaultValue="10:30:00"
                                        className="bg-background appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none"
                                    />
                                </div>
                            </div>
                            <div className="flex flex-row space-y-1.5 gap-3">
                                <div className="flex flex-col gap-3">
                                    <Label htmlFor="date" className="px-1">
                                        Start Date
                                    </Label>
                                    <Popover open={open} onOpenChange={setOpen}>
                                        <PopoverTrigger asChild>
                                            <Button
                                                variant="outline"
                                                id="date"
                                                className="w-50 justify-between font-normal"
                                            >
                                                {date ? date.toLocaleDateString() : "Select date"}
                                                <ChevronDownIcon />
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                                            <Calendar
                                                mode="single"
                                                selected={date}
                                                captionLayout="dropdown"
                                                onSelect={(date) => {
                                                    setDate(date)
                                                    setOpen(false)
                                                }}
                                            />
                                        </PopoverContent>
                                    </Popover>
                                </div>
                                <div className="flex flex-col gap-3">
                                    <Label htmlFor="time" className="px-1">
                                        Start Time
                                    </Label>
                                    <Input
                                        type="time"
                                        id="time"
                                        step="1"
                                        defaultValue="10:30:00"
                                        className="bg-background appearance-none [&::-webkit-calendar-picker-indicator]:hidden [&::-webkit-calendar-picker-indicator]:appearance-none"
                                    />
                                </div>
                            </div>
                        </div>

                        <div className="flex w-50 items-center gap-4 mt-4">
                            <Button type="submit">
                                <Plus className="w-4 h-4 mr-2" />
                                Create Study Space
                            </Button>
                            <Button type="button" variant="outline">
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