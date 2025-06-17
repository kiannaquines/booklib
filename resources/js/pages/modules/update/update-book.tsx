import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Button } from "@/components/ui/button";
import { ArrowLeft, FilePenLine, Loader2, Plus, RefreshCcw } from "lucide-react";
import { useForm, router, Head } from "@inertiajs/react";
import { toast } from "sonner";
import { useState } from "react";


type BookFormData = {
    id: string;
    title: string;
    author: string;
    status: string;
};

type CreateBookProps = {
    book: BookFormData;
}

const CreateBook = ({ book }: CreateBookProps) => {
    const { data, setData, reset, clearErrors } = useForm<BookFormData>({
        id: book.id,
        title: book.title,
        author: book.author,
        status: book.status,
    });

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: "Book",
            href: route("books.index"),
        },
        {
            title: "Edit Book",
            href: route("books.edit", { id: data.id }),
        },
    ];

    const [processing, setProcessing] = useState(false);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();
        router.put(route("books.update", { id: data.id }), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Book updated successfully");
                setProcessing(false);
                reset();
            },
            onError: (e) => {
                for (const [field, message] of Object.entries(e)) {
                    toast.error("Oops, please try again", {
                        description: `${message}`,
                    });
                }
                setProcessing(false);
            },
        });
    };

    const handleReset = () => {
        reset();
        clearErrors();
        toast.info("Form inputs reset.");
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Book Reservation" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route("books.index"))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Books
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Create Book</h2>
                        <p className="text-sm text-muted-foreground">Create a new book in the library</p>
                    </div>
                    <form onSubmit={handleSubmit} className="mt-4">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="title">Title</Label>
                                <Input
                                    id="title"
                                    type="text"
                                    value={data.title}
                                    onChange={(e) => setData("title", e.target.value)}
                                    placeholder="Title"
                                />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="author">Author</Label>
                                <Input
                                    id="author"
                                    type="text"
                                    value={data.author}
                                    onChange={(e) => setData("author", e.target.value)}
                                    placeholder="Author"
                                />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="status">Status</Label>
                                <Select value={data.status} onValueChange={(value) => setData("status", value)}>
                                    <SelectTrigger className="w-full">
                                        <SelectValue placeholder={data.status ? undefined : "Select status"} />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="Available">Available</SelectItem>
                                        <SelectItem value="Unavailable">Unavailable</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div className="flex items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <FilePenLine className="w-4 h-4 mr-2" />}
                                Update Book
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
};

export default CreateBook;