import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
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
import { ArrowLeft, Loader2, Plus, RefreshCcw, Upload, X } from "lucide-react";
import { useForm, router, Head } from "@inertiajs/react";
import { toast } from "sonner";
import { useState } from "react";
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: "Book",
        href: route("books.index"),
    },
    {
        title: "Create Book",
        href: route("books.create"),
    },
];

type BookFormData = {
    title: string;
    author: string;
    image: File | null;
    description: string;
    status: string;
};

const CreateBook = () => {
    const { data, setData, reset, clearErrors } = useForm<BookFormData>({
        title: "",
        author: "",
        image: null,
        description: "",
        status: "",
    });

    const [processing, setProcessing] = useState(false);
    const [imagePreview, setImagePreview] = useState<string | null>(null);

    const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setData("image", file);
            const reader = new FileReader();
            reader.onloadend = () => {
                setImagePreview(reader.result as string);
            };
            reader.readAsDataURL(file);
        }
    };

    const removeImage = () => {
        setData("image", null);
        setImagePreview(null);
    };

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();
        router.post(route("books.store"), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Book created successfully");
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
        setImagePreview(null);
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
                                <Label htmlFor="description">Description</Label>
                                <Textarea
                                    id="description"
                                    value={data.description}
                                    onChange={(e) => setData("description", e.target.value)}
                                    placeholder="Book description (optional)"
                                    rows={4}
                                />
                            </div>
                        </div>

                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="image">Book Image</Label>
                                {imagePreview ? (
                                    <div className="relative w-full max-w-sm">
                                        <img
                                            src={imagePreview}
                                            alt="Preview"
                                            className="w-full h-48 object-cover rounded-lg border"
                                        />
                                        <Button
                                            type="button"
                                            variant="destructive"
                                            size="icon"
                                            className="absolute top-2 right-2"
                                            onClick={removeImage}
                                        >
                                            <X className="w-4 h-4" />
                                        </Button>
                                    </div>
                                ) : (
                                    <div className="flex items-center gap-4">
                                        <Input
                                            id="image"
                                            type="file"
                                            accept="image/*"
                                            onChange={handleImageChange}
                                            className="hidden"
                                        />
                                        <Label
                                            htmlFor="image"
                                            className="flex items-center gap-2 px-4 py-2 border rounded-md cursor-pointer hover:bg-accent"
                                        >
                                            <Upload className="w-4 h-4" />
                                            Upload Image
                                        </Label>
                                        <span className="text-sm text-muted-foreground">
                                            No image selected
                                        </span>
                                    </div>
                                )}
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
                                {!processing && <Plus className="w-4 h-4 mr-2" />}
                                Create Book
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