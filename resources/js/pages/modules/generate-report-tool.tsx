import { useState } from 'react'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/components/ui/command"
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover"
import { Button } from '@/components/ui/button';
import { CheckIcon, ChevronDownIcon, ChevronsUpDownIcon } from 'lucide-react';
import { cn } from '@/lib/utils';
import { Calendar } from '@/components/ui/calendar';
import { toast } from 'sonner';

type GenerateReportToolProps = {
    generateReportRoute: string
    status: any[]
    isCategoryIncluded?: boolean
}

const GenerateReportTool = ({ generateReportRoute, status, isCategoryIncluded = true, }: GenerateReportToolProps) => {
    const [open, setOpen] = useState(false)
    const [value, setValue] = useState("")

    const [openFromDate, setOpenFromDate] = useState(false)
    const [fromDate, setFromDate] = useState<Date | undefined>(undefined)
    const [openToDate, setOpenToDate] = useState(false)
    const [toDate, setToDate] = useState<Date | undefined>(undefined)
    return (
        <>
            <Popover open={openFromDate} onOpenChange={setOpenFromDate}>
                <PopoverTrigger asChild>
                    <Button
                        variant="outline"
                        id="fromDate"
                        className="w-48 justify-between font-normal"
                    >
                        {fromDate ? fromDate.toLocaleDateString() : "Select from date"}
                        <ChevronDownIcon />
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                    <Calendar
                        mode="single"
                        selected={fromDate}
                        captionLayout="dropdown"
                        onSelect={(date) => {
                            setFromDate(date)
                            setOpenFromDate(false)
                        }}
                    />
                </PopoverContent>
            </Popover>

            <Popover open={openToDate} onOpenChange={setOpenToDate}>
                <PopoverTrigger asChild>
                    <Button
                        variant="outline"
                        id="toDate"
                        className="w-48 justify-between font-normal"
                    >
                        {toDate ? toDate.toLocaleDateString() : "Select to date"}
                        <ChevronDownIcon />
                    </Button>
                </PopoverTrigger>
                <PopoverContent className="w-auto overflow-hidden p-0" align="start">
                    <Calendar
                        mode="single"
                        selected={toDate}
                        captionLayout="dropdown"
                        onSelect={(date) => {
                            setToDate(date)
                            setOpenToDate(false)
                        }}
                        disabled={(date) => {
                            if (fromDate) {
                                return date < fromDate
                            }
                            return false
                        }}
                    />
                </PopoverContent>
            </Popover>

            {isCategoryIncluded && (
                <Popover open={open} onOpenChange={setOpen}>
                    <PopoverTrigger asChild>
                        <Button
                            variant="outline"
                            role="combobox"
                            aria-expanded={open}
                            className="w-[200px] justify-between"
                        >
                            {value
                                ? (status ?? []).find((status) => status.value === value)?.label
                                : "Select status..."}
                            <ChevronsUpDownIcon className="ml-2 h-4 w-4 shrink-0 opacity-50" />
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent className="w-[200px] p-0">
                        <Command className='font-normal'>
                            <CommandInput placeholder="Search status..." className='font-normal' />
                            <CommandList>
                                <CommandEmpty className='font-normal text-sm text-muted-foreground p-2 text-center'>No status found.</CommandEmpty>
                                <CommandGroup>
                                    {(status ?? []).map((status) => (
                                        <CommandItem
                                            key={status.value}
                                            value={status.value}
                                            onSelect={(currentValue) => {
                                                setValue(currentValue === value ? "" : currentValue)
                                                setOpen(false)
                                            }}
                                        >
                                            <CheckIcon
                                                className={cn(
                                                    "mr-2 h-4 w-4",
                                                    value === status.value ? "opacity-100" : "opacity-0"
                                                )}
                                            />
                                            {status.label}
                                        </CommandItem>
                                    ))}
                                </CommandGroup>
                            </CommandList>
                        </Command>
                    </PopoverContent>
                </Popover>
            )}


            <Button
                onClick={() => {
                    if (!fromDate || !toDate || (isCategoryIncluded && !value)) {
                        toast.error('Please select from date, to date and status');
                        return;
                    }

                    const query: Record<string, string> = {
                        fromDate: fromDate.toISOString(),
                        toDate: toDate.toISOString(),
                    };

                    if (isCategoryIncluded) {
                        query.status = value;
                    }

                    const params = new URLSearchParams(query).toString();
                    window.open(`${generateReportRoute}?${params}`, '_blank');
                }}
            >
                Generate Report
            </Button>

        </>
    )
}

export default GenerateReportTool