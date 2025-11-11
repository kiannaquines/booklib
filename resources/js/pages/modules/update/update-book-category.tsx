import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { Button } from "@/components/ui/button";
import { ArrowLeft, FilePenLine, Loader2, RefreshCcw } from "lucide-react";
import { useForm, router, Head } from "@inertiajs/react";
import { toast } from "sonner";
import { useState } from "react";

type CategoryFormData = {
    id: number;
    name: string;
    description: string;
};

type UpdateBookCategoryProps = {
    category: CategoryFormData;
}

const UpdateBookCategory = ({ category }: UpdateBookCategoryProps) => {
    const { data, setData, reset, clearErrors } = useForm<CategoryFormData>({
        id: category.id,
        name: category.name,
        description: category.description || "",
    });

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: "Book Categories",
            href: route("book-categories.index"),
        },
        {
            title: "Edit Category",
            href: route("book-categories.edit", { id: data.id }),
        },
    ];

    const [processing, setProcessing] = useState(false);

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        setProcessing(true);
        e.preventDefault();
        router.put(route("book-categories.update", { id: data.id }), data, {
            preserveScroll: true,
            onSuccess: () => {
                toast.success("Book category updated successfully");
                setProcessing(false);
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
            <Head title="Edit Book Category" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
                <div className="flex justify-between items-center mb-4">
                    <Button variant="outline" onClick={() => router.visit(route("book-categories.index"))}>
                        <ArrowLeft className="w-4 h-4 mr-2" />
                        Back to Categories
                    </Button>
                </div>

                <div className="relative h-full flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-5">
                    <div className="flex flex-col gap-1">
                        <h2 className="text-lg font-semibold">Edit Book Category</h2>
                        <p className="text-sm text-muted-foreground">Update book category information</p>
                    </div>
                    <form onSubmit={handleSubmit} className="mt-4">
                        <div className="grid w-full items-center gap-4 mt-4">
                            <div className="flex flex-col space-y-1.5">
                                <Label htmlFor="name">Category Name</Label>
                                <Input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData("name", e.target.value)}
                                    placeholder="e.g., Fiction, Science Fiction, History"
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
                                    placeholder="Category description (optional)"
                                    rows={4}
                                />
                            </div>
                        </div>

                        <div className="flex items-center gap-4 mt-4">
                            <Button type="submit" disabled={processing}>
                                {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
                                {!processing && <FilePenLine className="w-4 h-4 mr-2" />}
                                Update Category
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

export default UpdateBookCategory;
